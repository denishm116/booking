<?php


namespace App\Enjoythetrip\Gateways;


use App\Enjoythetrip\Interfaces\FrontendRepositoryInterface;
use App\Room;
use App\Price;
use http\Env\Request;
use Illuminate\Support\Facades\Auth; /*  17 */

use App\User;


class FrontendGateway
{

    use \Illuminate\Foundation\Validation\ValidatesRequests; /* 25 */


    /* Lecture 17 */
    public function __construct(FrontendRepositoryInterface $fR)
    {
        $this->fR = $fR;
    }


    /* Lecture 17 */
    public function searchCities($request)
    {
        $term = $request->input('term');

        $results = array();

        $queries = $this->fR->getSearchCities($term);

        foreach ($queries as $query) {
            $results[] = ['id' => $query->id, 'value' => $query->name];
        }

        return $results;
    }

    public function getCity($alias)
    {
        return $this->fR->getCity($alias);

//        if (count($result->rooms) > 0) {
//            $n = collect([]);
//            foreach ($result->rooms as $room) {
//                $n->push($room);
//            }
//            return $n;  // filtered result
//        }

    }

    /*  18 */
    public function getSearchResults($request)
    {
        setlocale(LC_TIME, 'ru_RU.UTF-8');
        if ($request->input('city') != null) {
            $result = $this->fR->getSearchResults($request->input('city'));
        } else {
            $getRooms = $this->fR->getRooms();
            $result = $this->fR->getSearchResults('Алупка');

            foreach ($getRooms as $k => $room) {
                foreach ($result->rooms as $j => $res) {
                    if ($res->id == $room->id) {
                        $result->rooms->forget($j);
                    }
                }
                $result->rooms->push($room);
            }
        }

        if ($result) {
            $dayin = date('Y-m-d', strtotime($request->input('check_in')));
            $dayout = date('Y-m-d', strtotime($request->input('check_out')));

            foreach ($result->rooms as $k => $room) {
                if ((int)$request->input('room_size') > 0) {
                    if ($room->room_size < $request->input('room_size')) {
                        $result->rooms->forget($k);
                    }
                }
                foreach ($room->reservations as $reservation) {
                    if ($dayin >= $reservation->day_in
                        && $dayin <= $reservation->day_out
                    ) {
                        $result->rooms->forget($k);
                    } elseif ($dayout >= $reservation->day_in
                        && $dayout <= $reservation->day_out
                    ) {
                        $result->rooms->forget($k);
                    } elseif ($dayin <= $reservation->day_in
                        && $dayout >= $reservation->day_out
                    ) {
                        $result->rooms->forget($k);
                    }
                }
            }
            $request->flash(); // inputs for session for one request
            /*19 */
            if (count($result->rooms) > 0) {
                $n = collect([]);
                foreach ($result->rooms as $room) {
                    $n->push($room);
                }
                return $n;  // filtered result
            } else {
                return false;
            }
        }
        return redirect()->back()->with('error', 'Непредвиденная ошибка');
    }

    /* Lecture 25 */
    public function addComment($commentable_id, $type, $request)
    {
        $this->validate($request, [
            'content' => "required|string"
        ]);

        return $this->fR->addComment($commentable_id, $type, $request);
    }

    /* Вычисление стоимости номера из таблицы */

    public function datesPeriod($dateIn, $dateOut)
    {
        $startDate = new \DateTime($dateIn);
        $endDate = new \DateTime($dateOut);
//            $endDate = $endDateRaw->modify('+1 day');
        $dateInterval = new \DateInterval('P1D');

        $period = new \DatePeriod($startDate, $dateInterval, $endDate);
        return $period;

    }


