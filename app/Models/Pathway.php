<?php

namespace App\Models;


use App\Entities\Provider;
use App\Entities\Database;
use App\Entities\Dataset;
use App\Models\Exceptions\PathwayException;
use Illuminate\Database\Eloquent\Collection;


class Pathway
{
    private $path;
    private $pathPointer;

    // instances of classes
    public $provider = null;
    public $database = null;
    public $dataset = null;

    
    public function __construct($codes = null, $path = [])
    {
        if (!is_null($codes)) {
            $this->provider($codes['provider'])
                ->database($codes['database'])
                ->dataset($codes['dataset']);
        }

        $this->path = $path;
    }


    public function __toString()
    {
        return $this->string();
    }


    static public function make($provider, $database, $dataset)
    {
        return new Pathway([
            'provider' => $provider,
            'database' => $database, 
            'dataset' => $dataset
        ]);
    }


    static public function get($providerCode, $databaseCode, $datasetCode)
    {
        $datasets = Dataset::whereCode($datasetCode)->get();
        
        if (count($datasets))
        {
            $pathway = self::withDatasets($datasets)->first();
        
            $count = count($pathway->path);
            for ($i = 0; $i < $count; $i++) {
            
                if (($pathway->provider->code == $providerCode) and ($pathway->database->code == $databaseCode))
                    return $pathway;
            }
        }
        
        return null;
    }
    
    
    static public function exist($providerCode, $databaseCode, $datasetCode)
    {
        return ! is_null(self::get($providerCode, $databaseCode, $datasetCode));
    }


    public function assign($instrument)
    {
        $rc = new \ReflectionClass($instrument);
        $model = str_plural(strtolower($rc->getShortName()));

        $this->dataset->save();

        if (! $this->dataset->$model->contains($instrument->id)) {
            $this->dataset->$model()->attach($instrument->id);
        }
        
        return $this->save();
    }
    
    static public function withDatasetCode($code)
    {
        $datasets = Dataset::whereCode($code)->get();

        if (!count($datasets))
            throw new PathwayException("No dataset assigned to code '{$code}'");

        return Pathway::withDatasets($datasets);
    }


    static public function withDatasetId($id)
    {
        $datasets = Dataset::whereId($id)->get();

        if (!count($datasets))
            throw new PathwayException("No dataset assigned to id '{$id}'");

        return Pathway::withDatasets($datasets);
    }
    

    static public function withDatasets($datasets)
    {
        if (get_class($datasets) != Collection::class) {
            throw new PathwayException("expect class '{Collection::class}', given was '{get_class($datasets)}");
        }

        $pathway = new Pathway();
        return $pathway->setPathArray($datasets);
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

    
    public function provider($code)
    {
        $this->provider = $this->setMetaObject(Provider::class, $code);
        return $this;
    }
    
    
    public function database($code)
    {
        $this->database = $this->setMetaObject(Database::class, $code);
        return $this;
    }
    
    
    public function dataset($code)
    {
        $this->dataset = $this->setMetaObject(Dataset::class, $code);
        return $this;
    }

    
    public function save()
    {
        $this->database->save();
        $this->provider->save();
        $this->dataset->save();

        if (! $this->database->datasets->contains($this->dataset->id)) {

            $this->database->datasets()->attach($this->dataset->id);
        }

        if (! $this->provider->databases->contains($this->database->id)) {

            $this->provider->databases()->attach($this->database->id);
        }

        return $this;
    }


    private function setVariables()
    {
        if (! count($this->path))
            return $this;

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


    private function setPathArray($datasets)
    {
        $this->path = [];
        foreach ($datasets as $dataset) {
            foreach ($dataset->databases as $database) {
                foreach ($database->providers as $provider) {
                    $this->path[] = [
                        'provider' => $provider,
                        'database' => $database,
                        'dataset' => $dataset
                    ];
                }
            }
        }
        return $this;
    }

    public function string()
    {
        return "{$this->provider->code}.{$this->database->code}.{$this->dataset->code}";
    }
}