<?php

namespace App\Entities;


use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $fillable = [
        'code', 'name'
    ];
    
   
}
