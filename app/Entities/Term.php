<?php

namespace App;

use App\Entities\History;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $fillable = [
        'code',
        'name',
        'taxonomy'
    ];

    public function history()
    {
        return $this->hasMany(History::class);
    }
}
