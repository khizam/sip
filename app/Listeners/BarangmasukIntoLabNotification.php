<?php

namespace App\Listeners;

use App\Events\BarangmasukIntoLabEvent;
use App\Models\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class BarangmasukIntoLabNotification
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
    public function handle(BarangmasukIntoLabEvent $event)
    {
        $users = User::whereHas('roles', function (Builder $query) {
            $query->where('id', RolesEnum::Lab);
        })->get();
        Notification::send($users, new \App\Notifications\BarangmasukIntoLabNotification($event->data));
    }
}
