<?php

namespace App\Entities;

use App\Models\Pathway;
use App\Repositories\Financable;
use App\Repositories\DataRepository;
use App\Repositories\Quandl\Quandldata;
use Illuminate\Database\Eloquent\Model;

class CcyPair extends Model
{

    use Financable;

    protected $financial = Quandldata::class;


    protected $fillable = ['origin', 'target'];


    public function datasets()
    {
        return $this->morphToMany(Dataset::class, 'datasetable')->withTimestamps();
    }


    public function pathway()
    {
        return Pathway::withDatasets($this->datasets);
    }


    public function symbol()
    {
        return $this->origin.$this->target();
    }


    public function history($parameter = ['limit' => 250])
    {
        return $this->financial()->history($parameter);
    }


    public function price()
    {
        return $this->financial()->price();
    }
}
