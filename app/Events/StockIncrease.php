<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StockIncrease implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $stockCount;
    public $sold;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($stockCount,$sold)
    {
        //
        $this->stockCount = $stockCount;
        $this->sold = $sold;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('event');
    }

    public function broadcastAs()
    {
        return 'stock_count';
    }
}
