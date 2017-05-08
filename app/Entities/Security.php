<?php

namespace App\Entities;

use App\Entities\Dataset;
use Illuminate\Database\Eloquent\Model;

class Security extends Model
{

    public function datasets()
    {
        return $this->hasMany(Dataset::class);
    }
}
