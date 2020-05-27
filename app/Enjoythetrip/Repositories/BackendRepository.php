<?php

namespace App\Enjoythetrip\Repositories;


use App\Enjoythetrip\Interfaces\BackendRepositoryInterface;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;
use App\{Additional,
    Distance,
    Infrastructure,
    Price,
    Rservice,
    TouristObject,
    Reservation,
    City,
    Type,
    User,
    Photo,
    Address,
    Article,
    Room,
    Notification};




class BackendRepository implements BackendRepositoryInterface
{


    /* 28 */
    public function getOwnerReservations($request)
    {
        return TouristObject::with([

            'rooms' => function ($q) {
                $q->has('reservations'); // works like where clause for Room
            }, // give me rooms only with reservations, if it wasn't there would be rooms without reservations

            'rooms.reservations.user'

        ])
            ->has('rooms.reservations')// ensures that it gives me only those objects that have at least one reservation, has() here works like where clause for Object
            ->where('user_id', $request->user()->id)
            ->get();
    }

    public function getAllReservations($request)
    {
        return TouristObject::with([

            'rooms' => function ($q) {
                $q->has('reservations'); // works like where clause for Room
            }, // give me rooms only with reservations, if it wasn't there would be rooms without reservations

            'rooms.reservations.user'

        ])
            ->has('rooms.reservations')// ensures that it gives me only those objects that have at least one reservation, has() here works like where clause for Object
            ->paginate(8);
    }


    /* 28 */
    public function getTouristReservations($request)
    {

        return TouristObject::with([

            'rooms.reservations' => function ($q) use ($request) { // filters reserervations of other users

                $q->where('user_id', $request->user()->id);

            },

            'rooms' => function ($q) use ($request) {
                $q->whereHas('reservations', function ($query) use ($request) {
                    $query->where('user_id', $request->user()->id);
                });
            },

            'rooms.reservations.user'

        ])
            ->whereHas('rooms.reservations', function ($q) use ($request) {  // acts like has() with additional conditions

                $q->where('user_id', $request->user()->id);

            })
            ->get();
    }

    /* Lecture 30 */
    public function getReservationData($request)
    {
//        dd($request->input('room_id'));
        return Reservation::with('user', 'room')
            ->where('room_id', $request->input('room_id'))
            ->where('day_in', '<=', date('Y-m-d', strtotime($request->input('date'))))
            ->where('day_out', '>=', date('Y-m-d', strtotime($request->input('date'))))
            ->where('day_out', '>=', date('Y-m-d', strtotime($request->input('date'))))
//            ->where('day_in', '<=', date('d-m-Y', strtotime($request->input('date'))))
//            ->where('day_out', '>=', date('d-m-Y', strtotime($request->input('date'))))
//            ->where('day_out', '>=', date('d-m-Y', strtotime($request->input('date'))))

            ->first();
    }


    /* Lecture 35 */
    public function getReservation($id)
    {
        return Reservation::find($id);
    }


    /* Lecture 35 */
    public function deleteReservation(Reservation $reservation)
    {
        return $reservation->delete();
    }


    /* Lecture 35 */
    public function confirmReservation(Reservation $reservation)
    {
        return $reservation->update(['status' => true]);
    }
    public function removeConformirmation(Reservation $reservation)
    {
        return $reservation->update(['status' => false]);
    }
    /* Lecture 35 */
    public function removeConfirmation(Reservation $reservation)
    {
        return $reservation->update(['status' => true]);
    }

    /* Lecture 37 */
    public function getCities()
    {
        return City::orderBy('name', 'asc')->get();
    }


    /* Lecture 37 */
    public function getCity($id)
    {
        return City::find($id);
    }


    /* Lecture 37 */
    public function createCity($request)
    {
//        dd(Str::slug(mb_substr($request->input('name'), 0, 40)));
        return City::create([
            'name' => $request->input('name'),
            'alias' => Str::slug(mb_substr($request->input('name'), 0, 40)),
        ]);
    }


