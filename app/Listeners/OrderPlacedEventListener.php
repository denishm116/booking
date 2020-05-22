<?php


namespace App\Listeners;

use App\Events\OrderPlacedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notification; /* Lecture 54 */

class OrderPlacedEventListener
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
     * @param  OrderPlacedEvent  $event
     * @return void
     */
    public function handle(OrderPlacedEvent $event)
    {
        /* Lecture 54 */
        Notification::create([

            'user_id'=>$id = $event->reservation->room->object->user_id,
            'content'=>__(' Бронирование №:reservation номера id::number в объекте :object. Дата заезда :dayin , Дата выезда :dayout',[
                'reservation'=>$event->reservation->id,
                'number'=>$event->reservation->room->id,
                'object'=>$event->reservation->room->object->name,
                'dayin'=>$event->reservation->day_in,
                'dayout'=>$event->reservation->day_out
            ]),
            'status'=>0,

        ]);


        $memcache = new \App\Enjoythetrip\Services\FakedMemcached(); /* Lecture 54 */

        $memcache->addServer('localhost', 11211) or die("Could not connect"); /* Lecture 54 */

        $memcache->set('userid_' . $id. '_notification_timestamp',time()); /* Lecture 54 */
    }
}

