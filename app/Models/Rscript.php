<?php

namespace App\Models;


class Rscript
{
    protected $entity;

    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    public function portfolioRisk($conf)
    {
        $file = uniqid('app/tmp/rscript');
        $script = 'Risk.R';

        $args = ['conf' => $conf];

        return $this->execute($script, $file, $args);
    }

    /**
     * Transforms array with parameters into a string to be used within exec call of Rscript
     *
     * @param array $args representing named parameters
     * @return string with Rscript arguments
     */
    private function argsImplode($args) {

        $s = null;
        foreach ($args as $key => $value)
        {
            $s = $s."--{$key}={$value} ";
        }
        return trim($s);
    }

    /**
     * Executes an Rscript.
     *
     * @param string $script
     * @param string $file
     * @param array $args
     * @return string
     */
    private function execute($script, $file, $args)
    {
        $result = storage_path($file . '.json');
        $log = storage_path($file . '.log');

        $argsString = $this->argsImplode($args);
        $scriptFile = base_path('rscripts/'.$script);

        shell_exec("Rscript {$scriptFile} {$argsString} > {$result} 2> {$log}");

        return file_get_contents($result);
}


}