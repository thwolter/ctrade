<?php

namespace App\Jobs\Subscription;

use App\Entities\Taker;
use App\Mail\Verification\TakerEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendVerificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $taker;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Taker $taker)
    {
        $this->taker = $taker;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new TakerEmail($this->taker);
        Mail::to($this->taker->email)->send($email);
    }
}
