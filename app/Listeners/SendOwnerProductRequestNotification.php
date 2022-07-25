<?php

namespace App\Listeners;

use App\Events\OwnerProductRequestEvent;
use App\Models\Enums\RolesEnum;
use App\Models\User;
use App\Notifications\OwnerProductRequestNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendOwnerProductRequestNotification
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
     * @param  \App\Events\OwnerProductRequest  $event
     * @return void
     */
    public function handle(OwnerProductRequestEvent $event)
    {
        $users = User::whereHas('roles', function (Builder $query) {
            $query->where('id', RolesEnum::Produksi);
        })->get();
        Notification::send($users, new OwnerProductRequestNotification($event->data));
    }
}
