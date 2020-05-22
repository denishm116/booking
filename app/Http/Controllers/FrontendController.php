<?php

namespace App\Http\Controllers;

use App\Additional;
use App\Address;
use App\City;
use App\Distance;

use App\Mail\AdminReservationMail;
use App\Rservice;
use Carbon\Carbon;
use App\Infrastructure;
use App\Room;
use App\Price;
use App\Sortable;
use App\SendCode;
use App\Sortprice;
use App\TouristObject;
use App\Type;
use App\User;
use function GuzzleHttp\default_ca_bundle;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Enjoythetrip\Interfaces\FrontendRepositoryInterface; /* 12 13  */
use App\Enjoythetrip\Gateways\FrontendGateway;
use App\Http\Controllers\SendMail;
use Illuminate\Support\Facades\Input;
use mysql_xdevapi\Collection;
use phpDocumentor\Reflection\DocBlock\Description;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;


use Illuminate\Support\Facades\Mail;
use App\Events\OrderPlacedEvent; /* Lecture 54 */

use Illuminate\Support\Facades\Cache;
use mysql_xdevapi\Exception;
use phpDocumentor\Reflection\Types\Object_;

use Psy\Util\Json;
use YandexCheckout\Model\Payment;
use YandexCheckout\Client;
use App\YandexPayment;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;


class FrontendController extends Controller
{
    public function __construct(FrontendRepositoryInterface $frontendRepository, FrontendGateway $frontendGateway)
    {

        $this->middleware('auth')->only(['makeReservation', 'addComment', 'like', 'unlike']);

        $this->fR = $frontendRepository;
        $this->fG = $frontendGateway;

//      $this->cities = City::all()->sortBy('name');
        $this->cities = City::has('objects')->orderBy('name')->get();

        $this->types = Type::all();
    }


    public function confidential_policy()
    {
        return view('frontend.confidential_policy');
    }

    public function index()
    {
        $objects = $this->fR->getObjectsForMainPage();
        $conditions = $this->fG->getRoomConditions();
        return view('frontend.index', ['objects' => $objects, 'types' => $this->types, 'cities' => $this->cities, 'conditions' => $conditions]);

    }


    public function favourites($id)
    {
//        dd($id);
        if ($id == '') {
            $rooms = [];
//            return redirect()->route('fr')->with('message', 'В избранном пусто! Для того, чтобы добавить номер в Избранное, нажимайте на сердечко');
        } else {
            $ids = explode(',', $id);
            $rooms = $this->fR->getRoomsForFavourites($ids);
        }


        return view('frontend.favourites', ['rooms' => $rooms, 'types' => $this->types]);
    }


    public function getRoomCity($id)
    {
        $room = Room::with('object')->find($id)->object->city_id;
        $city = City::find($room);
        return $city;
    }

    public function getObjectCity($id)
    {

        $object = TouristObject::find($id)->city_id;
        $city = City::find($object);
        return $city;
    }


    public function getCityAlias()
    {
        $alias = $this->cities->pluck('alias');
        return $alias;
    }


    public function getTypeAlias()
    {
        $alias = $this->types->pluck('alias');
        return $alias;
    }


//    public function myPagination($array, $perPage, $alias)
//    {
//        $page = Input::get('page', 1);
//        if ($page > count($array) or $page < 1) {
//            $page = 1;
//        }
//        $offset = ($page * $perPage) - $perPage;
//        $articles = $array->slice($offset, $perPage);
//        $roomsP = new LengthAwarePaginator($articles, sizeof($array), $perPage);
//        $roomsP->withPath($alias . '/');
//        return $roomsP;
//    }

    //Получение данных по номерам при помощи ЧПУ
    public function city($city, Request $request)
    {
        $h1seo = $this->fG->seoCityArray();
        $allRooms = $this->fG->getAllRooms($city);
        $leftMenu1 = $this->fG->getTypeListForLeftMenu();
        $requestSegment = $request->segment(2);
        $conditionsAll = $this->fG->getRoomConditions($city);
        $krim = $this->fG->getCityByAlias($city);
//        if ($city == 'favourites') {
////            dd($request->get('id'));
//          return redirect()->route('favourites', ['id'=>$request->get('id')]);
//
//        }
        return view('frontend.city', ['h1seo' => $h1seo[$city] ?? 'Крыму', 'city' => $city, 'rooms' => $allRooms, 'cities' => $this->cities, 'leftMenu1' => $leftMenu1, 'types' => $leftMenu1, 'conditionsAll' => $conditionsAll, 'requestSegment' => $requestSegment, 'krim' => $krim]);
    }

