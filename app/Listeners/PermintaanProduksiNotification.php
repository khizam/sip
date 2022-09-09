<?php

namespace App\Listeners;

use App\Events\PermintaanProduksiEvent;
use App\Events\PushNotificationEvent;
use App\Models\Enums\RolesEnum;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Notification;

class PermintaanProduksiNotification
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OwnerProductRequest  $event
     * @return void
     */
    public function handle(PermintaanProduksiEvent $event)
    {
        $role = RolesEnum::Produksi;
        $users = NotificationService::getUserByRole($role)->get();
        Notification::send($users, new \App\Notifications\PermintaanProduksiNotification($event->data));

        //Push Notification to Role "Produksi"
        $produksi = NotificationService::getUserByRole($role)->firstOrFail();
        $data = NotificationService::getNotificationUser($produksi);
        // event(new PushNotificationEvent($data, $role));
    }
}
