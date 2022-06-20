<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $title;
    public $user_detail;
    public $otp_detail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $user_detail, $otp_detail)
    {
        $this->title = $title;
        $this->user_detail = $user_detail;
        $this->otp_detail = $otp_detail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->title)
            ->from('wiqy0106@gmail.com')
            ->view('email.email');
    }
}
