<?php

namespace App\Entities;

use App\Models\Rscript\Rscriptable;
use App\Presenters\Presentable;
use App\Settings\PortfolioSettings;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Financable;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\UploadedFile;


class Portfolio extends Model
{
    use Financable;
    use Presentable;
    use Rscriptable;

    protected $presenter = 'App\Presenters\Portfolio';
    protected $financial = 'App\Repositories\Yahoo\PortfolioFinancial';
    protected $rscriptable = 'App\Models\Rscript\Portfolio';
    
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
        return (! is_null($file)) ? 'images/'.$file->path : null;

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
            'name' => $this->name,
            'currency' => $this->currencyCode(),
            'cash' => $this->cash,
            'item' => []
        ];
        $i = 0;
        foreach($this->positions as $position) {

            $array['item'][$i++] = $position->toArray();
        }
        return $array;
    }
    
    
    public function history(String $currency, Carbon $from = null, Carbon $to = null)
    {
        $symbol = $this->currency().$currency;

        $json = $this->financial()->history($symbol, $from, $to);

        return $json;
    }
    
    
    public function makePosition($instrument)
    {
        $position = $this->positionWith($instrument);

        if (is_null($position))
        {
            $position = new Position(['amount' => 0]);
            $position->positionable()->associate($instrument);
            $this->positions()->save($position);
        }

        return $position;
    }

    /**
     * A buy or sell transaction on the portfolio with a given position id.
     * As default the transaction is being settled with portfolio's cash.
     *
     * @param int $id the position id
     * @param float $amount the transaction's amount
     * @return Portfolio
     */
    public static function buy($id, $amount)
    {
        $position = Position::find($id);
        $portfolio = $position->portfolio;

        $newAmount = $position->amount + $amount;

        if ($newAmount == 0) {
            $position->delete();
        }
        else {
            $position->update(['amount' => $newAmount]);
        }

        $portfolio->cash = $portfolio->cash - $amount * array_first($position->price());
        $portfolio->save();

        return $portfolio;
    }


    public static function sell($id, $amount)
    {
        return self::buy($id, -$amount);
    }


    public function deposit($amount)
    {
        $this->cash = $this->cash + $amount;
    }

    public function withdraw($amount)
    {
        $this->cash = $this->cash - $amount;
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

        \Storage::delete($this->imagesPath.$this->image->path);

        $file->storeAs($this->imagesPath, $image->path);
        $this->image->path = $image->path;

        $this->image->update();

        return $this;
    }

    public function deleteImage()
    {
        \Storage::delete('public/images/'.$this->image->path);

    }


}
