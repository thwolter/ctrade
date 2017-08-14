<?php

namespace App\Entities;

use App\Entities\Traits\hasAliases;
use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    use hasAliases;

    protected $fillable = ['code', 'name'];

    public function datasources()
    {
        return $this->hasMany(Datasource::class);
    }

    public function mappings()
    {
        return $this->morphMany(Alias::class, 'mappable');
    }


}