    public function typesAvailable($city = 'krim', $type, Request $request)
    {
        if($city == 'favourites' && $type == 'favourite') {
            return $this->favourites($condition = '');
        }

        $h1seo = $this->fG->seoCityArray();
        $allRooms = $this->fG->getRoomsCityAndTypes($city, $type);
        $conditionsAll = $this->fG->getRoomConditions();
        $leftMenu1 = $this->fG->getTypeListForLeftMenu();
        $conditionsTypes = $this->fG->getRoomConditions($city, $type);
        $requestSegment = $request->segment(2);
        $krim = $this->fG->getCityByAlias($city);

        //Проверка на алупка/отдых-с-детьми
        foreach ($conditionsAll as $item) {
            if ($type == $item[1]) {
                $seoType = '';
//
                $allRooms = $this->fG->conditionsAll($city, $type);
                $conditionsTypes = $this->fG->getRoomConditions($city);

                foreach ($conditionsTypes as $ty) {
                    if ($ty[1] == $type) {
                        $seoType = $ty[2];
                    }
                }
                return view('frontend.conditionseoall', ['h1seo' => $h1seo[$city], 'rooms' => $allRooms, 'city' => $city, 'requestSegment' => $requestSegment, 'typeForSegment' => $type, 'cities' => $this->cities, 'type' => $leftMenu1, 'typesAlias' => $leftMenu1, 'conditionsTypes' => $conditionsTypes, 'conditionsAll' => $conditionsAll, 'seoType' => $seoType, 'krim' => $krim]);
                break;
            }
        }
        $seoType = $this->fR->getTypeByAlias($type);

        return view('frontend.typesseo', ['h1seo' => $h1seo[$city], 'rooms' => $allRooms, 'city' => $city, 'requestSegment' => $requestSegment, 'typeForSegment' => $type, 'cities' => $this->cities, 'typesAlias' => $leftMenu1, 'conditionsTypes' => $conditionsTypes, 'conditionsAll' => $conditionsAll, 'seoType' => $seoType, 'krim' => $krim]);
    }


    public function cityConditions($city = 'krim', $type, $condition, Request $request)
    {
        $h1seo = $this->fG->seoCityArray();
        $allRooms = '';
        $conditions = $this->fG->getRoomConditions();
        $seoType = $this->fR->getTypeByAlias($type);
        $seoCondition = '';
        foreach ($conditions as $cond) {
            if ($cond[1] == $condition) {
                $seoCondition = $cond[2];
            }
        }

        if ($city == 'krim') {

            foreach ($conditions as $item) {
                if ($condition == $item[1]) {
                    $allRooms = $this->fG->getRoomsAdditionalsCityTypes($city, $type, $condition);
                }
            }
            if ($condition == 'otdih-u-moria') {
                $allRooms = $this->fG->getRoomsFirstLineCityTypes($city, $type);
            }

            if ($condition == 'all-inclusive') {
                $allRooms = $this->fG->getRoomsAllInclusiveCityTypes($city, $type);
            }
        }


        if ($condition) {
            foreach ($conditions as $item) {
                if ($condition == $item[1]) {
                    $allRooms = $this->fG->getRoomsAdditionalsCityTypes($city, $type, $condition);
                }
            }
            if ($condition == 'otdih-u-moria') {
                $allRooms = $this->fG->getRoomsFirstLineCityTypes($city, $type);
            }

            if ($condition == 'all-inclusive') {
                $allRooms = $this->fG->getRoomsAllInclusiveCityTypes($city, $type);
            }
        }

        $conditionsTypes = $this->fG->getRoomConditions($city, $type);
        $requestSegment2 = $request->segment(2);
        $requestSegment3 = $request->segment(3);

        $leftMenu1 = $this->fG->getTypeListForLeftMenu();

        if ($city == 'favourites') {
//            dd($condition);
          return $this->favourites($condition);
        }
        return view('frontend.conditionsseo', ['h1seo' => $h1seo[$city], 'rooms' => $allRooms, 'city' => $city, 'cities' => $this->cities, 'type' => $leftMenu1, 'typesAlias' => $leftMenu1, 'conditionsTypes' => $conditionsTypes, 'requestSegment2' => $requestSegment2, 'requestSegment3' => $requestSegment3, 'seoType' => $seoType, 'seoCondition' => $seoCondition]);
    }

    public function article($id)
    {
        $article = $this->fR->getArticle($id);
        return view('frontend.article', compact('article'));
    }


    public function object($id)
    {
        $object = $this->fR->getObject($id);
        setcookie('object_seen' . $object->id, 'yes');

        $name = $object->city->name;
        $alias = City::where('name', $name)->first()->alias;
        $h1seo = $this->fG->seoCityArray()[$alias];

        return view('frontend.object', ['h1seo' => $h1seo, 'object' => $object, 'cities' => $this->cities]);
    }

