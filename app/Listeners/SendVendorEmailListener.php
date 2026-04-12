<?php

namespace App\Listeners;

use App\Events\SendVendorEmailEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendVendorEmailListener implements ShouldQueue
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
     */
    public function handle(SendVendorEmailEvent $event): void
    {
        //
        \Log::info('Processing queued listener...', [
            'event' => $event
        ]);

        Mail::raw('Hello Mailpit', function ($message) use ($event) {
            $message->to($event->vendor['email'])
                ->subject('Test Email');
        });
    }
}
