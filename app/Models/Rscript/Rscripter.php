<?php


namespace App\Models\Rscript;


use Illuminate\Support\Facades\Storage;
use App\Models\Exceptions\RscriptException;


abstract class Rscripter
{
    
    protected $cleanup = false;
    
    protected $entity;
    protected $path;
    protected $rapi;
    protected $rbase;
    


    /**
     * Constructor to set the entity (e.g. Portfolio) and
     * to define required path's to be handed over to Rscript
     *
     * Rscripter constructor.
     * @param $entity
     */
    public function __construct($entity)
    {
        $this->entity = $entity;

        $this->rapi = base_path().'/rscripts/rapi.R';
        $this->path = storage_path().'/app/';
        $this->rbase = base_path(). '/rscripts';
    }


    public function entityName()
    {
        $ref = new \ReflectionClass($this->entity);
        return $ref->getShortName();
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
        // define result file
        $resultFile = "{$directory}/result.json";
        
        // define log file
        $logFile = "{$directory}/log.txt";

        // entity file
        $entity = $this->saveJSON($directory);

        $callString = sprintf(
            "Rscript --vanilla %s --base=%s --entity=%s --result=%s --directory=%s %s 2> %s",
            $this->rapi, $this->rbase, $this->path.$entity, $this->path.$resultFile,
            $this->path.$directory, $this->argsImplode($args), $this->path.$logFile);
        
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
            
        if (! isset($array)) 
            throw new RscriptException('returned invalide json file');
        

        return $array;
    }

    /**
     * @return string
     */
    public function makeDirectory(): string
    {
        $tmpdir = 'tmp/' . uniqid();
        Storage::makeDirectory($tmpdir);

        return $tmpdir;
    }

    /**
     * Saves the portfolio as json file to the file system
     *
     * @return string with name of the json file
     */
    public function saveJSON($directory)
    {
        $filename = "{$directory}/{$this->entityName()}.json";
        Storage::disk('local')->put($filename, json_encode($this->entity->toArray()));

        return $filename;
    }
}