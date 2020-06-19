<?php


namespace App\Http\Controllers;

use App\City;
use App\Enjoythetrip\Services\MakePdf;
use App\Reservation;
use App\Room;
use Illuminate\Support\Facades\Mail;
use App\Mail\GuestReservationMail;
use App\User;
use Illuminate\Http\Request;
use App\Enjoythetrip\Interfaces\BackendRepositoryInterface;
use App\Enjoythetrip\Gateways\BackendGateway;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Events\ReservationConfirmedEvent;
use Illuminate\Support\Facades\Cache;
use App\YandexPayment;
use App\SendCode;

class BackendController extends Controller
{
    use \App\Enjoythetrip\Traits\Ajax;

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


    public function saveObject($id = null, Request $request)
    {


        $additionals = $this->bR->getAdditionals();
        $types = $this->bR->getTypes();
        $infrastructures = $this->bR->getInfrastructures();
        $distances = $this->bR->getDistances();

        $users = $this->bR->getUsersOwners();

        if ($request->isMethod('post')) {
            if (Auth::user()->hasRole(['owner'])) {
                SendCode::createObjectNotification('89034593805');
            }
            if ($id) {
                $this->authorize('checkOwner', $this->bR->getObject($id));
                $this->bG->saveObject($id, $request);
                return back();
            } else {
                $object = $this->bG->saveObject($id, $request);
//                dd($object->id);
                if ($object)
                    return redirect()->route('saveRoom', '?object_id=' . $object->id);
                else
                    return redirect()->route('myObjects');
            }
        }

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


    public function confirmReservation($id)
    {
        $reservation = $this->bR->getReservation($id);
        $object = Reservation::find($id)->room->object;
        $user = User::findOrFail($reservation->user_id);
        $city = City::find($reservation->city_id);
        $room = Reservation::find($id)->room;
        $owner = Reservation::find($id)->room->object->user;
        $addres = Reservation::find($id)->room->object->address;
        $this->authorize('reservation', $reservation); /*  35 */

        if ($paymentId = $this->bR->getPaymentId($reservation)) {
            $conf = new YandexPayment();
            $conf->confirmPayment($paymentId);
            $this->makePdf($reservation, $object, $user, $city, $room, $owner, $addres);
            $this->sendMailToGuest($reservation, $object, $user, $city, $room, $owner, $addres);
        }

        $this->bR->confirmReservation($reservation);
        $this->flashMsg('success', __('Бронирование подтверждено'));  /*  35 */


        event(new ReservationConfirmedEvent($reservation)); /*  54 */

        if (!\Request::ajax()) /*  35 */
            return redirect()->back(); /*  35 */
    }

    public function removeConfirmation($id)
    {
        $reservation = $this->bR->getReservation($id);
        $this->authorize('reservation', $reservation);
        $this->bR->removeConformirmation($reservation);
        return redirect()->back();
    }

    public function makePdf($reservation, $object, $user, $city, $room, $owner, $addres)
    {
        $pdf = new makePdf($reservation, $object, $user, $city, $room, $owner, $addres);
        return $pdf->makePdf();
    }

    public function sendMailToGuest($reservation, $object, $user, $city, $room, $owner, $addres)
    {

        Mail::to($user->email)->send(new GuestReservationMail($reservation, $owner, $object, $addres, $city, $user, $room));

    }

    public function sendMailToGuestRepeat($id)
    {
        $reservation = $this->bR->getReservation($id);
        $object = Reservation::find($id)->room->object;
        $user = User::find($reservation->user_id);
        $city = City::find($reservation->city_id);
        $room = Reservation::find($id)->room;
        $owner = Reservation::find($id)->room->object->user;
        $addres = Reservation::find($id)->room->object->address;
        $this->authorize('reservation', $reservation); /*  35 */
        $this->sendMailToGuest($reservation, $object, $user, $city, $room, $owner, $addres);
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

