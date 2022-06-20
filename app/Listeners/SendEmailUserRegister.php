<?php

namespace App\Listeners;

use App\Events\RegisterStoreEvent;
use App\Mail\SendOtp;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailUserRegister implements ShouldQueue
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
     * @param  RegisterStoreEvent  $event
     * @return void
     */
    public function handle(RegisterStoreEvent $event)
    {
        Mail::to($event->user_detail['email'])->send(new SendOtp($event->title, $event->user_detail, $event->otp_detail));
    }
}
