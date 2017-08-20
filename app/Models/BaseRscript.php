<?php


namespace App\Models;


use App\Models\Exceptions\RscriptException;
use Illuminate\Support\Facades\Log;

class BaseRscript
{

    protected $entity;

    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    /**
     * Transforms array with parameters into a string to be used within exec call of Rscript
     *
     * @param array $args representing named parameters
     * @return string with Rscript arguments
     */
    protected function argsImplode($args)
    {

        $s = null;
        foreach ($args as $key => $value) {
            $s = $s . "--{$key}={$value} ";
        }
        return trim($s);
    }

    /**
     * Executes an Rscript.
     *
     * @param string $script
     * @param array $args
     * @return array
     */
    protected function execute($script, $args)
    {
        if ($this->entity->positions->count() == 0) {
            return null;
        }

        $file = uniqid('app/tmp/rscript');

        $result = storage_path($file . '.json');
        $log = storage_path($file . '.log');

        $argsString = $this->argsImplode($args);
        $scriptFile = base_path('rscripts/' . $script);

        $execute = "Rscript {$scriptFile} {$argsString} > {$result} 2> {$log}";
        Log::debug("Executing '{$execute}'");

        shell_exec($execute);

        $json = file_get_contents($result);
        $this->cleanup($result, $log);

        Log::debug("Finished RScript calculation.");
        return json_decode($json, true);
    }

    /**
     * Delete the 'json' and 'log' files use for calling rscript and throw an error message
     * if an error occurred during calculation.
     *
     * @param string $result
     * @param string $log
     * @throws RscriptException
     */
    protected function cleanup($result, $log)
    {
        $logtext = file_get_contents($log);
        $pos = stripos($logtext, 'ERROR');

        unlink($log);
        unlink($result);

        if ($pos !== false)
            throw new RscriptException(substr($logtext, $pos));
    }
}