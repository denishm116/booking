@extends('layouts.layout')

@section('title', 'Отдых и жильё в Крыму - 2020 г. ')

@section('description', 'Отдых и жильё в Крыму - 2020 г. Бронировние жилья без по средников. Цена от собственника. Без комиссии')
@section('content')

<div class="container">
    {{--<h1>Ожидание оплаты</h1>--}}

    <div class="col-lg-12 col-12 m-3">
        <h1 class="about__title">Ошибка платежа</h1>
        <div class="col-xl-4 line"></div>

    </div>
    <div class="row justify-content-center block">
        <div class="col-md-10 shadow-lg p-3 center-block">
            <h3 class="text-center">Что то пошло не так.</h3>
            <br>
            <p><b>Инициатор ошибки:</b> {{ $iniciator }} (Сторона плательщика)</p>
            <p><b>Причина ошибки:</b> {{$reason}}</p>
            <br>
            <br>
            <p class="text-center"><a href="{{route('home')}}"><b> Вернуться на главную страницу.</b></a> </p>
            <br>
            <p>Если у Вас возникли вопросы, можете задать их по телефону +7(978)585 22 87 или любым другим, удобным
                для Вас способом.</p>
            <p class="text-right"><i>С уважением, администрация сервиса krim-leto.ru</i></p>

        </div>
    </div>

</div>

{{--@push('scripts')--}}
{{--<script>--}}
    {{--let redirectInterval = 15;--}}
    {{--function redirect() {--}}
        {{--setTimeout(function () {--}}
            {{--document.querySelector('.seconds').textContent = redirectInterval;--}}
            {{--redirectInterval--;--}}
            {{--if (redirectInterval > 0) {--}}
                {{--if (redirectInterval == 1) {--}}
                    {{--window.location = "http://krim-leto.ru/admin";--}}
                {{--}--}}

                {{--redirect();--}}
            {{--}--}}
        {{--}, 1000)--}}
    {{--}--}}
    {{--redirect();--}}
{{--</script>--}}
{{--@endpush--}}

@endsection



