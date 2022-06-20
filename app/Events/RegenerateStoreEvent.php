<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RegenerateStoreEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $title;
    public $user_detail;
    public $otp_detail;
    /**
     * Create a new event instance.
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
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
}
