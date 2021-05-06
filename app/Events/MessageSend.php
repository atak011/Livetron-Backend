<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSend implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $username;
    public $message;
    public $event_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message,$username,$event_id)
    {
        $this->message = $message;
        $this->username = $username;
        $this->event_id = $event_id;
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('chat');
    }

    public function broadcastAs()
    {
        return 'test';
    }
}
