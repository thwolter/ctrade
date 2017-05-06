<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Dataset extends Model
{
    protected $fillable = [
        'code'
    ];

    public function databases()
    {
        return $this->belongsToMany(Database::class)->withTimestamps();
    }

    public function stocks()
    {
        return $this->belongsToMany(Stock::class)->withTimestamps();
    }


}
