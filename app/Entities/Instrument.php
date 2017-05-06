<?php


namespace App\Entities;


use App\Entities\Metadata\Metadata;
use App\Repositories\Contracts\InstrumentInterface;
use App\Repositories\FinancialRepository;
use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use App\Repositories\Financable;


abstract class Instrument extends Model
{

    protected $financial;
    
    use Financable;
    
   
    public function positions()
    {
        return $this->morphMany(Position::class, 'positionable');
    }


    public function price()
    {
        return $this->financial()->price($this->symbol);
    }


    public function symbol()
    {
        return $this->symbol;
    }


    public function type()
    {
        return $this->financial()->type();
    }


    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }


    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }
    

    public function history(Carbon $from = null, Carbon $to = null)
    {
        return $this->financial()->history($this->symbol(), $from, $to);
    }

    public function datasets()
    {
        return $this->belongsToMany(Dataset::class)->withTimestamps();
    }
}