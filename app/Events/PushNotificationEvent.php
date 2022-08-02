<?php

namespace App\Events;

use App\Models\Enums\RolesEnum;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PushNotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels, InteractsWithBroadcasting;

    public $data;

    public $role;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data, $role)
    {
        $this->broadcastVia('pusher');
        $this->data = $data;
        $this->role = $role;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        if ($this->role == RolesEnum::Gudang) {
            $channel = new PrivateChannel('pushNotification.' . RolesEnum::Gudang);
        } else {
            $channel = new PrivateChannel('pushNotification.' . RolesEnum::Produksi);
        }
        return $channel;
    }

    public function broadcastAs()
    {
        return 'push.notification';
    }
}
