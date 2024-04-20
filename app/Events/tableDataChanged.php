<?php

namespace App\Events;

use App\Models\Item;
use App\Models\Table;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class tableDataChanged implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $table;
    public $retail_data;
    public function __construct(Table $table)
    {
        $table->load('data.pics');
        $arr = [];
        foreach ($table->data as $e) {
            array_push($arr,$e->barcode);
        }
        $this->retail_data=Item::getItemsByBarcode($arr)->get();
        $this->table = $table;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('table-data-changed'),
        ];
    }
}
