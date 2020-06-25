<?php

namespace App;


class SendCode
{
    public function sendCode($phone, $code)
    {

        $apiId = '2470A0E7-7BE0-2B9C-2E9E-022F1B6D5E1B';
        $client = new \Zelenin\SmsRu\Api(new \Zelenin\SmsRu\Auth\ApiIdAuth($apiId));
        $msg = 'Ваш код подтверждения: '.$code;
        $sms1 = new \Zelenin\SmsRu\Entity\Sms($phone, $msg);
//        dd($sms1);
        session()->put('code', $code);

        return  $client->smsSend($sms1);
    }

        public function sendSmsAboutReservation($phone, $reservation, $user)
    {
        $apiId = '2470A0E7-7BE0-2B9C-2E9E-022F1B6D5E1B';
        $client = new \Zelenin\SmsRu\Api(new \Zelenin\SmsRu\Auth\ApiIdAuth($apiId));
        $msg = 'krim-leto.ru. Бронь №'.$reservation->id.' Гость: '.$user->name. '. C '. $reservation->day_in . ' по '.$reservation->day_out.' Перейдите по ссылке https://krim-leto.ru/admin и подтвердите бронь.';
        $sms1 = new \Zelenin\SmsRu\Entity\Sms($phone, $msg);

       return $client->smsSend($sms1);
    }

    public static function createObjectNotification($phone)
    {

        $apiId = '2470A0E7-7BE0-2B9C-2E9E-022F1B6D5E1B';
        $client = new \Zelenin\SmsRu\Api(new \Zelenin\SmsRu\Auth\ApiIdAuth($apiId));
        $msg = 'Зарегистрирован новый объект';
        $sms1 = new \Zelenin\SmsRu\Entity\Sms($phone, $msg);
        return  $client->smsSend($sms1);
    }

    public static function sendAdminNotification($phone, $message)
    {

        $apiId = '2470A0E7-7BE0-2B9C-2E9E-022F1B6D5E1B';
        $client = new \Zelenin\SmsRu\Api(new \Zelenin\SmsRu\Auth\ApiIdAuth($apiId));
        $msg = $message;
        $sms1 = new \Zelenin\SmsRu\Entity\Sms($phone, $msg);
        return  $client->smsSend($sms1);
    }

}
