<?php


namespace App\Models\Rscript;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Exceptions\RscriptException;


abstract class Rscripter
{
    
    protected $logFile = 'log.txt';
    protected $resultFile = 'result.json';

    protected $entity;
    protected $path;
    protected $dates;


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

    /**
     * Set the dates to be considered for time series.
     *
     * @param array $dates
     * @return $this
     */
    public function setDates(array $dates)
    {
        $this->dates = $dates;
        return $this;
    }


    private function entityName()
    {
        $ref = new \ReflectionClass($this->entity);
        return $ref->getShortName();
    }


    protected function path($file = null)
    {
        if (is_null($file)) {
            return $this->path;
        } else {
            return $this->path.'/'.$file;
        }
    }

    private function fullpath($file = null)
    {
        return storage_path('app/'.$this->path($file));
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
     * Calls Rscript with an array of arguments to be provided;
     * The functions uses the file system to transfer both portfolio data and results
     *
     * @param array $args
     * @param array $args representing required arguments for Rscript
     * @directory string with name of temp directory
     * @return array with result from Rscript
     *
     * @throws RscriptException if no output was written or result is with errors
     */
    protected function callRscript($args = ['task' => 'test-in-out'])
    {
        $entity = $this->saveJSON();
        exec($this->getRCallString($entity, $args));

        if ($error = $this->getErrorMessage())
            throw new RscriptException('Rscript returned with massage: '.$error);

        $result = $this->getResultArray();
        $this->deleteTempDir();

        return $result;
    }

    /**
     * @return string
     */
    private function makeTempDir()
    {
        $this->path = 'tmp/' . uniqid();
        Storage::makeDirectory($this->path);
    }


    private function deleteTempDir()
    {
        Storage::deleteDirectory($this->path());
    }

    /**
     * Saves the portfolio as json file to the file system
     *
     * @return string with name of the json file
     */
    private function saveJSON()
    {
        $filename = $this->entityName().'.json';

        Storage::disk('local')->put($this->path($filename), json_encode($this->entity->toArray()));

        return $filename;
    }

    private function getRCallString($entity, $args)
    {
        $callString = sprintf(
            "Rscript --vanilla %s --base=%s --entity=%s --result=%s --directory=%s %s 2> %s",
            $this->rapi,                    // R api
            $this->rbase,                   // R base directory
            $entity,                        // filename with entity (e.g. portfolio) data
            $this->resultFile,              // result file name
            $this->fullpath(),              // tmp directory for reading/writing
            $this->argsImplode($args),      // arguments for R api
            $this->fullpath($this->logFile) // log file
        );

        return $callString;
    }


    private function getErrorMessage()
    {
        $logtext = Storage::read($this->path($this->logFile));

        $pos = stripos($logtext, 'ERROR');

        return ($pos !== false) ? substr($logtext, $pos) : false;
    }


    private function getResultArray()
    {
        if (!Storage::disk('local')->exists($this->path($this->resultFile)))
            return false;

        $array = json_decode(Storage::read($this->path($this->resultFile)), true);

        if (! is_array($array))
            throw new RscriptException('Rscript returned an invalid json file');

        return $array;
    }

    private function validateDate($date)
    {
        if (is_null($date)) return false;

        $d = \Carbon\Carbon::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }

    protected function validPriceArray($array)
    {
        $checkDate = $this->validateDate(array_keys($array)[0]);
        $checkPrice = is_numeric(array_first($array));

        return $checkDate and $checkPrice;
    }
}