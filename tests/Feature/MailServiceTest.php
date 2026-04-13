<?php

use App\Events\SendVendorEmailEvent;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;
use App\Models\Vendor;
use App\Services\MailService;

it('sends welcome email using mail service', function () {

    Mail::fake();

    $vendor = Vendor::factory()->create([
        'email' => 'event@example.com',
        'name' => "test mail service"
    ]);

    $mailService = app(MailService::class);

    $mailService->sendWelcome($vendor);

    Mail::assertSent(WelcomeEmail::class, function ($mail) use ($vendor) {
        return $mail->hasTo($vendor->email);
    });
});


it('sends welcome email on vendor registration event', function () {

    Mail::fake();

    $vendor = Vendor::factory()->create();

    event(new SendVendorEmailEvent($vendor));

    Mail::assertSent(WelcomeEmail::class);
});
