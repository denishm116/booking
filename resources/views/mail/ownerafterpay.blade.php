<!DOCTYPE html>
<html style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Приятного отдыха</title>


<style type="text/css">
    img {
    max-width: 100%;
}
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
        padding: 0 !important; width: 100% !important;
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



    a:hover {
        color: #09F !important;
        text-decoration: underline !important;
    }

    a:hover#vw {
        background-color: #CCC !important;
        text-decoration: none !important;
        color: #000 !important;
    }

    a:hover#ff {
        background-color: #6CF !important;
        text-decoration: none !important;
        color: #FFF !important;
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





</style>
</head>

<body itemscope itemtype="http://schema.org/EmailMessage" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">

<table class="body-wrap" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6"><tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
    <td class="container" width="600" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
      <div class="content" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
        <table class="main" width="100%" cellpadding="0" cellspacing="0" itemprop="action" itemscope itemtype="http://schema.org/ConfirmAction" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff"><tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-wrap" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;" valign="top">
              <meta itemprop="name" content="Confirm Email" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;" /><table width="100%" cellpadding="0" cellspacing="0" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                <div>
                                    <a class="krim_Leto_ru" href="/">Krim-leto<span class="logo-orange">.ru</span>
                                    </a>

                                </div>
                                <h1 style="text-align: center">Добро пожаловать в Крым!</h1>
   <h2 style="text-align: center">Уважаемый {{ $user->name }}!</h2>
                <h4>Данное письмо является подтверждением того, что Вы -  {{ $user->name}}  {{ $user->surname}}, забронировали:</h4>

                                <p>Уникальный номер бронирования: <b>{{$reservation->id}}</b></p>
                                <p>Название объекта размещения: <b>{{$object->name}}</b></p>
                                <p>Номер/Аппартаменты id: <b>{{$room->id}}</b></p>

                                <p>Населенный пункт: <b>{{$city->name}}</b></p>
                                <p>Адрес: <b> ул. {{$addres->street}}</b> д. <b>{{$addres->number}}</b></p>
                                <p>Дата заезда: <b> {{$reservation->day_in}}</b> </p>
                                <p>Дата выезда: <b> {{$reservation->day_out}}</b> </p>
                                <p>Полная стоимость бронирования: <b> {{$reservation->price}} руб.</b> </p>
                                <p>Оплачено: <b> {{$reservation->reward}} руб.</b> </p>
                                <p>Остаток оплаты: <b> {{$reservation->price - $reservation->reward}} руб.</b> </p>
                                <p>Контактное лицо (в объекте размещения): <b>{{$owner->name}} {{$owner->surname}} </b></p>
                                <p>тел: <b>{{$owner->phone}} </b></p>
                                <p>e-mail: <b>{{$owner->email}} </b></p>
                  </td>
                </tr><tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" itemprop="handler" itemscope style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                    <hr>
                  </td>
                </tr><tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                По всем вопросам обращайтесь по тел. <b>8-800-222-64-99</b> Звонок бесплатный
</td>
                </tr></table></td>
          </tr></table><div class="footer" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
          <table width="100%" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="aligncenter content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top"><a href="https://krim-leto.ru" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #999; text-decoration: underline; margin: 0;">krim-leto.ru</a></td>
            </tr></table></div></div>
    </td>
    <td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
  </tr></table></body>
</html>
