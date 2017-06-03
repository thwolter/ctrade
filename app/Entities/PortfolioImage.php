<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class PortfolioImage extends Model
{
    protected $table = 'portfolio_images';

    protected $fillable = ['path'];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }


    public static function fromForm(UploadedFile $file)
    {
        $image = new static;

        $image->path = time() . $file->getClientOriginalName();;

        return $image;

    }
}