    /* Lecture 37 */
    public function updateCity($request, $id)
    {
        return City::where('id', $id)->update([
            'name' => $request->input('name'),
            'alias' => Str::slug(mb_substr($request->input('name'), 0, 40)),
        ]);
    }


    /* Lecture 37 */
    public function deleteCity($id)
    {
        return City::where('id', $id)->delete();
    }


    /* Lecture 39 */
    public function saveUser($request)
    {
        $user = User::find($request->user()->id);
        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->email = $request->input('email');
        $user->save();

        return $user;
    }


    /* Lecture 40 */
    public function getPhoto($id)
    {
        return Photo::find($id);
    }


    /* Lecture 40 */
    public function updateUserPhoto(User $user, Photo $photo)
    {
        return $user->photos()->save($photo);
    }

    /* Lecture 40 */
    public function createUserPhoto($user, $path)
    {
        $photo = new Photo;
        $photo->path = $path;
        $user->photos()->save($photo);
    }

    /* Lecture 40 */
    public function deletePhoto(Photo $photo)
    {
        $path = $photo->storagepath;
        $photo->delete();
        return $path;
    }

    public function changeStatus($id)
    {
        $photo = Photo::find($id);

        Photo::whereIn('id', $photo->photoable->photos->pluck('id')->toArray())->update(['main_photo' => 0]);
        $photo->main_photo = 1;
        $photo->save();

    }


    /* Lecture 42 */
    public function getObject($id)
    {
        return TouristObject::with('additionals')->find($id);
    }


    /* Lecture 42 */
    public function updateObjectWithAddress($id, $request)
    {
//dd($request->input('user_id'));
        Address::where('object_id', $id)->update([
            'street' => $request->input('street'),
            'number' => $request->input('number'),
        ]);

        $object = TouristObject::with('additionals')->find($id);


        $object->name = $request->input('name');
        $object->city_id = $request->input('city');
        $object->description = $request->input('description');
        $object->distance_id = $request->input('distance_id');

        if ($request->input('user_id') != null)
            $object->user_id = $request->input('user_id');

        $object->push();

        $object->additionals()->detach();
        $object->additionals()->attach($request->input('additionals'));

        $object->infrastructures()->detach();
        $object->infrastructures()->attach($request->input('infrastructures'));

        $object->types()->detach();
        $object->types()->attach($request->input('types'));


//        $object->save();

        return $object;

    }


    /* Lecture 42 */
    public function createNewObjectWithAddress($request)
    {
        $object = new TouristObject;
        $object->user_id = $request->user()->id;

        $object->name = $request->input('name');
        $object->city_id = $request->input('city');
        $object->description = $request->input('description');
        $object->distance_id = $request->input('distance_id');

        $object->push();
        $object->additionals()->attach($request->input('additionals'));
        $object->infrastructures()->attach($request->input('infrastructures'));
        $object->types()->attach($request->input('types'));


        $address = new Address;
        $address->street = $request->input('street');
        $address->number = $request->input('number');
        $address->object_id = $object->id;
        $address->save();
        $object->address()->save($address);

        return $object;
    }

    /* Берем из БД значения сортируемых ЧекБоксов для вставки их в Шаблоны*/

    public function getAdditionals()
    {
        $additional = Additional::get()->all();
        return $additional;
    }

    public function getRservices()
    {
        $rservices = Rservice::get()->all();
        return $rservices;
    }

    public function getTypes()
    {
        $types = Type::get()->all();
        return $types;
    }

    public function getInfrastructures()
    {
        $types = Infrastructure::get()->all();
        return $types;
    }


    public function getDistances()
    {
        $distances = Distance::get()->all();
        return $distances;
    }


    /* Lecture 43 */
    public function saveObjectPhotos(TouristObject $object, string $path)
    {

        $photo = new Photo;
        $photo->path = $path;
        return $object->photos()->save($photo);

    }