    public function priceCounter(int $room_id, $request)
    {
        setlocale(LC_TIME, 'ru_RU.UTF-8');

        $totalPrice = Room::findOrFail($room_id)->price;

        $period = $this->datesPeriod($request->get('checkin'), $request->get('checkout'));

        if ($request->get('checkin') && $request->get('checkout')) {
            $prices = Price::where('room_id', $room_id)->first();
            $totalPrice = 0;

            foreach ($period as $k => $value) {
                $currDate = new \DateTime($value->format('Y-m-d'));

                //                try {
//                    for ($i = 1; $i <= 12; $i++) {
//                        $periodStartStr = 'period' . $i . 'start';
//                        $periodEndStr = 'period' . $i . 'end';
//                        $periodPriceStr = 'price' . $i;
//
//                        if ($currDate >= new \DateTime($prices->$periodStartStr) && $currDate <= new \DateTime($prices->$periodEndStr)) {
//                            $totalPrice += $prices->$periodPriceStr;
//                        }
//                    }
//                } catch (\Exception $e) {
//                    return redirect()->back()->with('error', 'Что-то пошло не так');
//                }
//dd($totalPrice);

                try {
                    if ($currDate >= new \DateTime($prices->period1start) && $currDate <= new \DateTime($prices->period1end)) {
                        $totalPrice += $prices->price1;
                    } elseif ($currDate >= new \DateTime($prices->period2start) && $currDate <= new \DateTime($prices->period2end)) {
                        $totalPrice += $prices->price2;
                    } elseif ($currDate >= new \DateTime($prices->period3start) && $currDate <= new \DateTime($prices->period3end)) {
                        $totalPrice += $prices->price3;
                    } elseif ($currDate >= new \DateTime($prices->period4start) && $currDate <= new \DateTime($prices->period4end)) {
                        $totalPrice += $prices->price4;
                    } elseif ($currDate >= new \DateTime($prices->period5start) && $currDate <= new \DateTime($prices->period5end)) {
                        $totalPrice += $prices->price5;
                    } elseif ($currDate >= new \DateTime($prices->period6start) && $currDate <= new \DateTime($prices->period6end)) {
                        $totalPrice += $prices->price6;
                    } elseif ($currDate >= new \DateTime($prices->period7start) && $currDate <= new \DateTime($prices->period7end)) {
                        $totalPrice += $prices->price7;
                    } elseif ($currDate >= new \DateTime($prices->period8start) && $currDate <= new \DateTime($prices->period8end)) {
                        $totalPrice += $prices->price8;
                    } elseif ($currDate >= new \DateTime($prices->period9start) && $currDate <= new \DateTime($prices->period9end)) {
                        $totalPrice += $prices->price9;
                    } elseif ($currDate >= new \DateTime($prices->period10start) && $currDate <= new \DateTime($prices->period10end)) {
                        $totalPrice += $prices->price10;
                    } elseif ($currDate >= new \DateTime($prices->period11start) && $currDate <= new \DateTime($prices->period11end)) {
                        $totalPrice += $prices->price11;
                    } elseif ($currDate >= new \DateTime($prices->period12start) && $currDate <= new \DateTime($prices->period12end)) {
                        $totalPrice += $prices->price12;
                    } else {
                        return ['error' => 'Цена у этого номера для выбранной даты не задана владельцем.'];
                    }
                } catch (\Exception $e) {
                  return redirect()->back()->with('error', 'Что-то пошло не так');
                }

            }

            return $totalPrice;

        }

        return $totalPrice;
    }


    /* Lecture 26 */
    public function checkAvaiableReservations($room_id, $request)
    {

        $dayin = date('Y-m-d', strtotime($request->input('checkin')));
        $dayout = date('Y-m-d', strtotime($request->input('checkout')));
        $reservations = $this->fR->getReservationsByRoomId($room_id);
        $avaiable = true;

        foreach ($reservations as $reservation) {
            if ($dayin >= $reservation->day_in
                && $dayin <= $reservation->day_out
            ) {
                $avaiable = false;
                break;
            } elseif ($dayout >= $reservation->day_in
                && $dayout <= $reservation->day_out
            ) {
                $avaiable = false;
                break;
            } elseif ($dayin <= $reservation->day_in
                && $dayout >= $reservation->day_out
            ) {
                $avaiable = false;
                break;
            }
        }
        return $avaiable;
    }