    public function person($id)
    {
        $user = $this->fR->getPerson($id);
        return view('frontend.person', ['user' => $user]);
    }

    public function room($id)
    {
        setlocale(LC_TIME, 'ru_RU.UTF-8');
        Cookie::queue(Cookie::make('room_seen' . $id, $id, null, null, null, false, false));
        $room = $this->fR->getRoom($id);
        $name = $room->object->city->name;
        $alias = City::where('name', $name)->first()->alias;
        $h1seo = $this->fG->seoCityArray()[$alias];
//dd($_SERVER['REDIRECT_URL']);
        return view('frontend.room', ['h1seo' => $h1seo, 'cities' => $this->cities, 'room' => $room, 'redir' => $_SERVER['REDIRECT_URL']]/* 20 */);
    }


    public function ajaxGetRoomReservations($id)
    {
        $reservations = $this->fR->getReservationsByRoomId($id);
        return response()->json([
            'reservations' => $reservations
        ]);
    }


    public function roomsearch(Request $request /* 18 */)
    {
        if ($city = $this->fG->getSearchResults($request)) {
            $name = $request->input('city');
            if (isset(City::where('name', $name)->first()->alias)) {
                $alias = City::where('name', $name)->first()->alias;
                $h1seo = $this->fG->seoCityArray()[$alias];
            } else {
                $h1seo = 'Крыму';
            }
            $reservationPrice = [];

            $dateIn = new \DateTime($request->get('checkin'));
            $dateOut = new \DateTime($request->get('checkout'));

            $interval = iterator_count($this->fG->datesPeriod($dateIn->format("Y-m-d"), $dateOut->format("Y-m-d")));

            if (is_array($city))
                $reservationPrice[] = ['checkin' => $request->input('checkin'), 'checkout' => $request->input('checkout'), 'price' => 0, 'interval' => $interval];
//dd($city);
            foreach ($city as $k => $room) {
                $room_id = $room->id;
                $totalPrice = $this->fG->priceCounter($room_id, $request);
                $reservationPrice[$k] = ['checkin' => $request->input('checkin'), 'checkout' => $request->input('checkout'), 'price' => $totalPrice, 'interval' => $interval];
            }
//            }
            return view('frontend.roomsearch', ['h1seo' => $h1seo, 'city' => $city, 'cities' => $this->cities, 'reservationPrice' => $reservationPrice]);

        } else /* 18 */ {
            if (!$request->ajax()) {
                $h1seo = $this->fG->seoCityArray();

                $alias = City::all()->where('name', $request->get('city'))->first()->alias;

                return view('frontend.roomsearch', ['h1seo' => $h1seo[$alias], 'city' => false, 'cities' => $this->cities]);
//                return redirect('/')->with('norooms', __('По Вашему запросу ничего не найдено. Может быть вы допустили опечатку?'));
            }

        }
    }


    public function additionals()
    {

        return Additional::all()->all();
    }

    public function rservices()
    {

        return Rservice::all()->all();
    }

    public function infrastructures()
    {

        return Infrastructure::all()->all();
    }

    public function types()
    {

        return Type::all()->all();
    }

    public function distances()
    {

        return Distance::all()->all();
    }

    public function sortprices()
    {
        return Sortprice::all()->all();
    }

    public function getCoords($id)
    {
        $coords = [];
        $latitude = TouristObject::all()->where('id', $id)->pluck('latitude');
        $longitude = TouristObject::all()->where('id', $id)->pluck('longitude');
        $coords[] = $longitude;
        $coords[] = $latitude;
        return $coords;
    }

    public function putCoords(Request $request)
    {
        $obj = new TouristObject();
        $object = $obj->find($request->id);
        $object->latitude = $request->latitude;
        $object->longitude = $request->longitude;
        $object->save();
    }


    public function searchCities(Request $request)
    {
        $results = $this->fG->searchCities($request);
        return response()->json($results);
    }


    public function like($likeable_id, Request $request)
    {
        $type = 'App\TouristObject';
        $this->fR->like($likeable_id, $type, $request);
        Cache::flush(); /*  55 */
        return redirect()->back();
    }


    public function unlike($likeable_id, Request $request)
    {
        $type = 'App\TouristObject';
        $this->fR->unlike($likeable_id, $type, $request);

        Cache::flush();

        return redirect()->back();
    }


    public function addComment($commentable_id, Request $request)
    {

        $type = 'App\TouristObject';
        $this->fG->addComment($commentable_id, $type, $request);

        Cache::flush(); /*  55 */

        return redirect()->back();
    }


