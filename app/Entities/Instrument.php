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

    
    
    public function price()
    {
        //Todo: instead of first path, perhaps implement priority or loop?

        if (! count($this->datasets)) {
            $cls = get_class($this);
            throw new InstrumentException("no dataset assigned to class '{$cls}'' with name '{$this->name}''");
        }

        $path = Pathway::withDatasets($this->datasets)->first();
        
        switch($path->provider->code)
        {
            case 'Quandl':
                return Quandldata::make($path)->price();
                break;

            case 'others':
                //
                break;
        } 
    }


    public function type()
    {
        return $this->financial()->type();
    }



    

    public function history(Carbon $from = null, Carbon $to = null)
    {
        return $this->financial()->history($this->symbol(), $from, $to);
    }

   

}