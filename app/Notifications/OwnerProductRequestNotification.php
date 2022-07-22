<?php

namespace App\Notifications;

use App\Models\ProduksiBarang;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OwnerProductRequestNotification extends Notification implements ShouldBroadcastNow
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
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            'produk'=>$this->produksiBarang->produk->nama_produk,
            'jumlah'=>$this->produksiBarang->jumlah,
            'user'=>$this->produksiBarang->user->name,
        ];
    }
}
