<?php

namespace App\Entities;

use App\Repositories\Exceptions\MetadataException;
use App\Repositories\Quandl\Quandldata;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $fillable = [
        'code', 'name'
    ];
    
    public function databases()
    {
        return $this->belongsToMany(Database::class)->withTimestamps();
    }

    public function financial($path)
    {
        switch($this->code)
        {
            case 'Quandl': return Quandldata::make($path); break;
            case 'others'; // break;
            default:
                throw new MetadataException("No financial available for provider code '{$this->code}''");
        }
    }

}
