<?php

namespace App\Services;

use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;

class MailService
{
    /**
     * Send welcome email
     */
    public function sendWelcome($user)
    {
       // Mail::to($event->vendor['email'])->send(new WelcomeEmail($event));
        Mail::to($user->email)->send(new WelcomeEmail($user));
    }

    /**
     * Example: send verification email (optional)
     */
    public function sendVerification($user)
    {
        $user->sendEmailVerificationNotification();
    }
}