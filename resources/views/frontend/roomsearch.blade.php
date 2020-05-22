@extends('layouts.layout')

@section('title', 'Отдых  в ' . $h1seo . ' 2020. Цены на жильё у моря, без посредников, отзывы, фотографии.')

@section('description', 'Отдых в ' . $h1seo  . ' в 2020 г. Гостиницы и частный сектор, гостевые дома с отзывами! Фотографии, описание, бронирование жилья. Без посредников!')
@section('content')
    @include('layouts.searchheader')


    @if (!$city)
        <div class="container p-0 text-center mb-5 pb-5">
            <h3 class="mb-5"> Извините, на данный момент нет открытых дат в {{$h1seo}} ;-(<br><br>Попробуйте выбрать
                другой курорт. Открывайте для себя новые места!</h3>
        </div>
    @else
        <div class="container">
            <h3 class="about__title">
                Доступные предложения в {{$h1seo}}  </h3>
            @if(isset($reservationPrice[0]['checkin']))
                <h4 class="my-3"> с <i>{{strftime('%d %b %Y', strtotime($reservationPrice[0]['checkin']))}}</i> оп
                    <i>{{strftime('%d %b %Y', strtotime($reservationPrice[0]['checkout']))}}</i></h4>
            @endif
            <div class="col-xl-4 line mb-5"></div>
        </div>


        <div class="container">
            <filters :allrooms="{{json_encode($city)}}"
                     :reservprice="{{json_encode($reservationPrice) ?? false}}"></filters>
        </div>

    @endif
@endsection


