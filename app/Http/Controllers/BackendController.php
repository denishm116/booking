<?php


namespace App\Http\Controllers;

use App\City;
use App\Reservation;
use App\Room;


use Dompdf\Dompdf;
use Dompdf\Options;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\GuestReservationMail;

use App\User;
use Illuminate\Http\Request;

use App\Enjoythetrip\Interfaces\BackendRepositoryInterface;

use App\Enjoythetrip\Gateways\BackendGateway;

use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

use App\Events\ReservationConfirmedEvent;

use Illuminate\Support\Facades\Cache;

use App\YandexPayment;

class BackendController extends Controller
{
    use \App\Enjoythetrip\Traits\Ajax;

    /* Lecture 30 */

    public function __construct(BackendGateway $backendGateway, BackendRepositoryInterface $backendRepository)
    {

        $this->middleware('CheckOwner')->only(['confirmReservation', 'saveRoom', 'saveObject', 'myObjects']);/*  36 */
        $this->middleware('CheckAdmin')->only(['adminpage']);

        $this->bG = $backendGateway;
        $this->bR = $backendRepository;
    }


    public function index(Request $request)
    {
        $objects = $this->bG->getReservations($request);
        $authUserObject = $this->bR->getUserWithObject($request->user()->id);

        return view('backend.index', ['objects' => $objects, 'authUserObject' => $authUserObject]);
    }


    public function index2(Request $request)
    {

        $room = Room::with('reservations')->find(66);
        $cal = new \om\IcalParser();
        $results = $cal->parseFile(
            'https://admin.booking.com/hotel/hoteladmin/ical.html?t=14ccdd88-7009-4065-8a51-321fcaada98c'
        );

        $otherServiceReservatios = [];

        $krimletoReservations = [];


        foreach ($cal->getSortedEvents() as $r) {
            $otherServiceReservatios[] = [$r['DTSTART']->format('Y-m-d'), $r['DTEND']->format('Y-m-d')];
        }

        foreach ($room->reservations as $reservation) {
            $krimletoReservations[] = [$reservation->day_in, $reservation->day_out];
        }
//dd($otherServiceReservatios);
        foreach ($krimletoReservations as $kl) {
            foreach ($otherServiceReservatios as $other) {
                if ($kl[0] < $other[0] && $kl[1] < $other[1]) {
                    dump('work');
                }
            }

        }

        $objects = $this->bG->getReservations($request);
        return view('backend.index2', ['objects' => $objects]);
    }


    public function myobjects(Request $request /*  46 */)
    {
        $authUserObject = $this->bR->getUserWithObject($request->user()->id);
        if (Auth::user()->hasRole(['admin'])) {
            $objects = $this->bR->getAllObjects();
            return view('backend.myobjects', ['objects' => $objects, 'authUserObject' => $authUserObject]/*  46 */);
        } else {
            $objects = $this->bR->getMyObjects($request); /* Lecture 46 */
            return view('backend.myobjects', ['objects' => $objects, 'authUserObject' => $authUserObject]/*  46 */);
        }
    }

    public function profile(Request $request)
    {

        if ($request->isMethod('post')) {

            $user = $this->bG->saveUser($request);

            if ($request->hasFile('userPicture')) {
                $path = $request->file('userPicture')->store('users', 'public'); /*  40 */

                /*  40 */
                if (count($user->photos) != 0) {
                    $photo = $this->bR->getPhoto($user->photos->first()->id);

                    Storage::disk('public')->delete($photo->storagepath);
                    $photo->path = $path;

                    $this->bR->updateUserPhoto($user, $photo);

                } else {
                    $this->bR->createUserPhoto($user, $path);
                }

            }

            Cache::flush(); /* Lecture 58 */

            return redirect()->back();
        }

        return view('backend.profile', ['user' => Auth::user()]/*  39 */);
    }

    /* Lecture 39 */
    public function deletePhoto($id)
    {

        $photo = $this->bR->getPhoto($id); /*  40 */

        $path = $this->bR->deletePhoto($photo); /*  40 */

        if (Auth::user()->hasRole(['admin'])) {
            Storage::disk('public')->delete($path); /*  40 */
        } else {
            $this->authorize('checkOwner', $photo);

            Storage::disk('public')->delete($path); /*  40 */
        }
        Cache::flush(); /* 55 */

        return redirect()->back();
    }


