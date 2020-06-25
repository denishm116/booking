@extends('layouts.layout')

@section('title', $seoType->title.'  в ' . $h1seo . '. Бронирование и цены.')

@section('description', $seoType->title.' в ' . $h1seo  . '. Цены 2020 г. Бронирование жилья в Крыму без посредников!')

@section('canonical', 'canonical')
@section('canonical-address', 'https://krim-leto.ru/'.$city.'/'.$seoType->alias)

@section('content')
    <header>
        <div class="pt-4 pb-4 header-background img-fluid header-catalog" id="background">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-12 col-12 pt-xl-4 pb-xl-2 pb-1">
                        <h1 class="header__title">{{$seoType->title}} в {{ $h1seo }}</h1>
                    </div>
                </div>
            </div>
        </div>





    </header>



    <div class="container">

                <div class="breadcrumb-holder my-1">
                    <ul class="basic-breadcrumbs">
                        <li class="d-none d-lg-block"><a href="{{route('home')}}">Главная</a></li>
                        <li class="d-none d-lg-block"><a
                                href="{{route('city', ['city'=>$city])}}">{{$krim}}</a>
                        </li>
                        <li class="d-none d-lg-block"><a href="#">{{$seoType->title}}</a></li>
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
                                    <div class="{{($requestSegment == $type->alias) ? 'seo-search-left-bg' : ''}}">
                                        <a href="{{ route('cityConditions',['city' => $city, 'type'=>$type->alias] ) }}"> {{$type->title}} </a><br>
                                    </div>
                                    <div class="{{($requestSegment == $type->alias) ? '' : 'hidden'}}">
                                        @foreach($conditionsTypes as $condition )
                                            <div class="seo-search-left-additional">
                                                <a href="{{ route('typeConditions',['city'=>$city ?? false, 'type'=>$type->alias ?? false, 'condition' => $condition[1]] ) }}"> {{$condition[2]}}
                                                    ({{$condition[0]}})</a>
                                            </div>


                                        @endforeach
                                    </div>
                                    <div class="line-grey"></div>


                                @endforeach

                                {{--@endisset--}}
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


