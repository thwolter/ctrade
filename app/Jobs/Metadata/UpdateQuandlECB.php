<?php

namespace App\Jobs\Metadata;

use App\Repositories\Metadata\Quandl\QuandlECB;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;



class UpdateQuandlECB implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $repo;


    public function __construct()
    {
        $this->repo = new QuandlECB();
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->repo->updateDatabase();
    }



}
