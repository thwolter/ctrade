<?php

namespace App\Entities\Metadata;

use Illuminate\Database\Eloquent\Model;

class Metadata extends Model
{
    protected $fillable = [
        'symbol', 'name_id', 'currency_id', 'provider_id',
        'database_id', 'wkn_id', 'isin_id', 'sector_id'
    ];


    public function currency()
    {
        return $this->belongsTo('App\Entities\Metadata\Currency');
    }
    
    
    public function database()
    {
        return $this->belongsTo('App\Entities\Metadata\Database');
    }
    
    
    public function isin()
    {
        return $this->belongsTo('App\Entities\Metadata\Isin');
    }
    
    
    public function name()
    {
        return $this->belongsTo('App\Entities\Metadata\Name');
    }
    
    
    public function provider()
    {
        return $this->belongsTo('App\Entities\Metadata\Provider');
    }
    
    
    public function sector()
    {
        return $this->belongsTo('App\Entities\Metadata\Sector');
    }
    
    
    public function wkn()
    {
        return $this->belongsTo('App\Entities\Metadata\Wkn');
    }
}