    /* Lecture 45 */
    public function saveArticle($object_id, $request)
    {
        return Article::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'user_id' => $request->user()->id,
            'object_id' => $object_id,
            'created_at' => new \DateTime(),
        ]);
    }

    /* Lecture 45 */
    public function getArticle($id)
    {
        return Article::find($id);
    }


    /* Lecture 45 */
    public function deleteArticle(Article $article)
    {
        return $article->delete();
    }


    /* Lecture 46 */
    public function getMyObjects($request)
    {
        return TouristObject::with(['rooms', 'rooms.photos'])->where('user_id', $request->user()->id)->get();
    }

    public function getAllObjects()
    {
        return TouristObject::with(['address'])->get();
    }

    public function getUsersOwners()
    {
        $usersOwners = collect([]);
        $users = User::with(['roles', 'objects'])->get();
        foreach ($users as $user) {
            foreach ($user->roles as $role) {

                if ($role->name == 'owner') {
                    $usersOwners->push($user);
                }
            }
        }
        return $usersOwners;
    }

    public function getUsersGuests()
    {
        $userGuests = collect([]);
        $users = User::with('roles')->get();
        foreach ($users as $user) {
            foreach ($user->roles as $role) {
                if ($role->name == 'tourist') {

                    $userGuests->push($user);
                }
            }
        }
        return $userGuests;
    }


    /* Lecture 46 */
    public function deleteObject($id)
    {
        $object = TouristObject::with('additionals')->where('id', $id)->first();

        $object->additionals()->detach();
        $object->infrastructures()->detach();
        $object->types()->detach();
        $object->delete();

        return $object;
//
    }


    /* Lecture 47 */
    public function getRoom($id)
    {
        return Room::with('price')->where('id', $id)->first();
    }


    /* Lecture 48 */
    public function updateRoom($id, $request)
    {

//        $price = Price::with('room')->where('room_id', $id)->first();
        $price = Price::where('room_id', $id)->first();

//        dd($request->input());
        $room = Room::find($id);
        $room->display_name = $request->input('display_name');
        $room->internal_name = $request->input('internal_name');
        $room->room_number = $request->input('room_number');
        $room->room_size = $request->input('room_size');
        $room->price = $request->input('price');
        $room->description = $request->input('description');

        $room->push();

        $room->rservices()->detach();
        $room->rservices()->attach($request->input('rservices'));

        if (!$price) {
            $price = new Price();
            $price->room_id = $id;
        }

        $price->period1start = $request->input('period1start');
        $price->period1end = $request->input('period1end');
        $price->price1 = $request->input('price1');


        $price->period2start = $request->input('period2start');
        $price->period2end = $request->input('period2end');
        $price->price2 = $request->input('price2');


        $price->period3start = $request->input('period3start');
        $price->period3end = $request->input('period3end');
        $price->price3 = $request->input('price3');


        $price->period4start = $request->input('period4start');
        $price->period4end = $request->input('period4end');
        $price->price4 = $request->input('price4');


        $price->period5start = $request->input('period5start');
        $price->period5end = $request->input('period5end');
        $price->price5 = $request->input('price5');

        $price->period6start = $request->input('period6start');
        $price->period6end = $request->input('period6end');
        $price->price6 = $request->input('price6');

        $price->period7start = $request->input('period7start');
        $price->period7end = $request->input('period7end');
        $price->price7 = $request->input('price7');

        $price->period8start = $request->input('period8start');
        $price->period8end = $request->input('period8end');
        $price->price8 = $request->input('price8');

        $price->period9start = $request->input('period9start');
        $price->period9end = $request->input('period9end');
        $price->price9 = $request->input('price9');

        $price->period10start = $request->input('period10start');
        $price->period10end = $request->input('period10end');
        $price->price10 = $request->input('price10');

        $price->period11start = $request->input('period11start');
        $price->period11end = $request->input('period11end');
        $price->price11 = $request->input('price11');

        $price->period12start = $request->input('period12start');
        $price->period12end = $request->input('period12end');
        $price->price12 = $request->input('price12');
        $price->save();

        return $room;
    }


    /* Lecture 48 */
    public function createNewRoom($request)
    {
//
        $room = new Room;
        $price = new Price;
        $object = TouristObject::find($request->input('object_id'));

        $room->object_id = $request->input('object_id');

        $room->display_name = $request->input('display_name');
        $room->internal_name = $request->input('internal_name');
        $room->room_number = $request->input('room_number');
        $room->room_size = $request->input('room_size');
        $room->price = $request->input('price');
        $room->description = $request->input('description');

        $room->push();
        $room->rservices()->attach($request->input('rservices'));
        $object->rooms()->save($room);

//        for ($i = 1; $i <= 12; $i++) {
//            $l = 'period'. $i .'start';
//            $price->period. $i .start = $request->input($l);
//            $price->period1end = $request->input('period1end');
//            $price->price1 = $request->input('price1');
//        }
        $price->period1start = $request->input('period1start');
        $price->period1end = $request->input('period1end');
        $price->price1 = $request->input('price1');

        $price->period2start = $request->input('period2start');
        $price->period2end = $request->input('period2end');
        $price->price2 = $request->input('price2');

        $price->period3start = $request->input('period3start');
        $price->period3end = $request->input('period3end');
        $price->price3 = $request->input('price3');

        $price->period4start = $request->input('period4start');
        $price->period4end = $request->input('period4end');
        $price->price4 = $request->input('price4');

        $price->period5start = $request->input('period5start');
        $price->period5end = $request->input('period5end');
        $price->price5 = $request->input('price5');

        $price->period6start = $request->input('period6start');
        $price->period6end = $request->input('period6end');
        $price->price6 = $request->input('price6');

        $price->period7start = $request->input('period7start');
        $price->period7end = $request->input('period7end');
        $price->price7 = $request->input('price7');

        $price->period8start = $request->input('period8start');
        $price->period8end = $request->input('period8end');
        $price->price8 = $request->input('price8');

        $price->period9start = $request->input('period9start');
        $price->period9end = $request->input('period9end');
        $price->price9 = $request->input('price9');

        $price->period10start = $request->input('period10start');
        $price->period10end = $request->input('period10end');
        $price->price10 = $request->input('price10');

        $price->period11start = $request->input('period11start');
        $price->period11end = $request->input('period11end');
        $price->price11 = $request->input('price11');

        $price->period12start = $request->input('period12start');
        $price->period12end = $request->input('period12end');
        $price->price12 = $request->input('price12');

        $room->price()->save($price);

        //        dd($room->id);
        return $room;
    }


    /* Lecture 48 */
    public function saveRoomPhotos(Room $room, string $path)
    {
        $photo = new Photo;
        $photo->path = $path;
//        dd($path);
        return $room->photos()->save($photo);
    }


    /* Lecture 48 */
    public function deleteRoom(Room $room)
    {
        $room->rservices()->detach();
        return $room->delete();
    }


    /* Lecture 50 */
    public function setReadNotifications($request)
    {
        return Notification::where('id', $request->input('id'))
            ->update(['status' => 1]);
    }


    /* Lecture 52 */
    public function getUserNotifications($id)
    {
        return Notification::where('user_id', $id)->where('shown', 0)->get();
    }


    /* Lecture 52 */
    public function setShownNotifications($request)
    {
        return Notification::whereIn('id', $request->input('idsOfNotShownNotifications'))
            ->update(['shown' => 1]);
    }


    /* Lecture 53 */
    public function getNotifications()
    {
        return Notification::where('user_id', Auth::user()->id)->where('status', 0)->get(); // for mobile
    }

    public function getPaymentId(Reservation $reservation)
    {
        return $reservation->payment_id ?? null;
    }

    public function getUserWithObject ($id) {

    return TouristObject::with(['rooms'])->where('user_id', $id)->get();


    }
}


