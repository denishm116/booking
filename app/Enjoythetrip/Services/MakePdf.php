<?php


namespace App\Enjoythetrip\Services;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\User;
use Illuminate\Support\Facades\Storage;
class MakePdf
{

    public $reservation;
    public $object;
    public $user;
    public $city;
    public $room;
    public $owner;
    public $addres;

    public function __construct($reservation, $object,User $user, $city, $room, $owner, $addres)
    {
        $this->reservation = $reservation;
        $this->object = $object;
        $this->user = $user;
        $this->city = $city;
        $this->room = $room;
        $this->owner = $owner;
        $this->addres = $addres;
    }

    public function makePdf()
    {

        $userName = $this->user->name;
        $userSurname = $this->user->surname;
        $reservationId = $this->reservation->id;
        $objectName = $this->object->name;
        $roomId = $this->room->id;
        $cityName = $this->city->name;
        $addresStreet = $this->addres->street;
        $addresNumber = $this->addres->number;
        $reservationDay_in = $this->reservation->day_in;
        $reservationDay_out = $this->reservation->day_out;
        $reservationPrice = $this->reservation->price;
        $reservationReward = $this->reservation->reward;
        $ownerFullName = $this->owner->name . ' ' . $this->owner->surname;
        $ownerPhone = $this->owner->phone;
        $ownerEmail = $this->owner->email;
        $userFullName = $userName . ' ' . $userSurname;
        $options = new Options();
        $options->set('defaultFont', 'dejavu sans');
        $dompdf = new DOMPDF($options);
        $cost = $this->reservation->price - $this->reservation->reward;
        $html = <<< ENDHTML
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Приятного отдыха</title>


<style type="text/css">

body {
    -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em;
}
body {
    background-color: #f6f6f6;
}
@media only screen and (max-width: 640px) {
    body {
        padding: 0 !important;
  }
  h1 {
        font-weight: 800 !important; margin: 20px 0 5px !important;
  }
  h2 {
        font-weight: 800 !important; margin: 20px 0 5px !important;
  }
  h3 {
        font-weight: 800 !important; margin: 20px 0 5px !important;
  }
  h4 {
        font-weight: 800 !important; margin: 20px 0 5px !important;
  }
  h1 {
        font-size: 22px !important;
  }
  h2 {
        font-size: 18px !important;
  }
  h3 {
        font-size: 16px !important;
  }
  .container {
        padding: 15px !important; width: 60% !important;
  }
  .content {
        padding: 0 !important;
  }
  .content-wrap {
        padding: 10px !important;
  }
  .invoice {
        width: 100% !important;
    }
}
    .logo-orange {
        color: rgb(218, 111, 91);
    }

    .krim_Leto_ru {
        position: relative;
        font-size: 26px;

        font-weight: bold;
        text-transform: uppercase;
        color: #00315f;
        text-decoration: none;
        transition: .5s;
    }
    .margin {
    margin: 0 auto;
    }
</style>
</head>

<body style="box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; !important; height: 100%; line-height: 1.6em; margin: 0;">

<table width="90%" height="90%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-size: 14px; margin: 0 auto;  bgcolor="#f6f6f6"">
<tr style="box-sizing: border-box; font-size: 14px; margin: 0;">
<td   width="90%" style=" box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 15px; padding: 0 0 20px;" valign="top">
                                <div style="margin: 20px 0">
                                    <a class="krim_Leto_ru" href="/">Krim-leto<span class="logo-orange">.ru</span>
                                    </a>

                                </div>
                                <h1 style="text-align: center">Добро пожаловать в Крым!</h1>
   <h2 style="text-align: center">Уважаемый $userName !</h2>
                <h4>Данное письмо является подтверждением того, что Вы - $userFullName, забронировали:</h4>
                            <div>
                                Уникальный номер бронирования: <b>$reservationId</b><br>
                                Название объекта размещения: <b>$objectName</b><br>
                                Номер/Аппартаменты id: <b>$roomId</b><br>

                                Населенный пункт: <b>$cityName</b><br>
                                Адрес: <b> ул. $addresStreet</b> д. <b>$addresNumber</b><br>
                                Дата заезда: <b> $reservationDay_in </b> <br>
                                Дата выезда: <b> $reservationDay_out </b> <br>
                                Полная стоимость бронирования: <b>  $reservationPrice    руб.</b> <br>
                                Оплачено: <b>  $reservationReward    руб.</b> <br>
                                Остаток оплаты: <b>  $cost  руб.</b> <br></div>
                                <div style="background: #90dbf6; padding: 5px;">
                                Контактное лицо (в объекте размещения): <b> $ownerFullName   </b><br>
                                тел: <b> $ownerPhone    </b><br>
                                e-mail: <b> $ownerEmail    </b></div><br>
                                <div style="height: 150px; width: 100%;">
                                <img align="right" src="images/pechat.png">
                                </div>
                  </td>
                </tr><tr style="    box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" itemprop="handler" itemscope style="    box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">

                  </td>
                </tr><tr style="    box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="    box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                По всем вопросам обращайтесь по тел. <b>8-800-222-64-99</b> Звонок бесплатный
</td>
                </tr></table></body>
</html>'
ENDHTML;

        $dompdf->loadHtml($html);
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents("tickets/" . $this->reservation->id . $this->user->email . ".pdf", $output);
    }

}
