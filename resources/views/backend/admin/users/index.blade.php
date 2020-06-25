@extends('layouts.backend')

@section('content')
    <div class="container">
        <ul class="nav nav-tabs mb-3">

            <li class="nav-item"><a class="nav-link active" href="{{route('index')}}">Пользователи</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('admin.objects.index')}}">Объекты</a></li>
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
                            <input name="checkUserObject" type="radio" value="allUsers"
                                   @if  (app('request')->input('checkUserObject') == 'allUsers' || !app('request')->input())checked @endif>
                            Все пользователи
                        </div>
                        <div class="col">
                            <input name="checkUserObject" type="radio" value="usersWithoutObject"
                                   @if  (app('request')->input('checkUserObject') == 'usersWithoutObject') checked @endif>
                            Владельцы без объектов
                        </div>
                        <div class="col">
                            <input name="checkUserObject" type="radio" value="usersWithObject"
                                   @if  (app('request')->input('checkUserObject') == 'usersWithObject') checked @endif>
                            Владельцы с объектами
                        </div>
                        <div class="col">
                            <input name="checkUserObject" type="radio" value="guests"
                                   @if  (app('request')->input('checkUserObject') == 'guests') checked @endif> Гости
                        </div>
                        <div class="col">

                            <input type="checkbox" id="desc" name="desc"
                                   @if  (app('request')->input('desc') == 'on') checked @endif> Сначала старые

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
        <td class="container">
            <table class="table table-dark table-striped  table-hover">
                <thead>
                <tr>

                    <th scope="col">№</th>
                    <th scope="col">ФИО</th>
                    <th scope="col">Телефон</th>
                    <th scope="col">Email</th>
                    <th scope="col">роль</th>
                    <th scope="col">Статус</th>

                </tr>
                </thead>

                <tbody class="">
                <tr>

                    @foreach($users as $user)

                        <td>{{$user->id}}
                            @if($user->getOwnerObjects()->isEmpty() && $user->hasOwnerRole())
                                <i class="fas fa-circle"></i>
                            @endif
                        </td>
                        <td><a
                                href="{{route('showUser', ['id' => $user->id])}}"
                                title="{{$user->created_at}}"> {{$user->fullPayName}}</a></td>
                        <td>

                            <button style="margin: 0; padding: 0 5px;"
                                    class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"><i class="fas fa-sms"
                                                             style="color: white"> {{$user->phone}}</i></button>
                            <app-sms-send :User="{{json_encode($user)}}"></app-sms-send>


                        </td>

                        <td>

                            <button style="margin: 0; padding: 0 5px;"
                                    class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"><i class="fas fa-envelope"
                                                             style="color: white"> {{$user->email}}</i></button>

                            <app-mail-send
                                :User="{{json_encode($user)}}"
                            ></app-mail-send>

                        </td>
                        <td>
                            @foreach($user->roles as $role)
                                {{$role->name}}
                            @endforeach
                        </td>
                        <td>
                            <form method="POST" action="{{route('activateUser', ['id' => $user->id])}}">
                                @csrf
                                {{--<input type="hidden" value="{{$user->id}}">--}}
                                @if ($user->isActive())
                                    <div class="btn btn-sm btn-light">Подтв.</div>
                                @else
                                    <button type="submit" class="btn btn-sm btn-danger">Активир.</button>
                                @endif
                            </form>
                        </td>
                </tr>
                    @endforeach


                </tbody>
            </table>
            {{ $users->links() }}

        </div>

    </div>

@endsection

