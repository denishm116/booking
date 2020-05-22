<?php
/*
|--------------------------------------------------------------------------
| app/Providers/EventServiceProvider.php *** Copyright netprogs.pl | avaiable only at Udemy.com | further distribution is prohibited  ***
|--------------------------------------------------------------------------
*/

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */

    /* Lecture 54 */
    protected $listen = [
        'App\Events\OrderPlacedEvent' => [
            'App\Listeners\OrderPlacedEventListener',
        ],
        'App\Events\ReservationConfirmedEvent' => [
            'App\Listeners\ReservationConfirmedListener',
        ],
        'App\Events\OwnerRegisterEvent' => [
            'App\Listeners\OwnerRegisterListener',
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}

