<?php

namespace App\Repositories\Metadata;


use App\Entities\Datasource;
use App\Repositories\Exceptions\MetadataException;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\Output;
use Illuminate\Support\Facades\Log;

abstract class QuandlMetadata
{

    protected $testing = [
        'maxPages' => 1,
        'perPage' => 5
    ];

    protected $local = [
        'maxPages' => 2,
        'perPage' => 100
    ];

    protected $running = [
        'maxPages' => INF,
        'perPage' => 100
    ];

    protected $client;
    protected $provider = 'Quandl';
    protected $database;

    protected $output;

    protected $nextPage = 0;
    protected $totalPages = 2;
    protected $maxPages;
    protected $perPage;


    public function __construct($output = null)
    {
        $this->setting();

        $this->client = new \Quandl(env('QUANDL_API_KEY'), 'json');
        $this->client->timeout = 60;

        $this->output = $output;
    }


    private function setting()
    {
        $parms = $this->running;

        if (\App::environment('testing')) $parms = $this->testing;
        if (\App::environment('local')) $parms = $this->local;

        $this->maxPages = $parms['maxPages'];
        $this->perPage = $parms['perPage'];
    }


    abstract public function saveItem($item);
    
    abstract public function updateItem($item);


    public function load()
    {
        $progress = null;
        $countStored = 0;
        $countUpdated = 0;

        if (!isset($this->database)) {
            throw new MetadataException("variable 'database' must be set");
        }
    
        Log::notice('start loading '.$this->database);
        while ($this->nextPage <= min($this->totalPages, $this->maxPages)
            and !is_null($this->nextPage))
        {
            $items = $this->getItems();

            if (is_null($progress))
            {
                $pages = min($this->totalPages, $this->maxPages);
                $progress = new ProgressBar($this->output, $pages * $this->perPage);
                $progress->start();
            }

            foreach ($items as $item) {
                
                if (Datasource::exist($this->provider, $this->database, $this->symbol($item)))
                {
                    if ($this->updateItem($item))
                        $countUpdated++;
                    
                } else {
                    
                    if ($this->createItemWithSource($item))
                        $countStored++;
 
                }
                
                $progress->advance();
            }
        }
        
        Log::notice("finished loading {$this->database} ({$countStored} new; {$countUpdated} updated)");
        $progress->finish();
    }
    
    
    
    public function createItemWithSource($item)
    {
        $instrument = $this->saveItem($item);

        if (is_null($instrument)) {
            Log::notice('symbol ' . $this->symbol($item) . ' not saved');
            return false;
        }
        
        Datasource::make($this->provider, $this->database, $this->symbol($item))
                ->assign($instrument);

        return true;
    }


    public function getItems()
    {
        $json = $this->client->getList($this->database, $this->nextPage, $this->perPage);
        //Storage::put('QuandlSSE.json', $json); // for testing reasons

        $array = json_decode($json, true);

        $this->nextPage = array_get($array, 'meta.next_page');
        $this->totalPages = array_get($array, 'meta.total_pages');

        return $array['datasets'];
    }
}