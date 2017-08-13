<?php

namespace App\Listeners\Verification;

use App\Events\Verification\EmailHasChanged;
use App\Jobs\Auth\NewEmailVerification;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewEmailVerificationReminder
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
     * @param  EmailHasChanged  $event
     * @return void
     */
    public function handle(EmailHasChanged $event)
    {
        dispatch(new NewEmailVerification($event->user));

        dispatch((
            new NewEmailVerification($event->user))->delay(Carbon::now()->addDays(1))
        );

        dispatch((
            new NewEmailVerification($event->user))->delay(Carbon::now()->addDays(5))
        );
    }
}
