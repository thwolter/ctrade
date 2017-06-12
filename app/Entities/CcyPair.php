<?php

namespace App\Entities;

use App\Entities\Datasource;
use App\Repositories\Financable;
use App\Repositories\DataRepository;
use App\Repositories\Quandl\Quandldata;
use Illuminate\Database\Eloquent\Model;

class CcyPair extends Model
{

    use Financable;
    

    protected $financial = DataRepository::class;

    protected $fillable = ['origin', 'target'];


    public function datasources()
    {
        return $this->morphToMany(Datasource::class, 'sourcable')->withTimestamps();
    }


    public function symbol()
    {
        return $this->origin.$this->target;
    }


    public function history()
    {
        return $this->financial()->history();
    }


    public function price()
    {
        return $this->financial()->price();
    }
}
