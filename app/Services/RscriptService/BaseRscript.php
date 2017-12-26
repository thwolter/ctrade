<?php


namespace App\Services\RscriptService;


use App\Entities\Portfolio;
use App\Exceptions\RscriptException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class BaseRscript
{

    /**
     * Transforms array with parameters into a string to be used within exec call of Rscript
     *
     * @param array $args representing named parameters
     * @return string with Rscript arguments
     */
    protected function argsImplode($args)
    {

        $s = null;
        foreach ($args as $key => $value)
        {
            $s = $s . "--{$key}={$value} ";
        }
        return trim($s);
    }


    /**
     * Executes an Rscript.
     *
     * @param string $script
     * @param array $args
     *
     * @return array
     * @throws RscriptException
     */
    protected function execute($script, $args)
    {

        $file = $this->makeUniqueFile();

        $result = storage_path($file . '.json');
        $log = storage_path($file . '.log');

        $url = config('app.url');
        $argsString = $this->argsImplode($args);
        $scriptFile = base_path('rscripts/' . $script);

        $execute = "Rscript {$scriptFile} --url={$url} {$argsString} > {$result} 2> {$log}";
        Log::debug("Executing '{$execute}'");

        shell_exec($execute);

        $json = file_get_contents($result);
        $this->cleanup($result, $log);

        Log::debug("Finished '{$execute}'");
        return json_decode($json, true);
    }


    /**
     * Delete the 'json' and 'log' files use for calling rscript and throw an error message
     * if an error occurred during calculation.
     *
     * @param string $result
     * @param string $log
     *
     * @throws RscriptException
     */
    protected function cleanup($result, $log)
    {
        $keys = ['Error', 'Fehler', 'sh'];
        $logtext = file_get_contents($log);

        $pos = false;
        foreach ($keys as $key) {
            $pos = stripos($logtext, $key);
            if ($pos !== false) break;
        }

        unlink($log);
        unlink($result);

        if ($pos !== false) {
            $error = substr($logtext, $pos);
            Log::emergency("Rscript error: $error");
            throw new RscriptException($error);
        }

    }


    /**
     * @return string
     */
    private function makeUniqueFile(): string
    {
        if (!File::exists((storage_path('app/tmp')))) {
            File::makeDirectory(storage_path('app/tmp'));
        }
        $file = uniqid('app/tmp/rscript');
        return $file;
    }

}