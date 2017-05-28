<?php

namespace App\Repositories\Metadata;


use App\Models\Pathway;
use App\Repositories\Exceptions\MetadataException;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\Output;

abstract class QuandlMetadata
{

    protected $testing = [
        'maxPages' => 1,
        'perPage' => 5
    ];

    protected $local = [
        'maxPages' => 5,
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


    public function load()
    {
        $progress = null;

        if (!isset($this->database)) {
            throw new MetadataException("variable 'database' must be set");
        }

        while ($this->nextPage++ <= min($this->totalPages, $this->maxPages))
        {
            $items = $this->getItems();

            if (is_null($progress))
            {
                $pages = min($this->totalPages, $this->maxPages);
                $progress = new ProgressBar($this->output, $pages * $this->perPage);
                $progress->start();
            }

            foreach ($items as $item) {

                $instrument = $this->saveItem($item);

                if (!is_null($instrument))
                {
                    Pathway::make($this->provider, $this->database, $this->symbol($item))
                        ->assign($instrument);
                }
                $progress->advance();
            }
        }
        $progress->finish();

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