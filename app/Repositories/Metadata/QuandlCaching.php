<?php


namespace App\Repositories\Metadata;


use App\Entities\Provider;
use App\Repositories\Quandl\Quandldata;
use Illuminate\Console\OutputStyle;
use Symfony\Component\Console\Helper\ProgressBar;

class QuandlCaching
{

    protected $provider = 'Quandl';



    public function __construct(OutputStyle $output)
    {
        $this->output = $output;
    }


    public function refreshCash($relax)
    {
        $datasources = Provider::whereCode($this->provider)->first()->datasources;

        $progress = new ProgressBar($this->output, count($datasources));
        $progress->start();

        foreach ($datasources as $datasource)
        {
            $code = $datasource->dataset->code;

            Quandldata::refreshCache($code, $relax);
            $progress->advance();
        }
    }
}