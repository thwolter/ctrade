<?php

namespace App\Mail\Verification;

use App\Entities\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class EmailVerification
 * @package App\Mail
 */
class EmailChangeVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;


    /**
     * Create a new message instance
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.newEmailVerification');
    }
}
