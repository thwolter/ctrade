<?php

namespace App\Jobs\Auth;

use App\Entities\User;
use App\Mail\Verification\EmailChangeVerification as EmailVerification;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendEmailChangeVerification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    protected $user;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->user->validToken()->count()) {

            $email = new EmailVerification($this->user);
            Mail::to($this->user->email_new)->send($email);
        }
    }
}
