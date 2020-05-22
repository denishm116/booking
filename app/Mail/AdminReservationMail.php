<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminReservationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $owner;
    public $object;
    public $addres;
    public $city;
    public $user;
    public $room;

//    public function __construct($reservation, $city)
    public function __construct($reservation, $owner, $object, $addres, $city, $user, $room)
    {
        $this->reservation = $reservation;
        $this->owner = $owner;
        $this->object = $object;
        $this->addres = $addres;
        $this->city = $city;
        $this->user = $user;
        $this->room = $room;
    }


    public function build()
    {
        return $this->view('mail.adminafterpay')->subject('Бронирование № '.$this->reservation->id);
    }
}
