@extends('layouts.backend')

@section('content')
    <div class="container">
        <ul class="nav nav-tabs mb-3">

            <li class="nav-item"><a class="nav-link active" href="{{route('index')}}">Пользователи</a></li>

            <li class="nav-item"><a class="nav-link" href="#">Бронирования</a></li>

        </ul>
        <div class="row">


        </div>
        <div class="row">
            <div class="col"><h3 class="">Пользователь</h3></div>
            <div class="col-2 bg-white"><a class="btn btn-detailed" href="{{route('addUserForm', ['id'=>$user->id])}}">Редактировать</a>
            </div>

            @if($user->getOwnerObjects()->isEmpty())
                <div class="col-2 bg-white"><a class="btn btn-danger" href="{{route('deleteUser', ['id'=>$user->id])}}">Удалить</a>
                </div>
            @else
                <div class="col-2 bg-white"><a class="btn btn-light" href="#">Удалить</a>
                </div>
            @endif


        </div>
        <div class="container">
            <div class="row pb-2">
                <div class="col-2 bg-white"><b>№</b></div>
                <div class="col-10  bg-white">{{$user->id}}</div>

            </div>
            <div class="row pb-2">
                <div class="col-2 bg-white"><b>ФИО</b></div>
                <div class="col-10 bg-white">{{$user->fullName}}</div>

            </div>
            <div class="row pb-2">
                <div class="col-2 bg-white"><b>Телефон</b></div>
                <div class="col-10 bg-white">{{$user->phone}}</div>

            </div>
            <div class="row pb-2">
                <div class="col-2 bg-white"><b>E-mail</b></div>
                <div class="col-10 bg-white">{{$user->email}}</div>

            </div>
            <div class="row pb-2">
                <div class="col-2 bg-white"><b>Роль</b></div>
                <div class="col-10 bg-white">
                    @foreach($user->roles as $role)
                        {{$role->name}}
                    @endforeach
                </div>

            </div>
            <div class="row pb-2">
                <div class="col-2 bg-white"><b>Дата</b></div>
                <div class="col-10 bg-white">{{$user->created_at}}</div>

            </div>
            <div class="row pb-2">
                <div class="col-2 bg-white"><b>Потдвержден</b></div>
                <div class="col-10 bg-white">
                    <form method="POST" action="{{route('activateUser', ['id' => $user->id])}}">
                        @csrf
                        {{--<input type="hidden" value="{{$user->id}}">--}}
                        @if ($user->isActive())
                            <div class="btn btn-sm btn-success">Активен</div>
                        @else
                            <button type="submit" class="btn btn-sm btn-danger">Активировать</button>
                        @endif
                    </form>
                </div>

            </div>
            <div class="row pb-2">
                <div class="col-2 bg-white"><b>Объекты</b></div>
                <div class="col-10 bg-white">

                    @foreach($user->getOwnerObjects() as $object)
                        <a href="{{route('object', ['id'=>$object->id])}}">{{$object->name}}</a> ,
                    @endforeach

                </div>
            </div>

        </div>

    </div>

@endsection

