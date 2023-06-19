<?php

namespace App\Listeners;

use App\Events\DuplicateFundWarning;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class DuplicateFundWarningListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param DuplicateFundWarning $event
     * @return void
     */
    public function handle(DuplicateFundWarning $event): void
    {
        $fund = $event->fund;

        // Do something
        Mail::raw('Duplicate Fund Reported - Found: Name: ' . $fund->name . ' ID:' . $fund->id, function (Message $message) use ($fund) {
            $message
                ->subject('Duplicate Fund Reported - Found: Name: ' . $fund->name . ' ID:' . $fund->id)
                ->to('example@gmail.com');
        });
    }
}
