@extends('layouts.layout')

@section('title', 'Жилье  в ' . $h1seo . ' '. $seoType.' 2020. Цены на жильё у моря, без посредников, отзывы, фотографии.')

@section('description', 'Жилье  в ' . $h1seo . ' '. $seoType. ' в 2020 г.  Цены на бронирование жильё у моря, без посредников, отзывы, фотографии.')

@section('canonical', 'canonical')
@section('canonical-address', 'https://krim-leto.ru/'. $city . '/'. $requestSegment)

@section('content')
    <header>
        <div class="pt-4 pb-4 header-background img-fluid header-catalog" id="background">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-12 col-12 pt-xl-4 pb-xl-2 pb-1">
                        <h1 class="header__title">Жилье в {{ $h1seo }} {{$seoType}}</h1>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="breadcrumb-holder my-1">
            <ul class="basic-breadcrumbs">
                <li class="d-none d-lg-block"><a href="{{route('home')}}">Главная</a></li>
                <li class="d-none d-lg-block"><a href="{{route('city', ['city'=>$city])}}">{{$krim}}</a></li>
                <li class="d-none d-lg-block"><a href="#">{{$seoType}}</a></li>
            </ul>
        </div>

        <div class="container ">
            <div class="row shadow-orange p-3 mb-5">


                <div class="col-lg-3">
                    <div class="row justify-content-center mb-3">
                        <div class="col m-0 p-0">
                            <div class="p-3 mb-3 bg-white border-orange seo-search-left-col">

                                <h2 class="text-center">Где остановиться в {{$h1seo}}</h2>

                    @foreach($typesAlias as $type )
                        <div     class="{{($requestSegment == $type->alias) ? 'bg-orange p-1' : ''}}"       >

                            <h2 class="filter-type ">
                                <a href="{{ route('type',['alias' => $city, 'type'=>$type->alias] ) }}"> {{$type->title}} </a><br>


                            </h2>

                        </div>



                        <div class="line-grey"></div>
                    @endforeach

                    @foreach($conditionsTypes as $condition )

                        <div class="{{($requestSegment == $condition[1]) ? 'seo-search-left-bg' : ''}} filter-type-small">
                            <h3 class="filter-type">
                                <a href="{{ route('cityConditions',['alias'=>$city ?? false, 'condition' => $condition[1] ?? false] ) }}"> {{$condition[2]}} ({{$condition[0]}})</a>
                            </h3>

                        </div>

                    @endforeach

                            </div>
                        </div>
                </div>

            </div>
            <div class="col-lg-9 align-content-center">
            @include('layouts.seosearchrightbar')
            </div>

            </div>
        </div>
    </div>

@endsection


