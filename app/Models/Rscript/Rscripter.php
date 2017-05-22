<?php


namespace App\Models\Rscript;


use Illuminate\Support\Facades\Storage;
use App\Models\Exceptions\RscriptException;


abstract class Rscripter
{
    
    protected $cleanup = true;

    protected $entity;
    protected $rapi;
    protected $rbase;
    protected $path;


    /**
     * Constructor to set the entity (e.g. Portfolio) and
     * to define required tmp_path's to be handed over to Rscript
     *
     * Rscripter constructor.
     * @param $entity
     */
    public function __construct($entity)
    {
        $this->entity = $entity;

        $this->rapi = base_path().'/rscripts/rapi.R';
        $this->rbase = base_path(). '/rscripts';

        $this->makeTempDir();
    }


    public function entityName()
    {
        $ref = new \ReflectionClass($this->entity);
        return $ref->getShortName();
    }


    public function path($file = null)
    {
        if (is_null($file)) {
            return $this->path;
        } else {
            return $this->path.'/'.$file;
        }
    }

    public function fullpath($file = null)
    {
        return storage_path('app/'.$this->path($file));
    }

    /**
     * Transforms array with parameters into a string to be used within exec call of Rscript
     *
     * @param array $args representing named parameters
     * @return string with Rscript arguments
     */
    public function argsImplode($args) {

        $s = null;
        foreach ($args as $key => $value)
        {
            $s = $s."--{$key}={$value} ";
        }
        return trim($s);
    }


    /**
     * Calls Rscript with an array of arguments to be provided;
     * The functions uses the file system to transfer both portfolio data and results
     *
     * @param array $args representing required arguments for Rscript
     * @directory string with name of temp directory
     * @return array with result from Rscript
     *
     * @throws RscriptException if no output was written or result is with errors
     */
    public function callRscript($directory, $args)
    {
        $result = 'result.json';
        $log = 'log.txt';
        $entity = $this->saveJSON();

        $callString = sprintf(
            "Rscript --vanilla %s --base=%s --entity=%s --result=%s --directory=%s %s 2> %s",
            $this->rapi, $this->rbase, storage_path('app/'.$entity), $this->fullpath($result),
            $this->fullpath(), $this->argsImplode($args), $this->fullpath($log));
        
        exec($callString);

        $logtext = Storage::read($logFile);
        $hasError = stripos($logtext, 'ERROR');


        if (Storage::disk('local')->exists($resultFile)) {

            $array = json_decode(Storage::read($resultFile), true);
        }
        

        if ($this->cleanup and !$hasError and isset($array)) 
            Storage::deleteDirectory($directory);

        if ($hasError) 
            throw new RscriptException(substr($logtext, $hasError));
            
        if (! is_array($array))
            throw new RscriptException('returned invalid json file');

        

        return $array;
    }

    /**
     * @return string
     */
    public function makeTempDir()
    {
        $this->path = 'tmp/' . uniqid();
        Storage::makeDirectory($this->path);
    }

    /**
     * Saves the portfolio as json file to the file system
     *
     * @return string with name of the json file
     */
    public function saveJSON()
    {
        $filename = $this->path($this->entityName().'.json');

        Storage::disk('local')->put($filename, json_encode($this->entity->toArray()));

        return $filename;
    }
}