<?php

namespace App\Listeners;

use App\Events\SendVendorEmailEvent;
use App\Mail\WelcomeEmail;
use App\Services\MailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendVendorEmailListener implements ShouldQueue
{
    protected MailService $mailService;
    /**
     * Create the event listener.
     */
    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    /**
     * Handle the event.
     */
    public function handle(SendVendorEmailEvent $event): void
    {
        //
        Log::info('Processing queued listener...', [
            'event' => $event
        ]);

        $this->mailService->sendWelcome($event?->vendor);
        
       
    }
}
