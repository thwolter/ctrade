<?php

namespace App\Models;


use App\Entities\Provider;
use App\Entities\Database;
use App\Entities\Dataset;
use App\Models\Exceptions\PathwayException;
use Illuminate\Database\Eloquent\Collection;


class Pathway
{
    private $theProvider;
    private $theDatabase;
    private $theDataset;

    private $path;
    private $pathPointer;

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
        $rc = new \ReflectionClass($instrument);
        $model = str_plural(strtolower($rc->getShortName()));

        $this->theDataset->save();

        if (! $this->theDataset->$model->contains($instrument->id)) {
            $this->theDataset->$model()->attach($instrument->id);
        }
        
        return $this->save();
    }
    
    static public function withDatasetCode($code)
    {
        return Pathway::withDatasets(Dataset::whereCode($code)->get());
    }


    static public function withDatasetId($id)
    {
        return Pathway::withDatasets(Dataset::whereId($id)->get());
    }
    

    static public function withDatasets($datasets)
    {
        if (get_class($datasets) != Collection::class) {
            throw new PathwayException("expect class '{Collection::class}', given was '{get_class($datasets)}");
        }

        if (!count($datasets)) {
            throw new PathwayException("empty collection 'datasets' cannot be evaluated");
        }

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
        return $this->setVariables();
    }


    public function next()
    {
        if ($this->pathPointer++ == count($this->path) - 1)
           return null;

        return $this->setVariables();
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
        $this->theDatabase->save();
        $this->theProvider->save();

        if (! $this->theDatabase->datasets->contains($this->theDataset->id)) {
            $this->theDatabase->datasets()->attach($this->theDataset->id);
        }

        if (! $this->theProvider->databases->contains($this->theDatabase->id)) {
            $this->theProvider->databases()->attach($this->theDatabase->id);
        }
        
        return $this;
    }


    private function setVariables()
    {
        if (! isset($this->pathPointer))
            throw new PathwayException("Call to method 'first()' missing");

        $path = $this->path[$this->pathPointer];

        $this->provider = $path['provider'];
        $this->database = $path['database'];
        $this->dataset = $path['dataset'];

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