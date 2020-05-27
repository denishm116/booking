@extends('layouts.backend')

@section('content')
    <div class="container mb-3">
        <ul class="nav nav-tabs mb-3">

            <li class="nav-item"><a class="nav-link" href="{{route('index')}}">Пользователи</a></li>

            <li class="nav-item"><a class="nav-link active" href="{{route('reservationIndex')}}">Бронирования</a></li>

        </ul>

        <div class="row">
            <div class="col"><h3 class="">Бронирование</h3></div>
            <div class="col-2 bg-white"><a class="btn btn-detailed" href="{{route('addReservationForm', ['id'=>$reservation->id])}}">Редактировать</a>
            </div>
            @if($reservation->isConfirmed())

                <div class="col-2 bg-white"><a class="btn btn-light" href="#">Удалить</a>
                </div>

            @else
                <div class="col-2 bg-white"><a class="btn btn-danger" href="{{route('removeReservation', ['id'=>$reservation->id])}}">Удалить</a>
                </div>
            @endif


        </div>
        <div class="container">
            <div class="row pb-2">
                <div class="col-2 bg-white"><b>№</b></div>
                <div class="col-10  bg-white">{{$reservation->id}}</div>

            </div>
            <div class="row pb-2">
                <div class="col-2 bg-white"><b>Гость</b></div>
                <div class="col-10 bg-white"> {{$reservation->getUsername()}}</div>

            </div>
            <div class="row pb-2">
                <div class="col-2 bg-light-dark"><b>Телефон Гостя</b></div>
                <div class="col-10 bg-light-dark">{{$reservation->getUser()->phone}}</div>

            </div>

            <div class="row pb-2">
                <div class="col-2 bg-white"><b>Заезд</b></div>
                <div class="col-10 bg-white">
                    {{ strftime('%d-%b-%Y', strtotime( $reservation->day_in))  }}
                </div>

            </div>


            <div class="row pb-2">
                <div class="col-2 bg-white"><b>Отъезд</b></div>
                <div class="col-10 bg-white">
                    {{ strftime('%d-%b-%Y', strtotime( $reservation->day_out))  }}
                </div>

            </div>
            <div class="row pb-2">
                <div class="col-2 bg-white"><b>Город</b></div>
                <div class="col-10 bg-white">{{$reservation->getCity()->name}}</div>

            </div>            <div class="row pb-2">
                <div class="col-2 bg-white"><b>Владелец</b></div>
                <div class="col-10 bg-white">{{$reservation->getOwner()->name}}</div>

            </div>

            <div class="row pb-2">
                <div class="col-2 bg-light-dark"><b>Телефон владельца</b></div>
                <div class="col-10 bg-light-dark">{{$reservation->getOwner()->phone}}</div>

            </div>
            <div class="row pb-2">
                <div class="col-2 bg-white"><b>Объект размещения</b></div>
                <div class="col-10 bg-white"><a href="{{route('object', ['id' => $reservation->getObject()->id])}}"> {{$reservation->getObject()->name}}</a></div>

            </div>
            <div class="row pb-2">
                <div class="col-2 bg-white"><b>Номер</b></div>
                <div class="col-10 bg-white"><a href="{{route('room', ['id' => $reservation->room->id])}}">{{$reservation->room->id}}</a></div>

            </div>
            <div class="row pb-2">
                <div class="col-2 bg-white"><b>Описание</b></div>
                <div class="col-10 bg-white">{{$reservation->description}}</div>

            </div>
            <div class="row pb-2">
                <div class="col-3 bg-white"><b>Полная стоимость {{$reservation->price}}</b></div>
                <div class="col-3 bg-white">
                    Комиссия {{$reservation->comission * 100}}%
                </div>
                <div class="col-3 bg-white">
                    Наша комиссия {{$reservation->reward}}
                </div>
            </div>
            <div class="row pb-2">
                <div class="col-2 bg-white"><b>Статус</b></div>
                <div class="col-2 bg-white">


                        @if ($reservation->isConfirmed())
                            <div class="btn btn-sm btn-success">Подтверждено</div>
                        @else
                            <a href="{{route('confirmReservation', ['id' => $reservation->id])}}" class="btn btn-sm btn-danger">Подтвердить</a>
                        @endif

                </div>
               <div class="col-4 bg-white">


                        @if ($reservation->isConfirmed())

                            <a href="{{route('removeConfirmation', ['id' => $reservation->id])}}" class="btn btn-sm btn-danger">Убрать подтверждение</a>
                        @endif

                </div>

                <div class="col-2 bg-white">
                    <form method="POST" action="{{route('confirmReservation', ['id' => $reservation->id])}}">
                        @csrf

                        @if ($reservation->isConfirmed())
                            <div class="btn btn-sm btn-success"><i class="fas fa-ruble-sign"></i></div>
                        @else
                            <button type="submit" class="btn btn-sm btn-danger">Вернуть деньги</button>
                        @endif
                    </form>
                </div>

            </div>

        </div>

    </div>

@endsection

