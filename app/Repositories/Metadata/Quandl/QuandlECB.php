<?php


namespace App\Repositories\Metadata\Quandl;

use App\Events\MetadataUpdateHasFinished;
use App\Events\MetadataUpdateHasStarted;
use App\Entities\Currency;
use App\Models\PriceHistory;
use App\Repositories\Contracts\MetadataInterface;
use App\Repositories\Metadata\Traits\CcyPairMetadata;
use Illuminate\Support\Facades\Log;


class QuandlECB extends QuandlMetadata implements MetadataInterface
{
    use CcyPairMetadata;

    public $database = 'ECB';

    protected $origin = 'EUR';
    protected $maxLagging = 5;

    protected $keys =[
        'symbol'    => ['dataset_code', '/.*/', 0],
    ];


    protected function exchange($item)
    {
        return 'ECB';
    }

    public function updateDatabase()
    {
        Log::info(sprintf('Update started for %s/%s ...', $this->provider, $this->database));
        event(new MetadataUpdateHasStarted($this->provider, $this->database));

        foreach (Currency::all() as $currency) {

            if ($this->origin === $currency->code) continue;

            $symbol = $this->origin.$currency->code;
            $dataset = $this->database . '/' . $symbol;

            $data = $this->client->getSymbol($dataset);

            if (!$data) {
                Log::warning(sprintf('Could not fetch %s from %s/%s: %s',
                    $symbol, $this->provider, $this->database, $this->client->error));
                continue;
            }

            $item = array_get(json_decode($data, true), 'dataset');

            if ($this->datasource($item)) {

                if ($this->existUpdate($item))
                    $this->update($item);

            } else {

                $this->create($item);
            }

            $this->cacheItem($item);

        }

        event(new MetadataUpdateHasFinished($this->provider, $this->database));
        Log::info(sprintf('Update finished for %s/%s.', $this->provider, $this->database));
    }


    protected function cacheItem($item)
    {
        $key = $this->symbol($item);
        $tags = [$this->provider, $this->database];

        $prices = array_get($item, 'data');
        $history = new PriceHistory($prices, 1);

        Log::debug(sprintf('Caching %s with tags %s', $key, implode(', ', $tags)));
        \Cache::tags($tags)->forever($key, $history);
    }

}