    public function makeReservation($room_id, $city_id, $day_in, $day_out, $totalPrice, $description)
    {
        $user = User::find(Auth::id());

        $paid = 0;
        if ($description == null && $user->hasRole(['owner'])) {
            $description = 'Самостоятельное бронирование ' . $user->fullName;
        } else if ($user->hasRole(['tourist'])) {
            $description = 'Гость: ' . $user->fullName . '. тел. ' . $user->phone;
            $paid = 1;
        } else if ($description == null && $user->hasRole(['admin'])) {
            $description = 'Бронь адмнистрации по согласованию с владельцем объекта';
        }

        $comission = 0.1;

        $reward = $totalPrice * $comission;

        return $this->fR->makeReservation($room_id, $city_id, $day_in, $day_out, $totalPrice, $comission, $reward, $description, $paid);
    }

    //СЕО Сортировка
    public function getAllRooms($city)
    {
        if ($city == 'krim') {
            return $this->fR->getAllRooms();
        } else {
            return $this->fR->getRoomsCity($city);
        }
    }

    public function getRoomsCityAndTypes($city, $type)
    {
        if ($city == 'krim') {
            return $this->fR->getRoomsTypes($type);
        } else {
            return $this->fR->getRoomsCityAndTypes($city, $type);
        }
    }

    public function getTypeListForLeftMenu()
    {
       return $this->fR->getTypesForMenu();
    }

    public function conditionsAll($city = 'krim', $condition)
    {

        $conditions = $this->getRoomConditions();
        $allRooms = '';
        foreach ($conditions as $item) {
            if ($condition == $item[1]) {
                $allRooms = $this->getRoomsAdditionalsCity($city, $condition);
            }
        }
        if ($condition == 'otdih-u-moria') {
            $allRooms = $this->getRoomsFirstLineCity($city);
        }

        if ($condition == 'all-inclusive') {
            $allRooms = $this->getRoomsAllInclusiveCity($city);
        }
        return $allRooms;
    }


    public function getRoomConditions($city = null, $type = null)
    {
        $roomsWithChildrien = $this->fR->getRoomsAdditionals('dlya-otdyha-s-detmi')->total();
        $roomsWithEating = $this->fR->getRoomsAdditionals('s-pitaniem')->total();
        $roomsWithPool = $this->fR->getRoomsAdditionals('s-basseynom')->total();
        $roomsFirstLine = $this->fR->getRoomsFirstLine()->total();
        $roomsAllInclusive = $this->fR->getRoomsAllInclusive()->total();

        if ($city && !$type && $city != 'krim')
        {
            $roomsWithChildrien = $this->fR->getRoomsAdditionalsCity($city, 'dlya-otdyha-s-detmi')->total();
            $roomsWithEating = $this->fR->getRoomsAdditionalsCity($city,'s-pitaniem')->total();
            $roomsWithPool = $this->fR->getRoomsAdditionalsCity($city,'s-basseynom')->total();
            $roomsFirstLine = $this->fR->getRoomsFirstLineCity($city)->total();
            $roomsAllInclusive = $this->fR->getRoomsAllInclusiveCity($city)->total();
        }

        if ($type && $city == 'krim')
        {
            $roomsWithChildrien = $this->fR->getRoomsAdditionalsTypes($type, 'dlya-otdyha-s-detmi')->total();
            $roomsWithEating = $this->fR->getRoomsAdditionalsTypes($type,'s-pitaniem')->total();
            $roomsWithPool = $this->fR->getRoomsAdditionalsTypes($type,'s-basseynom')->total();
            $roomsFirstLine = $this->fR->getRoomsFirstLineTypes($type)->total();
            $roomsAllInclusive = $this->fR->getRoomsAllInclusiveTypes($type)->total();
        }


        if ($type && $city != 'krim')
        {
            $roomsWithChildrien = $this->fR->getRoomsAdditionalsCityTypes($city, $type, 'dlya-otdyha-s-detmi')->total();
            $roomsWithEating = $this->fR->getRoomsAdditionalsCityTypes($city, $type,'s-pitaniem')->total();
            $roomsWithPool = $this->fR->getRoomsAdditionalsCityTypes($city, $type,'s-basseynom')->total();
            $roomsFirstLine = $this->fR->getRoomsFirstLineCityTypes($city, $type)->total();
            $roomsAllInclusive = $this->fR->getRoomsAllInclusiveCityTypes($city, $type)->total();
        }

        $conditions = [];
        if ($roomsWithChildrien) {
            $conditions[] = [$roomsWithChildrien, 'dlya-otdyha-s-detmi', 'для отдыха с детьми'];
        }
        if ($roomsFirstLine) {
            $conditions[] = [$roomsFirstLine, 'otdih-u-moria', 'у моря (первая линия)'];
        }
        if ($roomsWithEating) {
            $conditions[] = [$roomsWithEating, 's-pitaniem', 'с питанием'];
        }
        if ($roomsAllInclusive) {
            $conditions[] = [$roomsAllInclusive, 'all-inclusive', 'все включено'];
        }
        if ($roomsWithPool) {
            $conditions[] = [$roomsWithPool, 's-basseynom', 'с бассейном'];
        }

        return $conditions;
    }

public function getRoomsAdditionalsCityTypes($city, $type, $condition) {
        if ($city == 'krim') {
            return $this->fR->getRoomsAdditionalsTypes($type, $condition);
        } else {
            return $this->fR->getRoomsAdditionalsCityTypes($city, $type, $condition);
        }
}

public function getRoomsAllInclusiveCityTypes($city, $type) {
        if ($city == 'krim') {
            return $this->fR->getRoomsAllInclusiveTypes($type);
        } else {
            return $this->fR->getRoomsAllInclusiveCityTypes($city, $type);
        }
}

public function getRoomsFirstLineCityTypes($city, $type) {
        if ($city == 'krim') {
            return $this->fR->getRoomsFirstLineTypes($type);
        } else {
            return $this->fR->getRoomsFirstLineCityTypes($city, $type);
        }
}

