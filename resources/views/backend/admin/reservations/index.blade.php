@extends('layouts.backend')

@section('content')
    <div class="container">
        <ul class="nav nav-tabs mb-3">

            <li class="nav-item"><a class="nav-link" href="{{route('index')}}">Пользователи</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('admin.objects.index')}}">Объекты</a></li>
            <li class="nav-item"><a class="nav-link active" href="#">Бронирования</a></li>

        </ul>
        <div class="row">
            <div class="col"><h3 class="">Бронировния</h3></div>
            <div class="col text-right"><h3 class=""><a class="btn btn-detailed" href="{{route('addReservationForm')}}">Добавить
                        бронирование</a></h3></div>

        </div>

        <div class="container">
            <div class="row pb-2">
                <div class="col mb-1 bg-white col-1 shadow-sm p-2"><b>№</b></div>
                <div class="col mb-1 bg-white col-3 shadow-sm p-2"><b>Гость/телефон</b></div>
                <div class="col mb-1 bg-white col-3 shadow-sm p-2"><b>Хозяин/телефон</b></div>
                <div class="col mb-1 bg-white col-3 shadow-sm p-2"><b>заезд/выезд</b></div>
                <div class="col mb-1 bg-white col-1 shadow-sm p-2"><b>Оплата</b></div>
                <div class="col mb-1 bg-white col-1 shadow-sm p-2"><b>Статус</b></div>
            </div>

            @foreach($reservations as $reservation)
                <div class="row mb-2">

                    <div class="col mb-1 bg-white col-1 shadow-sm p-2 text-center">
                        <a href="{{route('showReservation', ['id'=>$reservation->id])}}">
                        {{$reservation->id}}
                        <i class="fas fa-user-cog"></i>
                        </a>
                    </div>
                    <div class="col mb-1 bg-white col-3 shadow-sm p-2"><a
                            href="{{route('showReservation', ['id' => $reservation->id])}}"
                            title="{{$reservation->description}}"> {{$reservation->getUsername()}}</a><br>{{$reservation->getUser()->phone}}
                    </div>
                    <div class="col mb-1 bg-white col-3 shadow-sm p-2">{{$reservation->getOwner()->name}}
                        <br>{{$reservation->getOwner()->phone}}</div>
                    <div class="col mb-1 bg-white col-3 shadow-sm p-2">
                        <i>заезд: </i> {{ strftime('%d-%b-%Y', strtotime( $reservation->day_in))  }}
                        <br><i>выезд: </i> {{ strftime('%d-%b-%Y', strtotime( $reservation->day_out))  }}</div>
                    <div class="col mb-1 bg-white col-1 shadow-sm p-2"><i
                            class="fas fa-angle-right"></i>{{$reservation->price}}<br><i
                            class="fas fa-angle-double-right"></i>{{$reservation->reward}}

                    </div>
                    <div class="col mb-1 bg-white col-1 shadow-sm p-2 text-center money-button">
                    @if ($reservation->status)
                        <a href="#" class="btn btn-success">
                            @if ($reservation->paid)
                                <i class="fas fa-ruble-sign"></i>
                            @else
                                <i class="fas fa-ellipsis-h"></i>
                            @endif
                        </a>
                        @else
                            <a href="{{route('confirmReservation', ['id' => $reservation->id])}}" class="btn btn-danger">
                                @if ($reservation->paid)
                                    <i class="fas fa-ruble-sign"></i>
                                @else
                                    <i class="fas fa-ellipsis-h"></i>
                                @endif
                            </a>
                    @endif



                    </div>
                </div>
            @endforeach


        </div>

        {{ $reservations->links() }}

    </div>

    </div>

@endsection

