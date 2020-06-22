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
        <app-admin-reservations-index></app-admin-reservations-index>


    </div>

    </div>

@endsection