    public function mainPhoto($id)
    {
        $changeStatus = $this->bR->changeStatus($id);
        return redirect()->back();
    }


    public function saveObject($id = null, Request $request /* Lecture 41 two args */)
    {
        $additionals = $this->bR->getAdditionals();
        $types = $this->bR->getTypes();
        $infrastructures = $this->bR->getInfrastructures();
        $distances = $this->bR->getDistances();

        $users = $this->bR->getUsersOwners();

        /*  41 */
        if ($request->isMethod('post')) {

            if ($id) {

                $this->authorize('checkOwner', $this->bR->getObject($id));

                $this->bG->saveObject($id, $request);

                return back();

                Cache::flush(); /* Lecture 55 */

            } else {
                $this->bG->saveObject($id, $request);
                return redirect()->route('myObjects');
            }
        }
        /* 41 */
        if ($id) {

            return view('backend.saveobject', ['object' => $this->bR->getObject($id), 'cities' => $this->bR->getCities(), 'types' => $types, 'additionals' => $additionals, 'infrastructures' => $infrastructures, 'distances' => $distances, 'users' => $users]);
        } else {

            return view('backend.saveobject', ['cities' => $this->bR->getCities(), 'additionals' => $additionals, 'types' => $types, 'infrastructures' => $infrastructures, 'distances' => $distances, 'users' => $users]);
        }
    }


    /* Lecture 47 */
    public function saveRoom($id = null, Request $request)
    {
        setlocale(LC_TIME, 'ru_RU.UTF-8');

        $rservices = $this->bR->getRservices();

        if ($request->isMethod('post')) {
            foreach ($request->get('period_start') as $key => $value) {
                $request->request->add(['period' . ($key + 1) . 'start' => $value]);
            }

            foreach ($request->get('period_end') as $key => $value) {
                $request->request->add(['period' . ($key + 1) . 'end' => $value]);
            }

            foreach ($request->get('prices') as $key => $value) {
                $request->request->add(['price' . ($key + 1) => $value]);
            }

            if ($id) {// editing room

                $this->authorize('checkOwner', $this->bR->getObject($this->bR->getRoom($id)->object_id));

                $this->bG->saveRoom($id, $request);

                return redirect()->back();
                Cache::flush(); /* e 55 */
            } else {  // adding a new room
                $this->bG->saveRoom($id, $request);
                return redirect()->route('myObjects');
            }

        }

        if ($id) {
            return view('backend.saveroom', ['room' => $this->bR->getRoom($id), 'rservices' => $rservices]);
        } else {
            return view('backend.saveroom', ['object_id' => $request->input('object_id'), 'rservices' => $rservices]);
        }
    }

    /* Lecture 47 */
    public function deleteRoom($id)
    {
        $room = $this->bR->getRoom($id); /* Lecture 48 */
        $this->authorize('checkOwner', $room); /* Lecture 48 */
        $this->bR->deleteRoom($room); /* Lecture 48 */
        Cache::flush(); /* Lecture 55 */
        return redirect()->back(); /* Lecture 48 */
    }

    /*  33 */
    public function confirmReservation($id)
    {
        $reservation = $this->bR->getReservation($id);
        $this->authorize('reservation', $reservation); /*  35 */

        if ($paymentId = $this->bR->getPaymentId($reservation)) {
            $conf = new YandexPayment();
            $conf->confirmPayment($paymentId);
            $this->sendMailToGuest($id);
        }

        $this->bR->confirmReservation($reservation);
        $this->flashMsg('success', __('Бронирование подтверждено'));  /*  35 */


        event(new ReservationConfirmedEvent($reservation)); /*  54 */

        if (!\Request::ajax()) /*  35 */
            return redirect()->back(); /*  35 */
    }

