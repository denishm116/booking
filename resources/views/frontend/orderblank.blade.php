@extends('layouts.layout')
@section('title', 'Отдых и жильё в Крыму - 2020 г. ')

@section('description', 'Отдых и жильё в Крыму - 2020 г. Аренда жилья без по средников. Цена от собственника. Без комиссии')
@section('content')

    <div class="app">
    <div class="container">
        <div class="col-lg-12 col-12 m-3">
            <h1 class="about__title">Подтверждение бронирования</h1>
            <div class="col-xl-4 line"></div>
        </div>
        <div class="shadow-lg p-3 mx-3 mt-5 mb-5">
            <h2 class="text-center"> Уважаемый {!! Auth::user()->fullName !!}!</h2>
            <p>В электронном письме, которое придет к Вам на e-mail, будет содержаться билет, подтверждающий вашу бронь.
                Можно его распечатать или предоставить в электронном виде (например с экрана смартфона).</p>
            <p>Напоминаем Вам, что для завершения бронирования, вам нужно внести предоплату, в размере 15% от стоимости
                бронирования. Оставшуюся часть суммы Вы оплатите непосредственно при заселении удобным для вас
                способом.</p>
            <p>После оплаты, бронирование будет зарегистрировано в базе портала krim-leto.ru. Вы получите уведомление и
                e-mail с полным адресом и телефоном владельца бронируемого объекта. Дабы избежать небрежности со стороны
                арендодателей, наши менеджеры свяжутся лично с администрацией бронируемого объекта чтобы исключить
                ошибку.</p>

            <p>Проверьте, пожалуйста, данные и сроки бронирования:</p>
            <div class="row">
               <div class="col bg-light-dark"> ФИО: <h6>{!! $user->fullPayName !!}</h6></div>
                <div class="col bg-light-dark">E-mail: <h6>{!! $user->userEmail !!}</h6></div>
                <div class="col bg-light-dark">Номер телефона:<h6>{!! $user->userPhone !!}</h6></div>
            </div>
            <div class="row">
                <div class="col"><h6>Даты</h6></div>
                <div class="col">Дата заезда:<h6>{{date(strftime('%d-%b-%Y', strtotime($day_in)))}}</h6></div>
                <div class="col">Дата выезда:<h6>{{date(strftime('%d-%b-%Y', strtotime($day_out)))}}</h6></div>

            </div>
            <div class="row">

                <div class="col bg-light-dark"> Полная стоимость бронирования: <h6>{{$totalPrice}} &#8381; </h6></div>
                <div class="col bg-light-dark"> Предоплата: <h6>{{$totalPrice*0.1}} &#8381; </h6></div>
                <div class="col bg-light-dark"> Остаток : <h6>{{($totalPrice - ($totalPrice*0.1))}} &#8381; </h6></div>
            </div>
            <div id="payment-form" class="mt-3"></div>

        </div>


    </div>

    </div>



    <script>
        //Инициализация виджета. Все параметры обязательные.

        const checkout = new window.YandexCheckout({
            confirmation_token: '{{$token}}', //Токен, который перед проведением оплаты нужно получить от Яндекс.Кассы
            return_url: 'https://krim-leto.ru/ownerdata', //Ссылка на страницу завершения оплаты
            // return_url: 'http://booking/ownerdata', //Ссылка на страницу завершения оплаты
            error_callback(error) {
                       function f() {
                           alert(error)
                       }
                //Обработка ошибок инициализации
            }
        });

        //Отображение платежной форме в заданном элементе
        checkout.render('payment-form');
    </script>
@endsection





{{--Описание бронирования: <h6>{!! $reservation->description !!}</h6>--}}
{{--Вы забронировали объект: {{$object->name}}, в г. {{$city}}, по ул. {{$addres->street}}, д. {{$addres->number}}. <p>Владелец</p> {!! $owner->fullPayName !!}, тел. {{$owner->phone}}, e-mail: {{$owner->email}}--}}

{{--<div class="mt-3 text-center"> <style>.tinkoffPayRow {--}}
{{--display: block;--}}
{{--margin: 1%;--}}
{{--width: 160px;--}}
{{--}</style>--}}
{{--<script src="https://securepay.tinkoff.ru/html/payForm/js/tinkoff_v2.js"></script>--}}
{{--<form name="TinkoffPayForm" onsubmit="pay(this); return false;">--}}
{{--<input class="tinkoffPayRow" type="hidden" name="terminalkey" value="1573223869632DEMO">--}}
{{--<input class="tinkoffPayRow" type="hidden" name="frame" value="true">--}}
{{--<input class="tinkoffPayRow" type="hidden" name="language" value="ru">--}}
{{--<input class="tinkoffPayRow" type="hidden" placeholder="Сумма заказа" name="amount" required--}}
{{--value="{{$reservation->reward}}">--}}
{{--<input class="tinkoffPayRow" type="hidden" placeholder="Номер заказа" name="order"--}}
{{--value="{{$reservation->id}}">--}}
{{--<input class="tinkoffPayRow" type="hidden" placeholder="Описание заказа" name="description"--}}
{{--value="{!! $reservation->description !!}">--}}
{{--<input class="tinkoffPayRow" type="hidden" placeholder="ФИО плательщика" name="name"--}}
{{--value="{!! Auth::user()->fullPayName !!}">--}}
{{--<input class="tinkoffPayRow" type="hidden" placeholder="E-mail" name="email"--}}
{{--value="{!! Auth::user()->userEmail !!}">--}}
{{--<input class="tinkoffPayRow" type="hidden" placeholder="Контактный телефон" name="phone"--}}
{{--value="{!! Auth::user()->userPhone !!}">--}}
{{--<input class="tinkoffPayRow choice__button" type="submit" value="Оплатить {{$reservation->reward}} &#8381; ">--}}
{{--</form>--}}
{{--</div>--}}
