<?php

namespace App\Listeners;

use App\Events\OwnerProductRequestEvent;
use App\Events\PushNotificationEvent;
use App\Models\Enums\RolesEnum;
use App\Models\User;
use App\Notifications\OwnerProductRequestNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class SendOwnerProductRequestNotification
{

    public $data;
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
    public function handle(OwnerProductRequestEvent $event)
    {
        $users = User::whereHas('roles', function (Builder $query) {
            $query->where('id',3);
        })->get();
        Notification::send($users, new OwnerProductRequestNotification($event->data));

        //Push Notification to Role "Produksi"
        $this->data = $this->notications();
        event(new PushNotificationEvent($this->data));
    }

    public function notications()
    {
        $user = User::whereHas('roles', function (Builder $query) {
            $query->where('id', RolesEnum::Produksi);
        })->firstOrFail();
        $unread = $user->unreadNotifications;
        $totalUnread = $unread->isNotEmpty() ? $unread->count() : 0;
        return array('unread'=>$unread,'totalUnread'=>$totalUnread);
    }
}