    public function sendMailToGuest($id)
    {
        $reservation = $this->bR->getReservation($id);
        $object = Reservation::find($id)->room->object;
        $user = User::find($reservation->user_id);
        $city = City::find($reservation->city_id);
        $room = Reservation::find($id)->room;
        $owner = Reservation::find($id)->room->object->user;
        $addres = Reservation::find($id)->room->object->address;
        $cost = $reservation->price - $reservation->reward;
        $options = new Options();
        $options->set('defaultFont', 'dejavu sans');
        $dompdf = new DOMPDF($options);
        $html = <<< ENDHTML
<!DOCTYPE html>
<html>
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
   <h2 style="text-align: center">Уважаемый $user->name!</h2>
                <h4>Данное письмо является подтверждением того, что Вы - $user->name  $user->surname, забронировали:</h4>

                                <p>Уникальный номер бронирования: <b>$reservation->id</b></p>
                                <p>Название объекта размещения: <b>$object->name</b></p>
                                <p>Номер/Аппартаменты id: <b>$room->id</b></p>

                                <p>Населенный пункт: <b>$city->name</b></p>
                                <p>Адрес: <b> ул. $addres->street</b> д. <b>$addres->number</b></p>
                                <p>Дата заезда: <b> $reservation->day_in</b> </p>
                                <p>Дата выезда: <b> $reservation->day_out</b> </p>
                                <p>Полная стоимость бронирования: <b>  $reservation->price   руб.</b> </p>
                                <p>Оплачено: <b>  $reservation->reward   руб.</b> </p>
                                <p>Остаток оплаты: <b>  $cost  руб.</b> </p>
                                <div style="background: #90dbf6; padding: 5px;">
                                <p >Контактное лицо (в объекте размещения): <b> $owner->name    $owner->surname   </b></p>
                                <p>тел: <b> $owner->phone   </b></p>
                                <p>e-mail: <b> $owner->email   </b></p></div>
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
//        $dompdf->stream("werlcome.pdf");
        $output = $dompdf->output();
        file_put_contents("file.pdf", $output);

        Mail::to($user->email)->send(new GuestReservationMail($reservation, $owner, $object, $addres, $city, $user, $room));
        return redirect()->back()->with('message', 'Подтверждено');
    }

    public function sendMailToGuestRepeat($id)
    {
        $this->sendMailToGuest($id);
        return redirect()->back()->with('message', 'Письмо отправлено');
    }


    /*  33 */
    public function deleteReservation($id)
    {
        $reservation = $this->bR->getReservation($id); /*  35 */

        $this->authorize('reservation', $reservation); /*  35 */

        $this->bR->deleteReservation($reservation); /*  35 */

        $this->flashMsg('success', __('Бронирование удалено'));  /*  35 */

        if (!\Request::ajax()) /*  35 */
            return redirect()->back(); /*  34 */
    }


    /* Lecture 44 */
    public function deleteArticle($id)
    {
        $article = $this->bR->getArticle($id); /*  45 */

        $this->authorize('checkOwner', $article); /*  45 */

        $this->bR->deleteArticle($article); /*  45 */

        Cache::flush(); /*  55 */

        return redirect()->back(); /*  45 */
    }


    /*  44 */
    public function saveArticle($object_id = null, Request $request /*  45 */)
    {
        /*  45 */
        if (!$object_id) {
            $this->flashMsg('danger', __('First add an object'));
            return redirect()->back();
        }

        $this->authorize('checkOwner', $this->bR->getObject($object_id)); /*  45 */

        $this->bG->saveArticle($object_id, $request); /*  45 */

        Cache::flush(); /*  55 */

        return redirect()->back(); /* Lecture 45 */
    }


    /* Lecture 46 */
    public function deleteObject($id)
    {
        $this->authorize('checkOwner', $this->bR->getObject($id));

        $this->bR->deleteObject($id);

        Cache::flush(); /* Lecture 55 */

        return redirect()->back();

    }


    /*  53 */
    public function getNotifications()
    {
        return response()->json($this->bR->getNotifications()); // for mobile
    }


    /*  53 */
    public function setReadNotifications(Request $request)
    {
        return $this->bR->setReadNotifications($request); // for mobile
    }

//    public function adminpage()
//    {
//        $citys = $this->bR->getCities();
//        $owners = $this->bR->getUsersOwners();
//        $guests = $this->bR->getUsersGuests();
//        $objects = $this->bG->getAllObjects();
////        dd($objects);
//        return view('backend.adminpage', compact(['owners', 'guests', 'objects', 'citys']));
//    }


}

