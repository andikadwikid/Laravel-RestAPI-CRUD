<?php

namespace App\Listeners;

use App\Events\RegenerateStoreEvent;
use App\Mail\SendMail;
use App\Mail\SendOtp;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailRegenerate implements ShouldQueue
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
     * @param  RegenerateStoreEvent  $event
     * @return void
     */
    public function handle(RegenerateStoreEvent $event)
    {
        Mail::to($event->user_detail['email'])->send(new SendMail($event->title, $event->user_detail, $event->otp_detail));
    }
}
