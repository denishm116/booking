<?php


namespace App\Enjoythetrip\Repositories;


use App\Enjoythetrip\Interfaces\FrontendRepositoryInterface;

use App\{TouristObject, City, Room, Reservation, Article, Type, User, Comment};
use http\Env\Request;
use Illuminate\Support\Facades\Auth;


class FrontendRepository implements FrontendRepositoryInterface
{


    public function getObjectsForMainPage()
    {

        return TouristObject::with(['city', 'photos', 'types', 'rooms', 'distance'])->orderBy('id', 'desc')->paginate(8);
//        return TouristObject::with(['city', 'photos', 'types', 'rooms', 'distance'])->take(8)->orderBy('id', 'desc')->get();
    }


    public function getObject($id)
    {
        return TouristObject::with(['city', 'photos', 'address', 'users.photos', 'rooms.photos', 'comments.user', 'articles.user', 'rooms.object.city'])->find($id);
    }

    public function getObjectsSeo($alias)
    {
        return Type::with(['objects'])->with('objects.city', 'objects.photos', 'objects.types')->where('alias', $alias)->first();
    }


    public function getSearchCities(string $term)
    {
        return City::where('name', 'LIKE', $term . '%')->get();
    }

    public function getCityByAlias($alias)
    {
        return City::where('alias', $alias)->first();
    }


    public function getTypeByAlias($alias)
    {
        return Type::where('alias', $alias)->first();
    }


    public function getAllRooms()
    {
        return Room::with([
            'photos',
            'rservices',
            'object.additionals',
            'object.types',
            'object.infrastructures',
            'object.distance',
            'object.city',
            'object.address'
        ])->paginate(15);
    }

    public function getRoomsForFavourites($id)
    {
        return Room::with([
            'object',
            'photos',
            'rservices',
            'object.additionals',
            'object.types',
            'object.infrastructures',
            'object.distance',
            'object.city',
            'object.address'])->findOrFail($id);
    }

    public function getRoomsCity($city)
    {
        return Room::with([
            'object',
            'photos',
            'rservices',
            'object.additionals',
            'object.types',
            'object.infrastructures',
            'object.distance',
            'object.city',
            'object.address'
        ])->whereHas('object.city', function($q) use ($city){
            $q->where('alias',  $city);
        })->paginate(15);
    }

    public function getRoomsTypes($type) {
        return Room::with([
            'object',
            'photos',
            'rservices',
            'object.additionals',
            'object.types',
            'object.infrastructures',
            'object.distance',
            'object.city',
            'object.address'
        ])->whereHas('object.types', function($q) use ($type){
            $q->where('alias',  $type);
        })->paginate(15);
    }

    public function getRoomsCityAndTypes($city, $type) {
        return Room::with([
            'object',
            'photos',
            'rservices',
            'object.additionals',
            'object.types',
            'object.infrastructures',
            'object.distance',
            'object.city',
            'object.address'
        ])->whereHas('object.city', function($q) use ($city){
            $q->where('alias',  $city);
        })->whereHas('object.types', function($q) use ($type){
            $q->where('alias',  $type);
        })->paginate(15);
        }

        public function getRoomsAdditionals($alias) {
            return Room::with([
                'object',
                'photos',
                'rservices',
                'object.additionals',
                'object.types',
                'object.infrastructures',
                'object.distance',
                'object.city',
                'object.address'
            ])->whereHas('object.additionals', function($q) use ($alias){
                $q->where('alias',  $alias);
            })->paginate(15);
        }

        public function getRoomsAdditionalsCityTypes($city, $type, $alias) {
            return Room::with([
                'object',
                'photos',
                'rservices',
                'object.additionals',
                'object.types',
                'object.infrastructures',
                'object.distance',
                'object.city',
                'object.address'
            ])->whereHas('object.city', function($q) use ($city){
                $q->where('alias',  $city);
            })->whereHas('object.types', function($q) use ($type){
                $q->where('alias',  $type);
            })->whereHas('object.additionals', function($q) use ($alias){
                $q->where('alias',  $alias);
            })->paginate(15);
        }

