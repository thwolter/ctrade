<?php

namespace App\Entities;

use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Yahoo\Financable;

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
}

