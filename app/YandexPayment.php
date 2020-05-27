<?php

namespace App;

use YandexCheckout\Client;
use YandexCheckout\Model\Payment;
use Illuminate\Database\Eloquent\Model;


class YandexPayment extends Model
{
//
    public $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setAuth('660524', 'test_e164o1DdZrSsqwWQKM17JrnrEugHT3wmLJK5rX5YjKo');
//        $this->client->setAuth('658739', 'live_5BDTDGlepFRV9fOivXSanPjK5Pf8kXVqte0td_3BDjI');
    }

    public function getToken($reward, $room_id, $day_in, $day_out)
    {
        $payment = $this->client->createPayment(
            array(
                'amount' => array(
                    'value' => $reward,
                    'currency' => 'RUB',
                ),
                'confirmation' => array(
                    'type' => 'embedded',
                ),
                'capture' => false,
                'description' => 'Бронирование номера ' . $room_id . ' c ' . $day_in . ' по ' . $day_out,
            ),
            uniqid('', true)
        );

        $pay = $payment;
        return $pay;
    }

    public function getPaymentId($session)
    {
    return $this->client->getPaymentInfo($session);
    }

    public function confirmPayment($paymentId) {


        $payment = $this->client->getPaymentInfo($paymentId);
        $this->client->capturePayment(
            array(
                'amount' => $payment->amount,
            ),
            $payment->id,
            uniqid('', true)
        );

    }
}
