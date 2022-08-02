<?php

namespace App\Notifications;

use App\Models\PermintaanBahan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Notifications\Notification;

class PermintaanBahanNotification extends Notification implements ShouldBroadcastNow
{
    use Queueable;

    public $permintaanBahan;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(PermintaanBahan $permintaanBahan)
    {
        $this->permintaanBahan = $permintaanBahan;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'attributes' => [
                $this->permintaanBahan->toArray()
            ],
            'links' => route('gudang_request.index')
        ];
    }
}
