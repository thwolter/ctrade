<?php

namespace App\Entities;

use App\Entities\History;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $fillable = [
        'code',
        'name',
        'taxonomy'
    ];

}
