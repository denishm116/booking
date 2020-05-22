@extends('layouts.backend')

@section('content')
    <div class="container mb-3">
        <ul class="nav nav-tabs mb-3">

            <li class="nav-item"><a class="nav-link" href="{{route('index')}}">Пользователи</a></li>

            <li class="nav-item"><a class="nav-link active" href="{{route('reservationIndex')}}">Бронирования</a></li>

        </ul>

        <div class="row">
            <div class="col"><h3 class="">Бронирование</h3></div>
            <div class="col-2 bg-white">
            </div>


        </div>
        <div class="container">
            <form action="{{route('addReservation',  ['id' => $reservation->id ?? null])}}" method="POST">
                @csrf
                <div class="row pb-2">

                    <div class="col-2 bg-light-dark"><b>Гость</b></div>
                    <div class="col-6 bg-white">
                        <select class="userSelect form-control" name="user_id">
                            <option>---</option>
                            @foreach($users as $user)
                                <option value="{{$user->id}}"
                                        @isset($reservation)
                                        @if ($user->id == $reservation->user_id)
                                        selected
                                    @endif
                                    @endisset
                                >{{$user->id}}. {{$user->fullPayName}} </option>
                            @endforeach
                        </select>

                    </div>


                </div>
                <div class="row pb-2">
                    <div class="col-2 "><b>Телефон Гостя</b></div>

                    <div class="col-6 bg-white"><input type="text" class="phone form-control" name="phone" readonly
                                                       value="{{$user->phone ?? null}}"></div>

                </div>

                <div class="row pb-2">
                    <div class="col-2 bg-light-dark"><b>Заезд</b></div>
                    <div class="col-6 bg-white">
                        <input type="date" value="{{ $reservation->day_in ?? null}}" class="form-control"
                               name="checkin">
                        {{--{{ strftime('%d-%b-%Y', strtotime( $reservation->day_in))  }}--}}
                    </div>

                </div>


                <div class="row pb-2">
                    <div class="col-2 bg-light-dark"><b>Отъезд</b></div>
                    <div class="col-6 bg-white">
                        <input type="date" value="{{ $reservation->day_out ?? null}}" class="form-control"
                               name="checkout">
                        {{--                    {{ strftime('%d-%b-%Y', strtotime( $reservation->day_out))  }}--}}
                    </div>

                </div>
                <div class="row pb-2">
                    <div class="col-2 bg-white"><b>Город</b></div>
                    <div class="col-1 bg-white ">
                        <input type="text" class="city-id form-control" name="city_id"
                               value="{{$reservation->city_id ?? null}}">
                    </div>
                    <div class="col-5 bg-white city-name">
                        {{$city->name ?? null}}
                    </div>

                </div>
                <div class="row pb-2">
                    <div class="col-2 bg-white"><b>Владелец</b></div>
                    <div class="col-10 bg-white">{{$reservation->getOwner()->name}}</div>

                </div>

                <div class="row pb-2">
                    <div class="col-2 bg-light-dark"><b>Телефон владельца</b></div>


                </div>
                <div class="row pb-2">
                    <div class="col-2 bg-light-dark"><b>Объект размещения</b></div>
                    <div class="col-6 bg-white">

                        <select class="object  form-control">
                            <option>---</option>
                            @foreach($objects as $object)
                                <option value="{{$object->id}}"
                                        @isset($reservation)
                                        @if ($object->id == $room->object_id)
                                        selected
                                    @endif
                                    @endisset
                                >{{$object->id}}. {{$object->name}} </option>
                            @endforeach
                        </select>
                    </div>


                </div>
                <div class="row pb-2">
                    <div class="col-2 bg-light-dark"><b>Номер</b></div>
                    <div class="col-6 bg-white">
                        <select class="room form-control" name="room_id">
                            @isset($reservation)

                                @foreach($obj->rooms as $rooms)
                                    {{$rooms}}
                                    <option
                                        @if($rooms->id == $room->id)
                                        selected
                                        @endif
                                    >{{$rooms->id}}</option>

                                @endforeach
                            @endisset
                        </select>

                    </div>


                </div>
                <div class="row pb-2">
                    <div class="col-2 bg-light-dark"><b>Описание</b></div>
                    <div class="col-6 bg-white">
                        <input type="text" class="description form-control" name="description"
                               value="{{$reservation->description ?? null}}">
                    </div>

                </div>
                <div class="row pb-2">
                    <div class="col-2 bg-light-dark"><b>Статус</b></div>
                    <div class="col-6 bg-white">

                        <select class="form-control" name="status">
                            <option value="0">Ожидает подтверждения</option>
                            <option value="1"
                                    @isset($reservation)
                                    @if ($reservation->isConfirmed())
                                    selected
                                @endif
                                @endisset
                            >Подтверждено
                            </option>


                        </select>
                    </div>


                </div>
                <div class="row pb-2">
                    <div class="col-2 bg-light-dark"><b>Платное</b></div>
                    <div class="col-6 bg-white">

                        <select name="paid" class="form-control" name="paid">
                            <option value="0">Нет</option>
                            <option value="1"
                                    @isset($reservation)
                                    @if ($reservation->isPaid())
                                    selected
                                @endif
                                @endisset
                            >Да
                            </option>


                        </select>
                    </div>
                </div>
                @isset($reservation)
                    <div class="row pb-2">
                        <div class="col-3 bg-white"><b>Полная стоимость {{$reservation->price}}</b></div>
                        <div class="col-3 bg-white">
                            Комиссия {{$reservation->comission * 100}}%
                        </div>
                        <div class="col-3 bg-white">
                            Наша комиссия {{$reservation->reward}}
                        </div>
                    </div>
                @endisset

                <div class="row">
                    <div class="col-5 bg-white">
                        <button type="submit" class="btn choice__button">
                            Сохранить
                        </button>
                        {{--<form method="POST" action="{{route('confirmReservation', ['id' => $reservation->id])}}">--}}
                        {{--@csrf--}}

                        {{--@if ($reservation->isConfirmed())--}}
                        {{--<div class="btn btn-sm btn-success"><i class="fas fa-ruble-sign"></i></div>--}}
                        {{--@else--}}
                        {{--<button type="submit" class="btn btn-sm btn-danger">Вернуть деньги</button>--}}
                        {{--@endif--}}
                        {{--</form>--}}
                    </div>
                </div>
            </form>
        </div>

    </div>

@endsection

