<?php

namespace App\Entities;

use App\Repositories\Exceptions\MetadataException;
use App\Repositories\Quandl\Quandldata;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $fillable = [
        'code', 'name'
    ];
    
    public function databases()
    {
        return $this->belongsToMany(Database::class)->withTimestamps();
    }


}
