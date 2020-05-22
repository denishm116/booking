<?php

namespace App\Listeners;

use App\Events\OwnerRegisterEvent;
use App\User;

Use Illuminate\Support\Facades\Mail;
use App\Mail\TutorialMail;
use Illuminate\Support\Facades\Auth;

class OwnerRegisterListener
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
     * @param  OwnerRegisterEvent  $event
     * @return void
     */
    public function handle(OwnerRegisterEvent $event)
    {
//        dd($event->user);
        Mail::to($event->user)->send(new TutorialMail($event->user));
    }
}
