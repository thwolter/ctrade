<?php

namespace App\Entities\Metadata;

use Illuminate\Database\Eloquent\Model;

class Metadata extends Model
{
    protected $fillable = [
        'symbol', 'provider_id', 'database_id',
        'instrumentable_id', 'instrumentable_type'
    ];


    public function instrumentable()
    {
        return $this->morphTo();
    }

    public function currency()
    {
        return $this->belongsTo('App\Entities\Metadata\Currency');
    }
    
    
    public function database()
    {
        return $this->belongsTo('App\Entities\Metadata\Database');
    }
    

    
    public function provider()
    {
        return $this->belongsTo('App\Entities\Metadata\Provider');
    }
    
    
    public function sector()
    {
        return $this->belongsTo('App\Entities\Metadata\Sector');
    }

}
