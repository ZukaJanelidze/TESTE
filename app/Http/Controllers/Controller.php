<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use App\Models\User;

class Controller
{
    public function sendWelcomeEmail(User $user)
    {
        Mail::to($user->email)->send(new WelcomeMail());
    }
}