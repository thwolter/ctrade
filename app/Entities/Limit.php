<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Limit extends Model
{
    protected $fillable = ['type', 'limit'];


    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }


    public function type() {
        return $this->belongsTo(LimitType::class);
    }

    public function toArray()
    {
        return [$this->updated_at->toDateString() => $this->limit];
    }
}
