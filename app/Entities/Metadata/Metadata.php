<?php

namespace App\Entities\Metadata;

use Illuminate\Database\Eloquent\Model;

class Metadata extends Model
{
    
    public function currencys()
    {
        return $this->hasMany('App\Entities\Metadata\Currency');
    }
    
    
    public function database()
    {
        return $this->hasMany('App\Entities\Metadata\Database');
    }
    
    
    public function dataset()
    {
        return $this->hasMany('App\Entities\Metadata\Dataset');
    }
    
    
    public function isin()
    {
        return $this->hasMany('App\Entities\Metadata\Isin');
    }
    
    
    public function name()
    {
        return $this->hasMany('App\Entities\Metadata\Name');
    }
    
    
    public function provider()
    {
        return $this->hasMany('App\Entities\Metadata\Provider');
    }
    
    
    public function sector()
    {
        return $this->hasMany('App\Entities\Metadata\Sector');
    }
    
    
    public function wkn()
    {
        return $this->hasMany('App\Entities\Metadata\Wkn');
    }
}
