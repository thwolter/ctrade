<?php


namespace App\Repositories\Contracts;

use App\Facades\Datasource;
use App\Repositories\Exceptions\MetadataException;
use Carbon\Carbon;

interface MetadataInterface
{
    function getFirstItems();

    function getNextItems();

    /**
     * Updates the item in the database. Should return true if updated and false otherwise.
     *
     * @param $item
     * @return mixed
     */
    function update($item);

    /**
     * Persist the item to the database. To decide which tables are effected and trait could be
     * use for various asset classes. The function should return true when successfully persisted.
     *
     * @param $item
     * @return mixed
     */
    function create($item);

    function dataset($item);

    /**
     * Get the DateTime when the item was refreshed on provider side.
     *
     * @param array $item
     * @return Carbon
     */
    function refreshed($item);

    /**
     * Define a function for each key in $keys via a magical function and returns the parsed value.
     *
     * @param $key , the function name
     * @param $arguments , the $item
     * @return string
     * @throws MetadataException
     */
    public function __call($key, $arguments);

    public function updateDatabase();

    /**
     * Provide the datasource for a given $item if available.
     *
     * @param $item
     * @return Datasource|null
     */
    public function datasource($item);

    /**
     * Returns true if the received item was updated on provider level.
     *
     * @param array $item
     * @return bool
     */
    public function existUpdate($item);
}