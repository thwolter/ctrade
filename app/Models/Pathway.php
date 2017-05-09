<?php

namespace App\Models;


use App\Entities\Provider;
use App\Entities\Database;
use App\Entities\Dataset;
use App\Models\Exceptions\PathwayException;


class Pathway
{
    protected $provider;
    protected $database;
    protected $dataset;
    
    
    
    public function __construct($codeArray = [])
    {
        $this->provider($codeArray['provider'])
            ->database($codeArray['database'])
            ->dataset($codeArray['dataset']);
    }
    
    
    static public function make($provider, $database, $dataset)
    {
        return new Pathway([
            'provider' => $provider, 
            'database' => $database, 
            'dataset' => $dataset
        ]);
    }
    
    
    public function assign($instrument)
    {
        $rc = new \ReflectionClass($instrument);
        $model = str_plural(strtolower($rc->getShortName()));

        $this->dataset->save();
        $this->dataset->$model()->attach($instrument->id);
        
        $this->save();
        
        return $this;
    }
    

    
    public function provider($value)
    {
        $this->provider = $this->setMetaObject(Provider::class, $value);
        return $this;
    }
    
    
    public function database($value)
    {
        $this->database = $this->setMetaObject(Database::class, $value);
        return $this;
    }
    
    
    public function dataset($value)
    {
        $this->dataset = $this->setMetaObject(Dataset::class, $value);
        return $this;
    }
    
    
    
    public function save()
    {
        $this->database->save();
        $this->provider->save();
        
        $this->database->datasets()->attach($this->dataset->id);
        $this->provider->databases()->attach($this->database->id);
        
        return $this;
    }
    
    
    private function setMetaObject($class, $value)
    {
       
        switch(gettype($value))
        {
            case 'integer':
                $meta = $class::findOrFail($value)->first();
                break;
                
            case 'string':
                $meta = $class::firstOrNew(['code' => $value]);
                break;
                
            case 'object':
                if (get_class($value) == $class) 
                    $meta = $value;
                break;
        }
        
        if (! isset($meta))
            throw new PathwayException("value '{$value}' ");
            
        return $meta;
    }
    
}