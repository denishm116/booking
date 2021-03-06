<?php

namespace App\Http\Controllers;


use App\Address;
use App\City;
use App\Events\OrderPlacedEvent;
use App\Reservation;
use App\Room;
use App\TouristObject;
use App\User;
use App\YandexPayment;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use App\Enjoythetrip\Interfaces\FrontendRepositoryInterface;

/* 12 13  */

use App\Enjoythetrip\Gateways\FrontendGateway;

class ReservationController extends Controller
{
    use Notifiable;

    /**
     * ReservationController constructor.
     */
    public function __construct(FrontendRepositoryInterface $frontendRepository, FrontendGateway $frontendGateway)
    {
        $this->middleware('CheckAdmin');
        $this->fR = $frontendRepository;
        $this->fG = $frontendGateway;
    }

    public function reservationIndex(Request $request)
    {

        $reservations = Reservation::with(['user', 'room', 'room.object.user'])->orderByDesc('id')->paginate(50);
        return view('backend.admin.reservations.index', compact('reservations'));

    }

    public function show($id)
    {
        $reservation = Reservation::with(['user', 'room', 'room.object.user'])->where('id', $id)->first();
        return view('backend.admin.reservations.show', compact('reservation'));
    }

    public function addReservationForm($id = null)
    {
        $users = User::with('roles')->get()->all();
        $objects = TouristObject::with('rooms', 'rooms.price')->get();

        if ($id) {
            $reservation = Reservation::findOrFail($id);
            $user = User::findOrFail($reservation->user_id);
            $room = Room::findOrFail($reservation->room_id);
            $obj = TouristObject::with('rooms')->where('id', $room->object_id)->first();
            $city = City::findOrFail($reservation->city_id);
        }

        if ($id)
            return view('backend.admin.reservations.add', compact(['users', 'objects', 'reservation', 'user', 'room', 'obj', 'city']));
        else
            return view('backend.admin.reservations.add', compact(['users', 'objects']));
    }

    public function create(Request $request, $id = null)
    {
        $avaiable = $this->fG->checkAvaiableReservations($request->get('room_id'), $request);
        if ($id)
            $avaiable = true;
        if (!$avaiable) {
            if (!$request->ajax()) {
                $request->session()->flash('reservationMsg', __('Извините, даты заняты'));
                return redirect()->back()->with('message', 'Даты заняты');
            }
            return response()->json(['reservation' => false]);
        } else {

            $day_in = $request->input('checkin');
            $day_out = $request->input('checkout');
            $description = $request->input('description');

            $totalPrice = $this->fG->priceCounter($request->get('room_id'), $request);

            if (is_array($totalPrice)) {
                return back()->with('reservationMsg', $totalPrice['error']);
            }

            if ($id) {
                $reservation = Reservation::findOrFail($id);
                $comission = 0.1;
                $reward = $totalPrice * $comission;
                $reservation->update([
                    'user_id' => $request->get('user_id'),
                    'city_id' => $request->get('city_id'),
                    'room_id' => $request->get('room_id'),
                    'status' => $request->get('status'),
                    'day_in' => date('Y-m-d', strtotime($request->get('checkin'))),
                    'day_out' => date('Y-m-d', strtotime($request->get('checkout'))),
                    'description' => $description,
                    'price' => $totalPrice,
                    'comission' => $comission,
                    'reward' => $reward,
                    'paid' => $request->get('paid'),

                ]);
                $message = 'Бронирование отредактировано';

            } else {
                $reservation = $this->fG->makeReservation($request->get('room_id'), $request->get('city_id'), $day_in, $day_out, $totalPrice, $description);
                $message = 'Бронирование создано';
                event(new OrderPlacedEvent($reservation));
            }
            return redirect()->route('showReservation', ['id' => $reservation->id])->with('message', $message);
        }
    }


    public function removeReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();
        return redirect()->route('reservationIndex');
    }

    public function returnPayment($id)
    {
        $payment = new YandexPayment();

        $reservation = Reservation::findOrFail($id);
        $payment->returnPayment($reservation->payment_id);
        $reservation->delete();
        return redirect()->route('reservationIndex')->with('message', 'Деньги возвращеныб бронирование удалено!');
    }


    public function getUser($id = null)
    {
        $user = User::findOrFail($id);

        return response()->json($user);
    }


    public function getObject($id = null)
    {
        $object = TouristObject::with('rooms', 'rooms.price')->where('id', $id)->get();
        return response()->json($object);
    }

    public function getCity($id = null)
    {
        $city = City::findOrFail($id);
        return response()->json($city);
    }

    public function getReservationsAjax()
    {

        return Reservation::with(['user', 'room', 'room.object.user'])->orderByDesc('id')->get();
    }


    public function getObjectsAjax()
    {

        return response()->json(TouristObject::with(['user', 'rooms', 'city'])->orderByDesc('id')->get());
    }


}
