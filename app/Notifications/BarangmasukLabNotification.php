<?php

namespace App\Notifications;

use App\Models\Lab;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BarangmasukLabNotification extends Notification
{
    use Queueable;

    public $lab;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Lab $lab)
    {
        $this->lab = $lab;
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
                $this->lab->toArray(),
            ],
            'links' => route('lab.index')
        ];
    }
}
