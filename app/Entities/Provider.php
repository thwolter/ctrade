<?php

namespace App\Entities;


use Illuminate\Database\Eloquent\Model;
use App\Entities\Datasource;

class Provider extends Model
{
    protected $fillable = [
        'code', 'name'
    ];
    
   public function datasources()
   {
       return $this->hasMany(Datasource::class);
   }
}
