<?php

namespace App\Mail\Verification;

use App\Entities\Taker;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TakerEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $taker;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Taker $taker)
    {
        $this->taker = $taker;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.verification.taker');
    }
}
