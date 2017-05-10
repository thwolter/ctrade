<?php

namespace App\Models;


use App\Entities\Provider;
use App\Entities\Database;
use App\Entities\Dataset;
use App\Models\Exceptions\PathwayException;


class Pathway
{
    private $theProvider;
    private $theDatabase;
    private $theDataset;

    private $path;
    private $pathPointer = 0;

    public $provider = null;
    public $database = null;
    public $dataset = null;

    
    public function __construct($codeArray = null, $path = [])
    {
        if (!is_null($codeArray)) {
            $this->provider($codeArray['provider'])
                ->database($codeArray['database'])
                ->dataset($codeArray['dataset']);
        }

        $this->path = $path;

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
        //Todo: check if already assigned, in this case do nothing
        $rc = new \ReflectionClass($instrument);
        $model = str_plural(strtolower($rc->getShortName()));

        $this->theDataset->save();
        $this->theDataset->$model()->attach($instrument->id);
        
        $this->save();
        
        return $this;
    }
    

    static public function withDatasets($datasets)
    {
        $path = [];
        foreach ($datasets as $dataset) {
            foreach ($dataset->databases as $database) {
                foreach ($database->providers as $provider) {
                    $path[] = [
                        'provider' => $provider,
                        'database' => $database,
                        'dataset'  => $dataset
                    ];
                }
            }
        }

        return new Pathway(null, $path);
    }

    public function first()
    {
        $this->pathPointer = 0;

        $this->setVariables();
        return $this;
    }

    public function next()
    {
        if ($this->pathPointer == count($this->path))
           return null;

        $this->pathPointer++;

        $this->setVariables();
        return $this;
    }

    private function setVariables()
    {
        $path = $this->path[$this->pathPointer];

        $this->provider = $path['provider'];
        $this->database = $path['database'];
        $this->dataset = $path['dataset'];
    }
    
    public function provider($value)
    {
        $this->theProvider = $this->setMetaObject(Provider::class, $value);
        return $this;
    }
    
    
    public function database($value)
    {
        $this->theDatabase = $this->setMetaObject(Database::class, $value);
        return $this;
    }
    
    
    public function dataset($value)
    {
        $this->theDataset = $this->setMetaObject(Dataset::class, $value);
        return $this;
    }
    
    
    
    public function save()
    {
        //Todo: check if alread assigned and do nothing in this case
        $this->theDatabase->save();
        $this->theProvider->save();

        $this->theDatabase->datasets()->attach($this->theDataset->id);
        $this->theProvider->databases()->attach($this->theDatabase->id);
        
        return $this;
    }
    
    
    private function setMetaObject($class, $value)
    {
        $meta = null;
       
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

        if (is_null($meta))
            throw new PathwayException("value for class '{$class}' missing");

        return $meta;
    }
    
}