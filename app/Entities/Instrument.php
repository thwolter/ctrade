<?php


namespace App\Entities;


use App\Entities\Exceptions\InstrumentException;
use App\Models\Pathway;
use App\Repositories\Contracts\InstrumentInterface;
use App\Repositories\FinancialRepository;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use App\Repositories\Financable;
use App\Repositories\Quandl\Quandldata;


abstract class Instrument extends Model
{

    protected $financial;
    
    use Financable;
    
   
    public function positions()
    {
        return $this->morphMany(Position::class, 'positionable');
    }


    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }


    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }
    
    
    public function datasets()
    {
        return $this->morphToMany(Dataset::class, 'datasetable')->withTimestamps();
    }



    public function type()
    {
        return $this->financial()->type();
    }


    public function pathway()
    {
        return Pathway::withDatasets($this->datasets);
    }


    public function price()
    {
        //Todo: instead of first path, perhaps implement priority or loop?
        $path = $this->pathway()->first();
        return $path->provider->financial($path)->price();
    }


    public function history($params = ['limit' => 250])
    {
        $path = $this->pathway()->first();
        return $path->provider->financial($path)->history($params);
    }

   

}