        public function getRoomsAdditionalsCity($city, $alias) {
            return Room::with([
                'object',
                'photos',
                'rservices',
                'object.additionals',
                'object.types',
                'object.infrastructures',
                'object.distance',
                'object.city',
                'object.address'
            ])->whereHas('object.city', function($q) use ($city){
                $q->where('alias',  $city);
            })->whereHas('object.additionals', function($q) use ($alias){
                $q->where('alias',  $alias);
            })->paginate(15);
        }

    public function getRoomsAdditionalsTypes($type, $alias) {
        return Room::with([
            'object',
            'photos',
            'rservices',
            'object.additionals',
            'object.types',
            'object.infrastructures',
            'object.distance',
            'object.city',
            'object.address'
        ])->whereHas('object.types', function($q) use ($type){
            $q->where('alias',  $type);
        })->whereHas('object.additionals', function($q) use ($alias){
            $q->where('alias',  $alias);
        })->paginate(15);
    }

    public function getRoomsFirstLine() {
        return Room::with([
            'object',
            'photos',
            'rservices',
            'object.additionals',
            'object.types',
            'object.infrastructures',
            'object.distance',
            'object.city',
            'object.address'
        ])->whereHas('object', function($q){
            $q->where('distance_id', '<',  3);
        })->paginate(15);
    }

    public function getRoomsFirstLineTypes($type) {
        return Room::with([
            'object',
            'photos',
            'rservices',
            'object.additionals',
            'object.types',
            'object.infrastructures',
            'object.distance',
            'object.city',
            'object.address'
        ])->whereHas('object', function($q){
            $q->where('distance_id', '<',  3);
        })->whereHas('object.types', function($q) use ($type){
            $q->where('alias',  $type);
        })->paginate(15);
    }

    public function getRoomsFirstLineCity($city) {
        return Room::with([
            'object',
            'photos',
            'rservices',
            'object.additionals',
            'object.types',
            'object.infrastructures',
            'object.distance',
            'object.city',
            'object.address'
        ])->whereHas('object', function($q){
            $q->where('distance_id', '<',  3);
        })->whereHas('object.city', function($q) use ($city){
            $q->where('alias',  $city);
        })->paginate(15);
    }


    public function getRoomsFirstLineCityTypes($city, $type) {
        return Room::with([
            'object',
            'photos',
            'rservices',
            'object.additionals',
            'object.types',
            'object.infrastructures',
            'object.distance',
            'object.city',
            'object.address'
        ])->whereHas('object', function($q){
            $q->where('distance_id', '<',  3);
        })->whereHas('object.city', function($q) use ($city){
            $q->where('alias',  $city);
        })->whereHas('object.types', function($q) use ($type){
            $q->where('alias',  $type);
        })->paginate(15);
    }



    public function getRoomsAllInclusive() {
        return Room::with([
            'object',
            'photos',
            'rservices',
            'object.additionals',
            'object.types',
            'object.infrastructures',
            'object.distance',
            'object.city',
            'object.address'
        ])->whereHas('rservices', function($q){
            $q->where('id', 11);
        })->paginate(15);
    }

    public function getRoomsAllInclusiveTypes($type) {
        return Room::with([
            'object',
            'photos',
            'rservices',
            'object.additionals',
            'object.types',
            'object.infrastructures',
            'object.distance',
            'object.city',
            'object.address'
        ])->whereHas('rservices', function($q){
            $q->where('id', 11);
        })->whereHas('object.types', function($q) use ($type){
            $q->where('alias',  $type);
        })->paginate(15);
    }

    public function getRoomsAllInclusiveCity($city) {
        return Room::with([
            'object',
            'photos',
            'rservices',
            'object.additionals',
            'object.types',
            'object.infrastructures',
            'object.distance',
            'object.city',
            'object.address'
        ])->whereHas('rservices', function($q){
            $q->where('id', 11);
        })->whereHas('object.city', function($q) use ($city){
            $q->where('alias',  $city);
        })->paginate(15);
    }


