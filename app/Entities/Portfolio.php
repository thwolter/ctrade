<?php

namespace App\Entities;

use App\Presenters\Presentable;
use App\Settings\PortfolioSettings;
use App\Settings\Settings;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Financable;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\UploadedFile;


class Portfolio extends Model
{
    use Presentable;

    protected $presenter = 'App\Presenters\Portfolio';

    protected $fillable = [
        'name', 'cash', 'description', 'settings', 'img_url'
    ];


    protected $casts = [
        'settings' => 'json'
    ];

    public $imagesPath = 'public/images';


    public function getCategoryNameAttribute()
    {
        $default = $this->category;
        return (!is_null($default)) ? $default->name : 'keine Kategorie';
    }

    public function getImageUrlAttribute()
    {
        $file = $this->image;
        return (!is_null($file)) ? 'images/' . $file->path : null;

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function image()
    {
        return $this->hasOne(PortfolioImage::class);
    }

    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function keyFigure($code)
    {
        $type = KeyfigureType::whereCode($code)->first();

        if (!is_null($type))
            return $this->keyFigures()->whereTypeId($type->id)->first();
    }

    public function createKeyFigure($code, $name)
    {
        $type = KeyfigureType::firstOrCreate(['code' => $code, 'name' => $name]);
        $keyfigure = new Keyfigure();

        $keyfigure->type()->associate($type)->portfolio()->associate($this)->save();

        return $keyfigure;
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function keyFigures()
    {
        return $this->hasMany(Keyfigure::class);
    }

    public function settings($key = null)
    {
        $settings = new PortfolioSettings($this);

        return $key ? $settings->get($key) : $settings;
    }

    public function currencyCode()
    {
        return $this->currency->code;
    }

    public function cash()
    {
        return $this->cash;
    }

    public function stockTotal()
    {
        return $this->positions->sum->total($this->currencyCode());
    }


    public function total()
    {
        return $this->stockTotal() + $this->cash();
    }


    public function value()
    {
        return $this->total() + $this->cash();
    }


    public function setCurrency($code)
    {
        $this->currency()->associate(Currency::firstOrCreate(['code' => $code]));
    }


    public function saveKeyFigure($key, $value, $date)
    {
        $keyFigure = Keyfigure::make($key, $value, $date);
        $this->keyFigures()->save($keyFigure);

        return $this;
    }

    public function toArray()
    {
        $array = [
            'meta' => [
                'name' => $this->name,
                'currency' => $this->currencyCode(),
                'cash' => $this->cash
            ],
            'items' => []
        ];

        foreach ($this->positions as $position) {

            $array['items'][$position->id] = $position->toArray();
        }
        return $array;
    }


    public function makePosition($instrument)
    {
        $position = $this->positionWith($instrument);

        if (is_null($position)) {
            $position = new Position(['amount' => 0]);
            $position->positionable()->associate($instrument);
            $this->positions()->save($position);
        }

        return $position;
    }


    /**
     * A buy transaction for position with a given id.
     *
     * @param int $id the position id
     * @param float $amount the transaction's amount
     * @return Portfolio
     */
    public function buy($id, $amount)
    {
        $this->makeTrade($id, $amount)->save();
        return $this;
    }


    /**
     * A sell transaction for position with a given id
     *
     * @param $id
     * @param $amount
     * @return mixed
     */
    public function sell($id, $amount)
    {
        $this->makeTrade($id, -$amount)->save();
        return $this;
    }


    /**
     * Deposit an amount of cash.
     *
     * @param int $amount
     * @return $this
     */
    public function deposit($amount)
    {
        $this->cash = $this->cash + $amount;
        $this->save();
        return $this;
    }

    /**
     * Withdraw an amount of cash.
     *
     * @param int $amount
     * @return $this
     */
    public function withdraw($amount)
    {
        $this->cash = $this->cash - $amount;
        $this->save();
        return $this;
    }

    public function positionWith($instrument)
    {
        $type = array_search(get_class($instrument), Relation::morphMap());

        return $this->positions()
            ->where('positionable_id', $instrument->id)
            ->where('positionable_type', $type)
            ->first();
    }

    public function addImage(UploadedFile $file)
    {
        $image = PortfolioImage::fromForm($file);
        $file->storeAs($this->imagesPath . '', $image->path);

        return $this->image()->save($image);
    }


    public function updateImage(UploadedFile $file)
    {
        $image = PortfolioImage::fromForm($file);

        \Storage::delete($this->imagesPath . $this->image->path);

        $file->storeAs($this->imagesPath, $image->path);
        $this->image->path = $image->path;

        $this->image->update();

        return $this;
    }

    public function deleteImage()
    {
        \Storage::delete('public/images/' . $this->image->path);

    }

    /**
     * Rolls the portfolio transaction back to the provided date.
     *
     * @param $date
     * @return Portfolio
     */
    public function rollbackToDate($date)
    {
        $portfolio = clone $this;
        $transactions = $this->transactions->where('date', '>', $date)->all();

        foreach (array_reverse($transactions) as $transaction) {

            $value = $transaction->amount * $transaction->price;
            switch ($transaction->type->code) {
                case 'buy':
                    $portfolio->revertTrade($transaction->position->id, -$value);
                    break;
                case 'sell':
                    $portfolio->revertTrade($transaction->position->id, +$value);
                    break;
            }
        }
        return $portfolio;
    }



    /*
     * private functions
     */

    /**
     * Make a Trade without persisting
     *
     * @param int $id of position
     * @param $amount
     * @return mixed
     */
    private function makeTrade($id, $amount)
    {
        $position = Position::find($id);
        $portfolio = $position->portfolio;

        $position->update(['amount' => $position->amount + $amount]);

        $portfolio->cash = $portfolio->cash - $amount * array_first($position->price());
        return $portfolio;
    }

    private function revertTrade($id, $value)
    {
        $position = $this->positions()->find($id);

        $position->amount = $position->amount + $value;
        $this->cash = $this->cash - $value;

        return $this;
    }
}