    public function getRoomsAdditionalsCity($city, $condition) {
        if ($city == 'krim') {
            return $this->fR->getRoomsAdditionals($condition);
        } else {
            return $this->fR->getRoomsAdditionalsCity($city, $condition);
        }
    }

    public function getRoomsFirstLineCity($city) {
        if ($city == 'krim') {
            return $this->fR->getRoomsFirstLine();
        } else {
            return $this->fR->getRoomsFirstLineCity($city);
        }
    }

    public function getRoomsAllInclusiveCity($city) {
        if ($city == 'krim') {
            return $this->fR->getRoomsAllInclusive();
        } else {
            return $this->fR->getRoomsFirstLineCity($city);
        }
    }

    public function getCityByAlias($alias)
    {
        if ($alias == 'krim') {
            return 'Крым';
        } else {
            return $this->fR->getCityByAlias($alias)->name ?? false;
        }

    }

    public function reasons()
    {
        return $reasonsArray = [
            '3d_secure_failed' => 'Не пройдена аутентификация по 3-D Secure. Пользователю следует повторить платеж, обратиться в банк за уточнениями или использовать другое платежное средство',
            'call_issuer' => 'Оплата данным платежным средством отклонена по неизвестным причинам. Пользователю следует обратиться в организацию, выпустившую платежное средство',
            'card_expired' => 'Истек срок действия банковской карты. Пользователю следует использовать другое платежное средство',
            'country_forbidden' => 'Нельзя заплатить банковской картой, выпущенной в этой стране. Пользователю следует использовать другое платежное средство.',

            'fraud_suspected' => 'Платеж заблокирован из-за подозрения в мошенничестве. Пользователю следует использовать другое платежное средство',
            'general_decline' => 'Причина не детализирована. Пользователю следует обратиться к инициатору отмены платежа за уточнением подробностей',
            'identification_required' => 'Превышены ограничения на платежи для кошелька в Яндекс.Деньгах. Пользователю следует идентифицировать кошелек или выбрать другое платежное средство',
            'insufficient_funds' => 'Не хватает денег для оплаты. Пользователю следует пополнить баланс или использовать другое платежное средство',
            'invalid_card_number' => 'Неправильно указан номер карты. Пользователю следует повторить платеж и ввести корректные данные',
            'invalid_csc' => 'Неправильно указан код CVV2 (CVC2, CID). Пользователю следует повторить платеж и ввести корректные данные',
            'issuer_unavailable' => 'Организация, выпустившая платежное средство, недоступна. Пользователю следует повторить платеж позже или использовать другое платежное средство',
            'payment_method_limit_exceeded' => 'Исчерпан лимит платежей для данного платежного средства или вашего магазина. Пользователю следует повторить платеж на следующий день или использовать другое платежное средство',
            'payment_method_restricted' => 'Запрещены операции данным платежным средством (например, карта заблокирована из-за утери, кошелек — из-за взлома мошенниками). Пользователю следует обратиться в организацию, выпустившую платежное средство',
            'permission_revoked' => 'Нельзя провести безакцептное списание: пользователь отозвал разрешение на автоплатежи. Если пользователь еще хочет оплатить, вам необходимо создать новый платеж, а пользователю — подтвердить оплату.',
        ];
    }

