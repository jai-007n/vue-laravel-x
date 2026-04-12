<?php

namespace App\Events;

use App\Http\Resources\VendorResource;
use App\Models\Vendor;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendVendorEmailEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $vendor;
    /**
     * Create a new event instance.
     */
    public function __construct($vendor)
    {
        $this->vendor =$vendor;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
