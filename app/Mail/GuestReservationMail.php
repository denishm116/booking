<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class GuestReservationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $owner;
    public $object;
    public $addres;
    public $city;
    public $user;
    public $room;

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
        if (is_file("tickets/".$this->reservation->id.$this->user->email.".pdf"))
            return $this->view('mail.ownerafterpay')->subject($this->user->name . ', добро пожаловать в Крым! Ваш электронный билет.')->attach("tickets/" . $this->reservation->id . $this->user->email . ".pdf");
        else
            return $this->view('mail.ownerafterpay')->subject($this->user->name . ', добро пожаловать в Крым! Ваш электронный билет.');
    }
}
