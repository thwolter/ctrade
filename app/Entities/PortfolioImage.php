<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

/**
 * App\Entities\PortfolioImage
 *
 * @property int $id
 * @property int $portfolio_id
 * @property string $path
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Entities\Portfolio $portfolio
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\PortfolioImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\PortfolioImage whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\PortfolioImage wherePath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\PortfolioImage wherePortfolioId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entities\PortfolioImage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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

        $image->path = time() . $file->getClientOriginalName();

        return $image;

    }
}
