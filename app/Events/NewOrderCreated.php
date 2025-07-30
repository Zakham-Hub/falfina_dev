<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\{Order,Branch};

class NewOrderCreated implements ShouldBroadcast {
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $order;
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function broadcastOn(): array {
        return [
            new PrivateChannel('admins'),
            new PrivateChannel('manager_branch.' . $this->order->branch_id),
        ];
    }

    public function broadcastWith() {
        $branchName = Branch::whereId($this->order->branch_id)->first()->name;
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order?->order_number,
            'branch_name' => $branchName,
            'total_price' => $this->order->total_price,
            'order_show_route' => route('general.orders.show', $this->order->id),
        ];
    }

    public function broadcastAs() {
        return 'order.created';
    }
}
