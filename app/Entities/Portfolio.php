<?php

namespace App\Entities;

use App\Models\Rscript\Rscriptable;
use App\Entities\Currency;
use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Financable;
use Illuminate\Database\Eloquent\Relations\Relation;


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


    public function getCategoryNameAttribute()
    {
        $default = $this->category;
        return (!is_null($default)) ? $default->name : 'keine Kategory';
    }

    public function getImageUrlAttribute()
    {
        $default = $this->img_url;
        return ($default);
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


    public function positionsTotal()
    {
        return $this->positions->sum->total($this->currencyCode());
    }


    public function total()
    {
        return $this->positionsTotal()+$this->cash();
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

    public function positionWith($instrument)
    {
        $type = array_search(get_class($instrument), Relation::morphMap());

        return $this->positions()
            ->where('positionable_id', $instrument->id)
            ->where('positionable_type', $type)
            ->first();
    }

}