    public function getRoomsAllInclusiveCityTypes($city, $type) {
        return Room::with([
            'object',
            'photos',
            'rservices',
            'object.additionals',
            'object.types',
            'object.infrastructures',
            'object.distance',
            'object.city',
            'object.address'
        ])->whereHas('rservices', function($q){
            $q->where('id', 11);
        })->whereHas('object.city', function($q) use ($city){
            $q->where('alias',  $city);
        })->whereHas('object.types', function($q) use ($type){
            $q->where('alias',  $type);
        })->paginate(15);
    }


    public function getAllTypes()
    {
        $types = Type::get()->all();
        return $types;
    }


    public function getTypesForMenu() {
        return Type::whereHas('objects')->get();
    }


    public function getSearchResults(string $city)
    {
        return City::with(['rooms.reservations', 'rooms.photos', 'rooms.object.photos', 'rooms.rservices', 'rooms.object.additionals', 'rooms.object.types', 'rooms.object.infrastructures', 'rooms.object.distance', 'rooms.object.city', 'rooms.object.address'])->where('name', $city)->first() ?? false;
    }

    public function getCity($alias)
    {
        return City::with(['rooms.reservations', 'rooms.photos', 'rooms.object.photos', 'rooms.object.address', 'rooms.rservices', 'rooms.object.additionals', 'rooms.object.types', 'rooms.object.infrastructures', 'rooms.object.distance', 'rooms.object.city'])->where('alias', $alias)->first() ?? false;
    }

    public function getRoom($id)
    {
        return Room::with(['object.address', 'price', 'object.city', 'object.comments', 'object.types'])->findOrFail($id);
    }

//НЕ ТРОГАТЬ
    public function getRooms()
    {
        return Room::with(['reservations', 'photos', 'object.address', 'rservices', 'object.additionals', 'object.types', 'object.infrastructures', 'object.distance', 'object.city'])->get();

    }

    public function getReservationsByRoomId($room_id)
    {
        return Reservation::where('room_id', $room_id)->get();
    }

    public function getArticle($id)
    {
        return Article::with(['object.photos', 'comments'])->find($id);
    }

    public function getPerson($id)
    {
        return User::with(['objects', 'larticles', 'comments.commentable'])->find($id);
    }

    public function like($likeable_id, $type, $request)
    {
        $likeable = $type::find($likeable_id);

        return $likeable->users()->attach($request->user()->id);
    }

    public function unlike($likeable_id, $type, $request)
    {
        $likeable = $type::find($likeable_id);

        return $likeable->users()->detach($request->user()->id);
    }

    public function addComment($commentable_id, $type, $request)
    {
        $commentable = $type::find($commentable_id);

        $comment = new Comment;

        $comment->content = $request->input('content');

        $comment->rating = $type == 'App\TouristObject' ? $request->input('rating') : 0;

        $comment->user_id = $request->user()->id;

        $object = TouristObject::with('comments')->where('id', $commentable_id)->first();

        $commentable->comments()->save($comment);

        $arr = [];
        foreach ($object->comments as $comment) {
            $arr[] = $comment->rating;
        }
        $rating = intdiv(array_sum($arr), count($arr));
        $object->rating = $rating;
        $object->save();
    }

    public function makeReservation($room_id, $city_id, $day_in, $day_out, $totalPrice, $comission, $reward, $description, $paid)
    {
        return Reservation::create([
            'user_id' => Auth::user()->id,
            'city_id' => $city_id,
            'room_id' => $room_id,
            'status' => 0,
            'day_in' => date('Y-m-d', strtotime($day_in)),
            'day_out' => date('Y-m-d', strtotime($day_out)),
            'description' => $description,
            'price' => $totalPrice,
            'comission' => $comission,
            'reward' => $reward,
            'paid' => $paid,
        ]);
    }

    public function setPaymentId($reservation, $paymentId)
    {
        $res = new Reservation();
        $reserv = $res->find($reservation->id);
        $reserv->payment_id = $paymentId;
        $reserv->save();
        return $reserv;
    }

    public function getPriceCounter($room_id)
    {
        $room = Room::with('price')->where('id', $room_id);
        return $room;
    }


}


