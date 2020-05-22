@extends('layouts.layout')

@section('title', 'Избранное - krim-leto.ru')

@section('description', 'Отдых в Крыму в 2020 году: гостиницы, частный сектор, гостевые дома с отзывами. Избранное')

@section('canonical', 'canonical')
@section('canonical-address', 'https://krim-leto.ru')

@section('content')

    <div class="app">

        <header>


            <div class="pt-4 pb-4 header-background img-fluid header-catalog" id="background">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-12 col-12">
                            <h1 class="header__title">Избранное</h1>

                        </div>
                    </div>
                </div>
            </div>
        </header>


        <div class="container">
            <div class="breadcrumb-holder my-1">
                <ul class="basic-breadcrumbs">
                    <li class="d-none d-lg-block"><a href="{{route('home')}}">Главная</a></li>

                    <li class="d-none d-lg-block"><a href="#">Избранное</a></li>
                </ul>
            </div>

            <div class="container ">
                <div class="row shadow-orange p-3 mb-5">


                    <div class="col-lg-3">
                        <div class="row justify-content-center mb-3">
                            <div class="col m-0 p-0">
                                <div class="p-3 mb-3 bg-white border-orange seo-search-left-col">

                                    <h2 class="text-center">Тип жилья</h2>
                                    @foreach($types as $type )
                                        <div class="">
                                            <a href="{{ route('cityConditions',['alias' => 'krim', 'type'=>$type->alias] ) }}"> {{$type->title}} </a><br>
                                        </div>

                                        <div class="line-grey"></div>


                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-9 align-content-center">


                        @forelse($rooms as $room)
@include('layouts.card')
                            {{--<div class="card-main-page">--}}

                                {{--<div class="card-main-page__photo">--}}
                                    {{--<div class="card-main-page__photo-header"><a--}}
                                            {{--href="{{ route('room',['id'=>$room->id]) }}">Номер ID--}}
                                            {{--{{$room->id}}--}}
                                        {{--</a>--}}
                                    {{--</div>--}}

                                    {{--<div class="card__photo-wrapper">--}}
                                        {{--<a href="{{ route('room',['id'=>$room->id]) }}">--}}
                                            {{--<div class="for-star-icon">--}}
                                            {{--<img class="" src="{{ $room->photos->first()->path ?? $placeholder}}"--}}

                                                 {{--alt="{{ str_limit($room->description,150) }}">--}}
                                                {{--<div class="star-icon">--}}
                                                   {{--<small> {!! $room->object->rating ?? null!!}</small>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}

                                        {{--</a>--}}
                                    {{--</div>--}}

                                {{--</div>--}}

                                {{--<div class="card-main-page__content">--}}

                                    {{--<div class="card-main-page__content-wrapper">--}}

                                        {{--<div class="card-main-page__content-wrapper-row-1">--}}
                                            {{--<div class="">--}}
                                                {{--<i class="fas fa-map-marker-alt"></i> {!! $room->object->city->name ?? null!!}--}}
                                                {{--, {{$room->object->address->street}}, {{$room->object->address->number}}--}}
                                            {{--</div>--}}
                                            {{--<div class="">--}}
                                                {{--море: {{$room->object->distance->title ?? null}}--}}

                                            {{--</div>--}}

                                        {{--</div>--}}
                                        {{--<div class="card-main-page__content-wrapper-row-2">--}}
                                            {{--<div class="card-main-page__content-wrapper-row-2-1">--}}
                                                {{--<div class="">--}}
                                                    {{--{{$room->room_size}}-местный номер--}}
                                                {{--</div>--}}

                                                {{--<div class="">--}}
                                                    {{--<a href="#"--}}
                                                       {{--class="favorite-delete" data="{{$room->id}}"--}}
                                                       {{--role="button"><i class="fas fa-heart"></i> удалить</a>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="card-main-page__content-wrapper-row-2-2">--}}
                                                {{--<div>--}}
                                                    {{--<span> <a href="{{ route('room',['id'=>$room->id]) }}">Название: {{$room->id}}</a></span>--}}
                                                {{--</div>--}}
                                                {{--<div>--}}

                                                {{--</div>--}}
                                            {{--</div>--}}

                                        {{--</div>--}}
                                        {{--<div class="card-main-page__content-wrapper-row-3">--}}

                                        {{--@forelse($room->rservices as $service)--}}
                                                {{--<div class="content-wrapper-row-3">--}}
                                                    {{--<i class="fas fa-angle-down"> </i> {{$service->title}}--}}

                                                {{--</div>--}}


                                            {{--@empty--}}
                                            {{--@endforelse--}}


                                        {{--</div>--}}

                                        {{--<div class="card-main-page__content-wrapper-row-4">--}}
                                            {{--<a href="{{route('object', ['id' => $room->object->id])}}">Объект:  {{$room->object->name}}</a>--}}
                                        {{--</div>--}}

                                        {{--<div class="card-main-page__content-wrapper-row-5">--}}
                                            {{--<div class="">--}}
                                                {{--<a href="{{ route('object',['id'=>$room->id]) }}"--}}
                                                   {{--class="btn choice__button choice__button__small"--}}
                                                   {{--role="button">забронировать</a>--}}
                                            {{--</div>--}}

                                            {{--<div class="">--}}
                                                {{--<a href="{{ route('object',['id'=>$room->id]) }}"--}}
                                                   {{--class="btn btn-detailed"--}}
                                                   {{--role="button">подробнее</a>--}}
                                            {{--</div>--}}

                                            {{--<div class="">--}}

                                                {{--от <span> {{$room->price ?? null}} </span> &#8381;--}}

                                            {{--</div>--}}

                                        {{--</div>--}}


                                    {{--</div>--}}
                                {{--</div>--}}

                            {{--</div>--}}
                            {{--                        {{ $rooms->links() }}--}}
                        @empty
                            <h2 class="text-center">В Избранном пусто! Для того, чтобы добавить номер в Избранное,
                                нажимайте на сердечко</h2>

                        @endforelse


                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

