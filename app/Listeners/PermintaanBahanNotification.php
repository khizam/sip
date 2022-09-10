<?php

namespace App\Listeners;

use App\Events\PermintaanBahanEvent;
use App\Events\PushNotificationEvent;
use App\Models\Enums\RolesEnum;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Notification;

class PermintaanBahanNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(PermintaanBahanEvent $event)
    {
        $role = RolesEnum::Gudang;
        $users = NotificationService::getUserByRole($role)->get();
        Notification::send($users, new \App\Notifications\PermintaanBahanNotification($event->data));

        //Push Notification to Role "Gudang"
        $produksi = NotificationService::getUserByRole($role)->firstOrFail();
        $data = NotificationService::getNotificationUser($produksi);
        // event(new PushNotificationEvent($data, $role));
    }
}
