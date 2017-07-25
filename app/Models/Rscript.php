<?php

namespace App\Models;


use App\Models\Exceptions\RscriptException;
use Illuminate\Support\Facades\Storage;

class Rscript
{
    protected $entity;

    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    public function portfolioRisk($date, $count)
    {
        if ($this->entity->positions->count() == 0) {
            return null;
        }

        $file = uniqid('app/tmp/rscript');
        $script = 'Risk.R';

        $args = [
            'id' => $this->entity->id,
            'date' => $date,
            'count' => $count
        ];
        $risk = $this->execute($script, $file, $args);

        return $risk;
    }

    /**
     * Transforms array with parameters into a string to be used within exec call of Rscript
     *
     * @param array $args representing named parameters
     * @return string with Rscript arguments
     */
    private function argsImplode($args)
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
     * @param string $file
     * @param array $args
     * @return array
     */
    private function execute($script, $file, $args)
    {
        $result = storage_path($file . '.json');
        $log = storage_path($file . '.log');

        $argsString = $this->argsImplode($args);
        $scriptFile = base_path('rscripts/' . $script);

        shell_exec("Rscript {$scriptFile} {$argsString} > {$result} 2> {$log}");

        $json = file_get_contents($result);
        $this->cleanup($result, $log);

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
    private function cleanup($result, $log)
    {
        $logtext = file_get_contents($log);
        $pos = stripos($logtext, 'ERROR');

        unlink($log);
        unlink($result);

        if ($pos !== false)
            throw new RscriptException(substr($logtext, $pos));
    }

}