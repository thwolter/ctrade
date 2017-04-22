<?php


namespace App\Models\Rscript;


use Illuminate\Support\Facades\Storage;
use App\Models\Exceptions\RscriptException;

abstract class Rscripter
{
    protected $entity;
    protected $path;
    protected $rapi;
    protected $rbase;


    public function __construct($entity)
    {
        $this->entity = $entity;

        $this->rapi = base_path().'/rscripts/rapi.R';
        $this->path = storage_path().'/app/';
        $this->rbase = base_path(). '/rscripts';
    }


    /*public function __get($property)
    {
        if (method_exists($this, $property)) {

            return $this->$property();
        }
        return $this->entity->$property();
    }*/


    public function saveJSON()
    {
        $filename = 'tmp/'.uniqid() . '.json';
        Storage::disk('local')->put($filename, json_encode($this->entity->toArray()));

        return $filename;
    }

    public function argsImplode($args) {

        $s = null;
        foreach ($args as $key => $value)
        {
            $s = $s."--{$key}={$value} ";
        }
        return $s;
    }

    public function callRscript($args)
    {
        $filename = $this->saveJSON();
        $resfile = 'tmp/'.uniqid() . '.json';

        $callString = sprintf("Rscript --vanilla --verbose %s -b %s -f %s -o %s %s",
            $this->rapi, $this->rbase, $this->path.$filename, $this->path.$resfile, $this->argsImplode($args));

        //echo $callString;

        unset($output);
        exec($callString, $output);

        Storage::disk('local')->put('RscriptError', json_encode($output));

        $array = json_decode(Storage::read($resfile), true);

        //Storage::delete($filename);
        Storage::delete($resfile);

        return $array;
    }


}