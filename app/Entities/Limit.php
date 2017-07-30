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


    public function toArray()
    {
        return [$this->updated_at->toDateString() => $this->limit];
    }


    public function scopeAbsolute($query)
    {
        return $query->whereType('absolute');
    }


    public function scopeRelative($query)
    {
        return $query->whereType('relative');
    }
}
