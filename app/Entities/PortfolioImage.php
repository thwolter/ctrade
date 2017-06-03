<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PortfolioImage extends Model
{
    protected $table = 'portfolio_images';

    protected $fillable = ['path'];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }

    public function addImage(Request $request)
    {
        $file = $request->file('file');
        $file->store('images');
    }

}
