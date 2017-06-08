<?php


namespace App\Repositories\Metadata;


use App\Entities\Provider;
use App\Jobs\RefreshQuandleCache;
use App\Repositories\Quandl\Quandldata;
use Illuminate\Console\OutputStyle;
use Symfony\Component\Console\Helper\ProgressBar;

class QuandlCaching
{

    protected $provider = 'Quandl';
    protected $datasources;

    protected $output;
    protected $progressbar;



    public function __construct(OutputStyle $output = null)
    {
        $this->output = $output;
    }


    public function refreshCash($relax)
    {
        $this->datasources = Provider::whereCode($this->provider)->first()->datasources;

        $this->progress();

        foreach ($this->datasources as $datasource)
        {
            $code = $datasource->dataset->code;

            Quandldata::refreshCache($code, $relax);
            $this->advance();
        }
    }

    private function progress()
    {
        if (isset($this->output)) {

            $this->progressbar = new ProgressBar($this->output, count($this->datasources));
            $this->progressbar->start();
        }
    }

    private function advance()
    {
        if (isset($this->output)) {

            $this->progressbar->advance();
        }
    }
}