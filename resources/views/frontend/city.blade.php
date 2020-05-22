@extends('layouts.layout')

@section('title', 'Отдых  в ' . $h1seo . ' 2020.  Жильё у моря. Цены на без посредников.')

@section('description', 'Отдых в ' . $h1seo  . ' в 2020 г. Гостиницы и частный сектор, гостевые дома с отзывами! Фотографии, описание, бронирование жилья. Без посредников!')

@section('canonical', 'canonical')
@section('canonical-address', 'https://krim-leto.ru/'.$city)

@section('content')
    <header>
        <div class="pt-4 pb-4 header-background img-fluid header-catalog" id="background">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-12 col-12 pt-xl-4 pb-xl-2 pb-1">
                        <h1 class="header__title">Отдых в {{ $h1seo }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="breadcrumb-holder my-1">
            <ul class="basic-breadcrumbs">
                <li class="d-none d-lg-block"><a href="{{route('home')}}">Главная</a></li>
                <li class="d-none d-lg-block"><a href="#">{{$krim}}</a></li>
            </ul>
        </div>
        <div class="container ">
            <div class="row shadow-orange p-3 mb-5">

                <div class="col-lg-3">
                    <div class="row justify-content-center mb-3">
                        <div class="col m-0 p-0 seo-search-left-col ">

                            <div class="p-3 mb-3 bg-white border-orange">

                                <h2 class="text-center">Где остановиться в {{$h1seo}}</h2>

                                @foreach($leftMenu1 as $type )
                                    <div class="{{($requestSegment == $type->alias) ? 'bg-orange p-1' : ''}}">

                                        <a href="{{ route('type',['city'=>$city ?? false, 'type'=>$type->alias ?? false] ) }}"> {{$type->title ?? ''}} </a>

                                    </div>
                                    <div class="line-grey"></div>
                                @endforeach

                            </div>

                            <div class="p-3 border-orange">
                                <h2 class="text-center">Жилье в {{$h1seo}}</h2>
                                {{--<div class="line-grey"></div>--}}
                                @foreach($conditionsAll as $condition )

                                    <div>
                                        <a href="{{ route('cityConditions',['alias'=>$city ?? false, 'condition' => $condition[1]] ) }}"> {{$condition[2]}}
                                            ({{$condition[0]}})</a>
                                    </div>

                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-9">
                    @include('layouts.seosearchrightbar')
                </div>

            </div>
        </div>

    </div>

@endsection


