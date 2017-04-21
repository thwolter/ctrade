<?php

namespace App\Entities;

use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Yahoo\Financable;
use Illuminate\Support\Facades\Storage;


class Portfolio extends Model
{

    use Financable;

    use Presentable;

    
    protected $presenter = 'App\Presenters\Portfolio';
    
    protected $financial = 'App\Repositories\Yahoo\CurrencyFinancial';
    
    protected $fillable = [
        'name',
        'currency',
        'cash'
    ];
    
    

    public function user() {
        return $this->belongsTo('App\Entities\User');
    }

    public function positions() {
        return $this->hasMany('App\Entities\Position');
    }

    public function cash() {
        return $this->cash;
    }

    public function valueAtRisk() {
        //
    }

    public function currency()
    {
        return $this->currency;
    }

    public function total()
    {
        return $this->positions->sum->total($this->currency());
    }
    
    public function value()
    {
        return $this->total() + $this->cash();
    }
    
    public function toArray()
    {
        $array = [
            'meta' => ['name' => $this->name, 'currency' => $this->currency],
            'cash' => ['amount' => $this->cash, 'currency' => $this->currency],
            'item' => []
        ];

        $i = 0;
        foreach($this->positions as $position) {

            $array['item'][$i++] = $position->toArray();

        }

        return $array;
    }


    public function saveJSON()
    {
        $filename = uniqid().'.json';
        Storage::disk('local')->put($filename, json_encode($this->toArray()));

        return $filename;
    }

}

