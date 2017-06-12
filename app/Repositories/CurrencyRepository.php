<?php


namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Exceptions\MetadataException;
use App\Repositories\Quandl\Quandldata;
use MathPHP\Functions\Map;


class CurrencyRepository
{

    protected $origin;
    protected $tarbet;

    protected $primaryRepo;
    protected $originRepo;
    protected $targetRepo;
   
    protected $paramter = [
        'limit' => 250
    ];
    
    protected $baseCurrency = 'EUR';
    
    
   
    public function __construct($origin, $target)
    {
        $this->origin = $origin;
        $this->target = $target;
        
        $this->setRepositories();
    }


    public function price()
    {
        return isset($this->primaryRepo) ? $this->primaryRepo->price() : $this->calculatePrice();
    }


    public function history()
    {
        return isset($this->primaryRepo) ? $this->primaryRepo->history() : $this->calculateHistory();
    }


   
    private function setRepositories()
    {
        $source = Datasource::withDataset($this->origin.$this->target); 
        
        if (!is_null($datasource)) 
            
            $this->primaryRepo = new DataRepository($sources);
        
        else {
            
            $this->originRepo = new DataRepository(Datasource::withDataset($this->baseCurrency.$this->origin));
            $this->targetRepo = new DataRepository(Datasource::withDataset($this->baseCurrency.$this->target));
        }
    }
    
   
    private function calculateHistory()
    {
        if ($this->origin == $this->target):
            return array_pad([], $this->parameter['limit'], 1);

        elseif ($this->origin == $this->baseCurrency): 
            return $this->originRepo->history();
        
        elseif ($this->target == $this->baseCurrency): 
            return $this->inverse($this->targetRepo->history());
        
        else:
            return $this->divide($this->targetRepo->history(), $this->originRepo->history());
        
        endif;
    }

    
    protected function inverse($x)
    {
        return $this->divide($this->array_pad([], 1), $x);
    }


    public function divide($x, $y)
    {
        $quotient = Map\Multi::divide($x, $y);
        return array_combine(keys($y), $quotient);
    }

}