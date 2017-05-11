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

use MathPHP\Statistics\Circular;
use MathPHP\Probability\Distribution\Table;
use MathPHP\Statistics\Average;


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

   
   public function VaR()
   {
        $data = $this->history([
           'limit' => 250,
           'column_index' =>3
        ]);
        
        $x = array_column($data, 1);
        
        $count = count($x) - 1;
        for ($i = 0; $i < $count; $i++) {
            $return[] = $x[$i] / $x[$i+1] - 1;
        }
        
        $VaR = 2.33 * Circular::standardDeviation($return) * $x[0];
        $mean = Average::mean($return);
        
        $result = [
            'VaR' => $VaR,
            'mean' => $mean,
            'expect' => $x[0] * (1 + $mean),
            'range' => [$x[0] - $VaR, $x[0] + $VaR],
            'price' => $x[0]
        ];
        
        return $result;
   }

}