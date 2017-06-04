<?php

namespace App\Entities;

use App\Models\Rscript\Rscriptable;
use App\Entities\Currency;
use App\Presenters\Presentable;
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
        'name', 'cash', 'description', 'img_url'
    ];

    protected $imagesPath = 'public/images';



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


    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function currency()
    {
        return $this->belongsTo(Currency::class);
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
    
    
    public function obtain($amount, $instrument)
    {
        $position = $this->positionWith($instrument);

        if (is_null($position))
        {
            $position = new Position(['amount' => 0]);
            $position->positionable()->associate($instrument);
        }

        $position->amount = $position->amount + $amount;
        $this->positions()->save($position);

        return $this;
    }


    public function buy($amount, $instrument)
    {
        $this->cash = $this->cash - $amount * array_first($instrument->price());;
        return $this->obtain($amount, $instrument)->save();
    }


    public function sell($amount, $instrument)
    {
        $this->buy(-$amount, $instrument);

        if ($this->positionWith($instrument)->amount == 0)
            $this->position->delete();

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
