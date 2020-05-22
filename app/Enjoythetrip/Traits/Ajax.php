<?php

namespace App\Enjoythetrip\Traits; /* Lecture 30 */

use Illuminate\Http\Request; /* Lecture 30 */

/* Lecture 30 */
trait Ajax {


    public function ajaxGetReservationData(Request $request)
    {
        setlocale(LC_TIME, 'ru_RU.UTF-8');
        $reservation = $this->bR->getReservationData($request);

        return response()->json([
            'room_number' => $reservation->room->id,
            'reservationNumber' => $reservation->id,
            'day_in' => strftime('%d-%b-%Y', strtotime($reservation->day_in)),
            'day_out' => strftime('%d-%b-%Y', strtotime($reservation->day_out)),
            'FullName' => $reservation->user->FullName,
            'userLink' => route('person', ['id' => $reservation->user->id]),
            'confirmResLink' => route('confirmReservation', ['id' => $reservation->id]),
            'deleteResLink' => route('deleteReservation', ['id' => $reservation->id]), 
            'status' => $reservation->status,
            'description' => $reservation->description,
            'price' => $reservation->price,
            'comission' => $reservation->comission,
            'reward' => $reservation->reward,
        ]);
    }


    /* Lecture 50 */
    public function ajaxSetReadNotification(Request $request)
    {
        return  $this->bR->setReadNotifications($request);
    }


    /* Lecture 51 */
    public function ajaxGetNotShownNotifications(Request $request)
    {

        $currentmodif = $this->bG->checkNotificationsStatus($request);

        // executed if while loop ends
        $response['notifications'] = $this->bR->getUserNotifications($request->user()->id); /* Lecture 52 */
        $response['timestamp'] = $currentmodif;

        return json_encode($response);
    }

    /* Lecture 52 */
    public function ajaxSetShownNotifications(Request $request)
    {
        return $this->bR->setShownNotifications($request);
    }


}

