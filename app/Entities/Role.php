<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function user()
    {
        $this->belongsToMany(User::class);
    }
}
