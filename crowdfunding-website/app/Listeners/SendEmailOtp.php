<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Mail\UserRegisteredMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailOtp implements ShouldQueue
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
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        if($event->condition == 'regenerate'){
            $emailMessage = "Berikut kode OTP anda yang baru!";
        } elseif ($event->condition == 'register') {
            $emailMessage = "Selamat anda sudah terdaftar, silahkan masukan kode OTP dibawah ini untuk verifikasi akun anda..";
        }

        Mail::to($event->user)->send(new UserRegisteredMail($event->user, $emailMessage));
    }
}
