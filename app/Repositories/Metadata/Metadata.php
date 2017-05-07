<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 07.05.17
 * Time: 18:05
 */

namespace App\Repositories\Metadata;


use App\Entities\Database;
use App\Entities\Dataset;
use App\Entities\Provider;
use App\Entities\Sector;

class Metadata
{

    protected $provider;
    protected $client;

    public function pathExist($path)
    {
        $dataset = Dataset::find($path['dataset']->id);

        return ($dataset->hasProvider($path['provider']->id)
            and $dataset->hasDatabase($path['database']->id));
    }

    public function assignSectorToStock($name, $stock)
    {
        if (!is_null($name) and !emptyString($name)) {
            $sector = Sector::firstOrCreate(['name' => $name]);
            $stock->sector()->associate($sector)->save();
        }
    }

    public function assignDatabaseToStock($database, $dataset, $stock)
    {
        $dataset->stocks()->attach($stock->id);

        if (!$dataset->hasDatabase($database->id))
            $database->datasets()->attach($dataset->id);
    }

    protected function findOrCreateDatabase($name): array
    {
        $provider = Provider::firstOrCreate(['name' => $this->provider]);
        $database = Database::firstOrCreate(['code' => $name]);

        if (!$database->hasProvider($provider->id))
            $provider->databases()->attach($database->id);

        return [$provider, $database];
    }
}