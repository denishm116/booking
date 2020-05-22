<?php

namespace App\Enjoythetrip\Gateways;
/* Lecture 27 */

use App\Enjoythetrip\Interfaces\BackendRepositoryInterface; /* Lecture 27 */


/* Lecture 27 */

class BackendGateway
{


    use \Illuminate\Foundation\Validation\ValidatesRequests; /* Lecture 37 */


    public function __construct(BackendRepositoryInterface $bR)
    {
        $this->bR = $bR;
    }


    public function getReservations($request)
    {
        if ($request->user()->hasRole(['owner'])) {
            $objects = $this->bR->getOwnerReservations($request);
//            dd($objects);

        } elseif ($request->user()->hasRole(['admin'])) {
            $objects = $this->bR->getAllReservations($request);
        } else {
            $objects = $this->bR->getTouristReservations($request);
        }

        return $objects;
    }


    /* Lecture 37 */
    public function createCity($request)
    {
        $this->validate($request, [
            'name' => "required|string|unique:cities",
        ]);

        $this->bR->createCity($request);
    }


    /* Lecture 37 */
    public function updateCity($request, $id)
    {
        $this->validate($request, [
            'name' => "required|string|unique:cities",
        ]);

        $this->bR->updateCity($request, $id);
    }


    /* Lecture 39 */
    public function saveUser($request)
    {
        $this->validate($request, [
            'name' => "required|string",
            'surname' => "required|string",
            'email' => "required|email",
        ]);

        if ($request->hasFile('userPicture')) {
            $this->validate($request, [
                'userPicture' => "image|max:100",

            ]);
        }

        return $this->bR->saveUser($request);
    }


    /* Lecture 42 */
    public function saveObject($id, $request)
    {
        $this->validate($request, [
            'user_id' => "string",
            'city' => "required|string",
            'name' => "required|string",
            'street' => "required|string",
            'number' => "required",
            'description' => "required|string|min:100",
        ]);


        if ($id) {
//            dd($request->input());
            $object = $this->bR->updateObjectWithAddress($id, $request);
        } else {
            $object = $this->bR->createNewObjectWithAddress($request);
        }


        if ($request->hasFile('objectPictures')) {

            $this->validate($request, \App\Photo::imageRules($request, 'objectPictures')); /* Lecture 43 */

            /* Lecture 43 */
//            dd($request->file('objectPictures')->photos);

            foreach ($request->file('objectPictures') as $picture) {

                $path = $picture->store('objects', 'public');

                $this->bR->saveObjectPhotos($object, $path);
            }

        }

        return $object;
    }


    /* Lecture 45 */
    public function saveArticle($object_id, $request)
    {
        $this->validate($request, [
            'content' => "required|min:10",
            'title' => "required|min:3",
        ]);

        return $this->bR->saveArticle($object_id, $request);

    }


    /* Lecture 47 */
    public function saveRoom($id, $request)
    {

        $this->validate($request, [
            'room_number' => "required|integer",
            'room_size' => "required|integer",
            'price' => "required|integer",
            'description' => "required|string|min:100",
        ]);

        if ($id) {

            $room = $this->bR->updateRoom($id, $request); /* Lecture 48 */

        } else {
            $room = $this->bR->createNewRoom($request); /* Lecture 48 */
        }


        if ($request->hasFile('roomPictures')) {
            $this->validate($request, \App\Photo::imageRules($request, 'roomPictures'));

            foreach ($request->file('roomPictures') as $picture) {
//                dd($picture->store('rooms', 'public'));
                $path = $picture->store('rooms', 'public');

                $this->bR->saveRoomPhotos($room, $path); /* Lecture 48 */
            }

        }

        return $room; /* Lecture 48 */

    }


    /* Lecture 51 */
    public function checkNotificationsStatus($request)
    {

        set_time_limit(0);

        $memcache = new \App\Enjoythetrip\Services\FakedMemcached();

        $memcache->addServer('localhost', 11211) or die("Could not connect");

        $currentmodif = (int)$memcache->get('userid_' . $request->user()->id . '_notification_timestamp');

        $lastmodif = $request->input('timestamp') ?? 0;

        $start = microtime(true);

        $response = array();


        while ($currentmodif <= $lastmodif) {

            if ((microtime(true) - $start) > 10) /* Lecture 52 >10 */ {
                return json_encode($response);
            }


            sleep(0.1);
            $currentmodif = (int)$memcache->get('userid_' . $request->user()->id . '_notification_timestamp');
        }


        return $currentmodif;
    }

    public function getAllObjects()
    {
        $objects = $this->bR->getAllObjects();
        return $objects;
    }
}