    public function seoCityArray()
    {
        return $seoCity = [
            'alupka' => 'Алупке',
            'andreevka' => 'Андреевке',
            'balaklava' => 'Балаклаве',
            'koktebel' => 'Коктебеле',
            'evpatoria' => 'Евпатории',
            'ordzhonikidze' => 'Орджоникидзе',
            'saki' => 'Саки',
            'sevastopol' => 'Севастополе',
            'feodosia' => 'Феодосии',
            'sudak' => 'Судаке',
            'yalta' => 'Ялте',
            'mishor' => 'Мисхоре',
            'alushta' => 'Алуште',
            'beregovoe' => 'Береговом',
            'gaspra' => 'Гаспре',
            'gurzuf' => 'Гурзуфе',
            'kerch' => 'Керчи',
            'mezhvodnoe' => 'Межводном',
            'nikolaevka' => 'Николаевке',
            'novofedorovka' => 'Новофедоровке',
            'novyy-svet' => 'Новом Свете',
            'olenevka' => 'Оленевке',
            'otradnoe' => 'Отрадном',
            'partenit' => 'Партените',
            'peschanoe' => 'Песчаном',
            'simeiz' => 'Симеизе',
            'simferopol' => 'Симферополе',
            'foros' => 'Форосе',
            'chernomorskoe' => 'Черноморском',
            'shtormovoe' => 'Штормовом',
            'shchelkino' => 'Щелкино',
            'solnechnogorskoe' => 'Солнечногорском',
            'utes' => 'Утёсе',
            'popovka' => 'Поповке',
            'krim' => 'Крыму 2020',
            'bahchisaray' => 'Бахчисарае',
            'veseloe' => 'Веселом',
            'golubickaya' => 'Голубицкой',
            'zaozernoe' => 'Заозерном',
            'zolotoe' => 'Золотом',
            'kamenskoe' => 'Каменском',
            'kanaka' => 'Канаке',
            'kastropol' => 'Кастрополе',
            'kacha' => 'Каче',
            'koreiz' => 'Кореизе',
            'kurortnoe' => 'Курортном',
            'lazurnoe' => 'Лазурном',
            'laspi' => 'Ласпи',
            'livadiya' => 'Ливадии',
            'lyubimovka' => 'Любимовке',
            'malorechenskoe' => 'Малореченском',
            'mirnyy' => 'Мирном',
            'mnogoreche' => 'Многоречье',
            'molochnoe' => 'Молочном',
            'morskoe' => 'Морском',
            'mysovoe' => 'Мысовом',
            'okunevka' => 'Окуневке',
            'orlovka' => 'Орловке',
            'pribrezhnoe' => 'Прибрежном',
            'privetnoe' => 'Приветном',
            'primorskoe' => 'Приморском',
            'rybache' => 'Рыбачьем',
            'sokolinoe' => 'Соколином',
            'tarhankut' => 'Тарханкуте',
            'uglovoe' => 'Угловом',
            'uchkuevka' => 'Учкуевке',
            'fiolent' => 'Фиоленте',
            'roomsearch' => 'Поиск',
            'favourites' => 'Избранное',
        ];
    }


}


