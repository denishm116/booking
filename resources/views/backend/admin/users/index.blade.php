@extends('layouts.backend')

@section('content')
    <div class="container">
        <ul class="nav nav-tabs mb-3">

            <li class="nav-item"><a class="nav-link active" href="{{route('index')}}">Пользователи</a></li>

            <li class="nav-item"><a class="nav-link" href="{{route('reservationIndex')}}">Бронирования</a></li>

        </ul>
        <div class="row">
            <div class="col"><h3 class="">Пользователи</h3></div>
            <div class="col text-right"><h3 class=""><a class="btn btn-detailed" href="{{route('addUserForm')}}">Добавить
                        пользоваетля</a></h3></div>

        </div>
        <div class="row">
            <div class="col my-3 bg-white">
            <form action="?" method="GET">
                <div class="row">

                    <div class="col">
                        <input name="checkUserObject" type="radio" value="allUsers"  @if  (app('request')->input('checkUserObject') == 'allUsers' || !app('request')->input())checked @endif> Все пользователи
                    </div>
                    <div class="col">
                        <input name="checkUserObject" type="radio" value="usersWithoutObject" @if  (app('request')->input('checkUserObject') == 'usersWithoutObject') checked @endif> Владельцы без объектов
                    </div>
                    <div class="col">
                        <input name="checkUserObject" type="radio" value="usersWithObject" @if  (app('request')->input('checkUserObject') == 'usersWithObject') checked @endif> Владельцы с объектами
                    </div>
                    <div class="col">
                        <input name="checkUserObject" type="radio" value="guests" @if  (app('request')->input('checkUserObject') == 'guests') checked @endif> Гости
                    </div>
                    <div class="col">

                        <input type="checkbox" id="desc" name="desc" @if  (app('request')->input('desc') == 'on') checked @endif> Сначала старые

                    </div>
                    <div class="col">

                        <button type="submit" class="btn btn-primary">Сортировать</button>

                    </div>
                    <div class="col">


                        <a href="?" class="btn btn-outline-secondary">Сброс</a>

                    </div>
                </div>

            </form>
            </div>
        </div>
        <div class="container">
            <div class="row pb-2">
                <div class="col mb-1 bg-white col-1 shadow-sm"><b>№</b></div>
                <div class="col mb-1 bg-white col-4 shadow-sm"><b>ФИО</b></div>
                <div class="col mb-1 bg-white col-2 shadow-sm"><b>Телефон</b></div>
                <div class="col mb-1 bg-white col-3 shadow-sm"><b>Email</b></div>
                <div class="col mb-1 bg-white col-1 shadow-sm"><b>роль</b></div>
                <div class="col mb-1 bg-white col-1 shadow-sm"><b>Статус</b></div>
            </div>
            <div class="row pb-2">
                @foreach($users as $user)
                    <div class="col mb-1 bg-white col-1 shadow-sm">{{$user->id}}
                        @if($user->getOwnerObjects()->isEmpty() && $user->hasOwnerRole())
                            <i class="fas fa-circle"></i>
                        @endif
                    </div>
                    <div class="col mb-1 bg-white col-4 shadow-sm"><a
                            href="{{route('showUser', ['id' => $user->id])}}"
                            title="{{$user->created_at}}"> {{$user->fullPayName}}</a></div>
                    <div class="col mb-1 bg-white col-2 shadow-sm">{{$user->phone}}</div>

                    <div class="col mb-1 bg-white col-3 shadow-sm">{{$user->email}}</div>
                    <div class="col mb-1 bg-white col-1 shadow-sm">
                        @foreach($user->roles as $role)
                            {{$role->name}}
                        @endforeach
                    </div>
                    <div class="col mb-1 bg-white col-1 shadow-sm text-center">
                        <form method="POST" action="{{route('activateUser', ['id' => $user->id])}}">
                            @csrf
                            {{--<input type="hidden" value="{{$user->id}}">--}}
                            @if ($user->isActive())
                                <div class="btn btn-sm btn-light">Подтв.</div>
                            @else
                                <button type="submit" class="btn btn-sm btn-danger">Активир.</button>
                            @endif
                        </form>
                    </div>
                @endforeach
            </div>

            {{ $users->links() }}

        </div>

    </div>

@endsection

