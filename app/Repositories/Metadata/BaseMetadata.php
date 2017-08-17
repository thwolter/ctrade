<?php


namespace App\Repositories\Metadata;


use App\Events\MetadataUpdateHasCanceled;
use App\Events\MetadataUpdateHasFinished;
use App\Events\MetadataUpdateHasStarted;
use App\Facades\Datasource;
use App\Repositories\Exceptions\MetadataException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

abstract class BaseMetadata
{

    protected $chunk = 100;

    protected $provider;

    protected $database;

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
        if ($match) {
            $result = trim($matches[$parm[2]]);

        } else {
            $result = null;
        }

        return $result;
    }


    public function updateDatabase()
    {
        Log::info(sprintf('Update started for %s/%s ...', $this->provider, $this->database));
        event(new MetadataUpdateHasStarted($this->provider, $this->database));

        if ($this->local()) {
            $items = Cache::get($this->provider.$this->database);
            if (!$items) {
                $items = $this->getFirstItems($this->chunk);
                Cache::forever($this->provider.$this->database, $items);
            }

        } else {
            $items = $this->getFirstItems($this->chunk);
        }

        if (!$items) {

            Log::warning(sprintf('Update canceled for %s/%s.', $this->provider, $this->database));
            event(new MetadataUpdateHasCanceled($this->provider, $this->database));

            return false;
        }

        $i = 0;
        while ($items) {

            foreach ($items as $item) {

                $this->cacheItem($item);

                if ($this->datasource($item)) {

                    if ($this->existUpdate($item)) {
                        $this->update($item);
                    }

                } else {
                    $this->create($item);
                }
            }

            if ($this->local()) break;

            $items = $this->getNextItems($this->chunk);
            $i++;
        }

        event(new MetadataUpdateHasFinished($this->provider, $this->database));
        Log::info(sprintf('Update finished for %s/%s.', $this->provider, $this->database));
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
     * Returns true if the environment is in development stage.
     *
     * @return bool
     */
    private function local()
    {
        return (env('APP_ENV') == 'local');
    }


    /**
     * Returns true if the received item was updated on provider level.
     *
     * @param array $item
     * @return bool
     */
    public function existUpdate($item)
    {
        $current = $this->datasource($item)->refreshed_at->timestamp;
        $updated = $this->refreshed($item)->timestamp;

        return $current < $updated;
    }

    /**
     * Cache a json representation of all items within a given items' array.
     * This seems reasonable as by fetching of an item to check parameters,
     * the history is fetched as well.
     *
     * @param array $item
     *
     * @return void
     */
    private function cacheItem($item)
    {
        $key = 'ITEM.' . $this->dataset($item);
        $tags = [$this->provider, $this->database];

        \Cache::tags($tags)->forever($key, $item);
        Log::debug(sprintf('Cached %s with tags %s', $key, implode(',', $tags)));
    }
}