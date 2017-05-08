<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 07.05.17
 * Time: 18:05
 */

namespace App\Repositories\Metadata;


use App\Entities\Currency;
use App\Entities\Database;
use App\Entities\Dataset;
use App\Entities\Provider;
use App\Entities\Sector;

abstract class Metadata
{

    protected $provider;

    public function existPath($path)
    {
        $dataset = Dataset::find($path['dataset']->id);

        return ($dataset->hasProvider($path['provider']->id)
            and $dataset->hasDatabase($path['database']->id));
    }

    public function assignSectorToStock($name, $stock)
    {
        if (!is_null($name) and !empty($name)) {
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

    public function saveStock($item, $path)
    {
        if (!$this->checkValidity($item)) return false;

        $stock = Currency::firstOrCreate(['code' => $this->currency($item)])
            ->stocks()->create([
                'name' => $this->name($item),
                'wkn' => $this->wkn($item),
                'isin' => $this->isin($item)
            ]);

        $this->assignSectorToStock($this->sector($item), $stock);
        $this->assignDatabaseToStock($path['database'], $path['dataset'], $stock);

        return true;
    }

    public function setPath(Array $item, Provider $provider, Database $database)
    {
        $dataset = Dataset::firstOrCreate(['code' => $this->symbol($item)]);

        return [
            'provider' => $provider,
            'database' => $database,
            'dataset' => $dataset
        ];
    }

    public function destroyPath(Array $path)
    {
        $path['dataset']->delete();
    }

    protected function findOrCreateDatabase($name): array
    {
        $provider = Provider::firstOrCreate(['name' => $this->provider]);
        $database = Database::firstOrCreate(['code' => $name]);

        if (!$database->hasProvider($provider->id))
            $provider->databases()->attach($database->id);

        return [$provider, $database];
    }

    abstract public function symbol($item);

    abstract public function name($item);

    abstract public function currency($item);

    public function checkValidity($item)
    {
        return true;
    }

    public function wkn($item)
    {
        return null;
    }

    public function isin($item)
    {
        return null;
    }

    public function sector($item)
    {
        return null;
    }
}