<?php


namespace App\Classes\Metadata;


use App\Events\MetadataUpdateHasCanceled;
use App\Events\MetadataUpdateHasFinished;
use App\Events\MetadataUpdateHasStarted;
use App\Facades\Datasource;
use App\Jobs\Metadata\RunBulkUpdate;
use App\Exceptions\MetadataException;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

abstract class BaseMetadata
{

    protected $chunk;

    protected $client;

    protected $queue = 'default';

    protected $provider;

    public $database;

    protected $keys =[];

    abstract function getFirstItems();

    abstract function getNextItems();

    abstract function update($item);

    /**
     * Persist the item to the database. To decide which tables are effected and trait could be
     * use for various asset classes. The function should return true when successfully persisted.
     *
     * @param $item
     * @return mixed
     */
    abstract function create($item);

    abstract function dataset($item);


    /**
     * Get the DateTime when the item was refreshed on provider side.
     *
     * @param array $item
     * @return Carbon
     */
    abstract function refreshed($item);


    public function __construct()
    {
        $this->client = app()->make(ucfirst($this->provider).'Client');
        $this->chunk = config('quandl.per_page');
    }

    /**
     * Define a function for each key in $keys via a magical function and returns the parsed value.
     *
     * @param $key, the function name
     * @param $arguments, the $item
     * @return string
     * @throws MetadataException
     */
    public function __call($key, $arguments)
    {
        $parm = array_get($this->keys, $key);
        $item = $arguments[0];

        if (!$parm)
            throw new MetadataException("'{$key}' not defined.");

        $match = preg_match($parm[1], array_get($item, $parm[0]), $matches);

        return $match ? trim($matches[$parm[2]]) : null;
    }


    public function updateDatabase()
    {
        $this->notifyAboutStart();
        $items = $this->fetchFirstItems();

        if (!$items) {
            $this->notifyAboutCancellation();
            return false;
        }

        while ($items) {

            dispatch(new RunBulkUpdate($items, $this))->onQueue($this->queue);
            if (App::environment('local')) break;

            $items = $this->fetchNextItems();
        }

        $this->notifyAboutFinished();
    }


    /**
     * Provide the datasource for a given $item if available.
     *
     * @param $item
     * @return Datasource|null
     */
    public function datasource($item)
    {
        return Datasource::get($this->provider, $this->database, $this->dataset($item));
    }


    /**
     * Returns true if the received item was updated on provider level.
     *
     * @param array $item
     * @return bool
     */
    public function existUpdate($item)
    {
        $current = optional($this->datasource($item))->refreshed_at;
        $updated = $this->refreshed($item);

        return $current < $updated;
    }


    private function notifyAboutStart()
    {
        Log::info(sprintf('Update started for %s/%s ...', $this->provider, $this->database));
        event(new MetadataUpdateHasStarted($this->provider, $this->database));
    }


    private function notifyAboutCancellation()
    {
        Log::warning(sprintf('Update canceled for %s/%s.', $this->provider, $this->database));
        event(new MetadataUpdateHasCanceled($this->provider, $this->database));
    }


    private function notifyAboutFinished()
    {
        event(new MetadataUpdateHasFinished($this->provider, $this->database));
        Log::info(sprintf('Update finished for %s/%s.', $this->provider, $this->database));
    }


    private function fetchFirstItems()
    {
        if (App::environment('local')) {
            $items = Cache::get($this->provider . $this->database);
            if (!$items) {
                $items = $this->getFirstItems($this->chunk);
                Cache::forever($this->provider . $this->database, $items);
            }

        } else {
            $items = $this->getFirstItems($this->chunk);
        }
        return $items;
    }


    private function fetchNextItems()
    {
        return $this->getNextItems($this->chunk);
    }

}