    public function makeReservation($room_id, $city_id, Request $request)
    {

        $avaiable = $this->fG->checkAvaiableReservations($room_id, $request);

        if (!$avaiable) {
            if (!$request->ajax()) {
                $request->session()->flash('reservationMsg', __('Извините, даты заняты'));
                return redirect()->route('room', ['id' => $room_id, '#reservation']);
            }

            return response()->json(['reservation' => false]);
        } else {

            setlocale(LC_TIME, 'ru_RU.UTF-8');
            $room = Room::find($room_id);
            $addr = new Address;
            $city = City::find($city_id);
            $addres = $addr->where('object_id', $room->object->id)->first();
            $object = TouristObject::find($room->object->id);
            $owner = User::find($object->user_id);
            $day_in = $request->input('checkin');
            $day_out = $request->input('checkout');
            $description = $request->input('description');
            $user = Auth::user();

            $totalPrice = $this->fG->priceCounter($room_id, $request);

            if (is_array($totalPrice)) {
                return back()->with('reservationMsg', $totalPrice['error']);
            }

            $reward = $totalPrice * 0.1;

            //Создание экземпляра платежа Yandex.Касса
            $pay = new YandexPayment();
            $payment = $pay->getToken($reward, $room_id, $day_in, $day_out);

            $token = $payment->confirmation->confirmationToken;

            if (!$request->ajax()) {

                if ($owner->email == Auth::user()->email || $user->hasRole(['admin'])) {
                    $reservation = $this->fG->makeReservation($room_id, $city_id, $day_in, $day_out, $totalPrice, $description);
                    event(new OrderPlacedEvent($reservation)); /* Lecture 54 */
                    return redirect()->route('adminHome');
                } else {

                    session(['owner' => $owner, 'object' => $object, 'addres' => $addres, 'city' => $city, 'city_id' => $city_id, 'room_id' => $room_id, 'totalPrice' => $totalPrice, 'day_in' => $day_in, 'day_out' => $day_out, 'description' => $description, 'room' => $room, 'paymentId' => $payment->_id]);

                    return view('frontend.orderblank', ['city' => $city->name, 'addres' => $addres, 'owner' => $owner, 'object' => $object, 'token' => $token, 'day_in' => $day_in, 'day_out' => $day_out, 'totalPrice' => $totalPrice, 'user' => $user]);
                }
            } else {
                return response()->json(['reservation' => 'reservation']);
            }
        }

    }


    public function ownerdata()
    {
        setlocale(LC_TIME, 'ru_RU.UTF-8');
        $owner = session('owner');
        $object = session('object');
        $addres = session('addres');
        $room = session('room');
        $city = session('city');
        $user = Auth::user();

        $room_id = session('room_id');
        $city_id = session('city_id');
        $totalPrice = session('totalPrice');
        $day_in = session('day_in');
        $day_out = session('day_out');
        $description = session('description');

        $paymentId = session('paymentId');

        $pay = new YandexPayment();
        $payment = $pay->getPaymentId($paymentId);


        if ($payment->_status == 'waiting_for_capture') {

            $reservation = $this->fG->makeReservation($room_id, $city_id, $day_in, $day_out, $totalPrice, $description);

            //Записываем в БД ID платежа
            $this->fR->setPaymentId($reservation, $payment->_id);

            event(new OrderPlacedEvent($reservation));

            Mail::to('denishm118@mail.ru')->send(new AdminReservationMail($reservation, $owner, $object, $addres, $city, $user, $room));
            Mail::to($owner->email)->send(new AdminReservationMail($reservation, $owner, $object, $addres, $city, $user, $room));
            $sendSms = new SendCode();
            $sendSms->sendSmsAboutReservation($owner->phone, $reservation, $user);

            return redirect()->route('ownerafterpay');

        } else if ($payment->_status == 'canceled') {
            $reasonDescription = $payment->_cancellationDetails->_reason;
            $iniciator = $payment->_cancellationDetails->_party;
            $reasonArray = $this->fG->reasons();
            $reason = $reasonArray[$reasonDescription];
            return redirect()->route('paymenterror', ['reason' => $reason, 'iniciator' => $iniciator]);

        } else {
            return redirect()->route('paymenterror', ['reason' => 'Неизвестная ошибка', 'iniciator' => 'Неизвестно']);
        }

    }

    public function ownerafterpay()
    {
        return view('frontend.ownerafterpay', ['user' => Auth::user()]);
    }

    public function paymenterror($reason = 'Неизвестная ошибка', $iniciator = 'Неизвестно')
    {
        return view('frontend.paymenterror', ['iniciator' => $iniciator, 'reason' => $reason, 'user' => Auth::user()]);
    }

    public function forowners()
    {
        return view('frontend.forowners');
    }

    public function contacts()
    {
        return view('frontend.contacts');
    }

    public function guest_agreement()
    {
        return view('frontend.guest_agreement');
    }


    public function landlord_agreement()
    {
        return view('frontend.landlord_agreement');
    }

}

