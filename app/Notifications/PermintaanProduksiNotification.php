<?php

namespace App\Notifications;

use App\Models\ProduksiBarang;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PermintaanProduksiNotification extends Notification
{
    use Queueable;

    public $produksiBarang;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ProduksiBarang $produksiBarang)
    {
        $this->produksiBarang = $produksiBarang;
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
                $this->produksiBarang->toArray(),
            ],
            'links' => route('produksi.index')
        ];
    }
}
