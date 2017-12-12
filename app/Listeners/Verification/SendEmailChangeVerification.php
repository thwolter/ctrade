<?php

namespace App\Listeners\Verification;

use App\Events\Verification\UserRequestedEmailChange;
use App\Jobs\Auth\SendEmailChangeVerification as SendEmailVerification;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailChangeVerification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserRequestedEmailChange  $event
     * @return void
     */
    public function handle(UserRequestedEmailChange $event)
    {
        dispatch(new SendEmailVerification($event->user));

        dispatch((
            new SendEmailVerification($event->user))->delay(Carbon::now()->addDays(1))
        );

        dispatch((
            new SendEmailVerification($event->user))->delay(Carbon::now()->addDays(5))
        );
    }
}
