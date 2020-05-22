@extends('layouts.layout')

@section('title', 'Отдых и жильё в Крыму - 2020 г. ')

@section('description', 'Отдых и жильё в Крыму - 2020 г. Бронировние жилья без по средников. Цена от собственника. Без комиссии')
@section('content')

    <div class="container">
        {{--<h1>Ожидание оплаты</h1>--}}

        <div class="col-lg-12 col-12 m-3">
            <h1 class="about__title">Ваша бронь зарегистрирована</h1>
            <div class="col-xl-4 line"></div>

        </div>
        <div class="row justify-content-center block">
            <div class="col-md-10 shadow-lg p-3 center-block">
                <h3 class="text-center">Уважаемый {{ $user->name }}!</h3>
                <br>
                <p>Через <span class="seconds">15</span> сек Вы будете перенаправлены к Вашему календарю бронирований. В
                    течении нескольких минут наши менеджеры проверят броинрование и Вам на e-mail, указанный при
                    регистрации придет билет, в котором будут указаны все данные по бронированию!</p>
                <p> Также все данные по бронированию будут доступны на странице календаря бронирований.</p>
                {{--Вас ожидают с <h6>{{strftime('%d-%b-%Y', strtotime($day_in))}}</h6> по <h6>{{strftime('%d-%b-%Y', strtotime($day_out))}}</h6> адресу:<h6> {{$object->name}}, в г. {{$city->name}}, по ул. {{$addres->street}}, д. {{$addres->number}}.</h6>--}}
                {{--Вас встретит:<h6> {{$owner->name}}.</h6>--}}
                {{--Телефон:<h6> {{$owner->phone}}</h6>--}}
                {{--e-mail:<h6> {{$owner->email}}</h6>--}}
                {{--<p>На ваш e-mail <b>{{ $user->email }}</b> отправлен билет, подтверждающий бронирование и чек об оплате. </p>--}}
                <p>Если у Вас возникли вопросы, можете задать их по телефону +7(978)585 22 87 или любым другим, удобным
                    для Вас способом.</p>
                <p class="text-right"><i>С уважением, администрация сервиса krim-leto.ru</i></p>
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            let redirectInterval = 15;
            function redirect() {
                setTimeout(function () {
                    document.querySelector('.seconds').textContent = redirectInterval;
                    redirectInterval--;
                    if (redirectInterval > 0) {
                        if (redirectInterval == 1) {
                            window.location = "http://krim-leto.ru/admin";
                        }

                    redirect();
                    }
                }, 1000)
            }
            redirect();
        </script>
    @endpush

@endsection



