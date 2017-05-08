<?php


namespace App\Entities;


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
        return $this->belongsToMany(Dataset::class)->withTimestamps();
    }
    
    
    public function pathway()
    {
        $pathway = null;
        
        foreach ($this->datasets as $dataset)
        {
            foreach ($dataset->databases as $database)
            {
                foreach ($database->providers as $provider)
                {
                    $pathway[] = [
                        'provider' => $provider->id,
                        'database' => $database->id,
                        'dataset'  => $dataset->id
                    ];
                }
            }
        }
        
        return $pathway;
    }
    
    
    public function price()
    {
       
        $pathway = $this->pathway()[0];
        
        switch(Provider::find($pathway['provider'])->name) 
        {
            case 'Quandl':
                return Quandldata::make()->price($pathway);
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