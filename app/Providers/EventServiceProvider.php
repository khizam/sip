<?php

namespace App\Providers;

use App\Events\BarangmasukLabEvent;
use App\Events\PermintaanBahanEvent;
use App\Events\PermintaanProduksiEvent;
use App\Listeners\BarangmasukLabNotification;
use App\Listeners\PermintaanBahanNotification;
use App\Listeners\PermintaanProduksiNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        BarangmasukLabEvent::class => [
            BarangmasukLabNotification::class,
        ],
        PermintaanProduksiEvent::class => [
            PermintaanProduksiNotification::class,
        ],
        PermintaanBahanEvent::class => [
            PermintaanBahanNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
