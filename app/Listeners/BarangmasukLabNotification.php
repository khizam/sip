<?php

namespace App\Listeners;

use App\Events\BarangmasukLabEvent;
use App\Models\Enums\RolesEnum;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Notification;

class BarangmasukLabNotification
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
    public function handle(BarangmasukLabEvent $event)
    {
        $role = RolesEnum::Lab;
        $users = NotificationService::getUserByRole($role)->get();
        Notification::send($users, new \App\Notifications\BarangmasukLabNotification($event->data));
    }
}
