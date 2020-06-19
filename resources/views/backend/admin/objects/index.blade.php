@extends('layouts.backend')

@section('content')
    <div class="container">
        <ul class="nav nav-tabs mb-3">

            <li class="nav-item"><a class="nav-link" href="{{route('index')}}">Пользователи</a></li>
            <li class="nav-item"><a class="nav-link active" href="#">Объекты</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('reservationIndex')}}">Бронирования</a></li>


        </ul>
        <div class="row">
            <div class="col"><h3 class="">Объекты</h3></div>
            <div class="col text-right"><h3 class=""><a class="btn btn-detailed" href="{{route('saveObject')}}">Добавить
                        объект</a></h3></div>

        </div>

        <div class="container">
            <div class="row pb-2 justify-content-center">
                <div class="col mb-1 bg-white col-1 shadow-sm p-2"><b>№</b></div>
                <div class="col mb-1 bg-white col-1 shadow-sm p-2"><b>Город</b></div>
                <div class="col mb-1 bg-white col-3 shadow-sm p-2"><b>Название</b></div>
                <div class="col mb-1 bg-white col-2 shadow-sm p-2"><b>Владелц</b></div>
                <div class="col mb-1 bg-white col-2 shadow-sm p-2"><b>Статус</b></div>
                <div class="col mb-1 bg-white col-2 shadow-sm p-2"><b>Номера</b></div>
            </div>

            @foreach($objects as $object)
                <div class="row mb-2 justify-content-center">

                    <div class="col mb-1 bg-white col-1 shadow-sm p-2 text-center">
                        <a href="{{route('deleteObject', ['id'=>$object->id])}}">
                            {{$object->id}}
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </div>
                    <div class="col mb-1 bg-white col-1 shadow-sm p-2">{{$object->city->name}}
                    </div>
                    <div class="col mb-1 bg-white col-3 shadow-sm p-2">{{$object->name}} <br><a
                            class="btn btn-success eye"
                            href="{{route('object', ['id'=>$object->id])}}" style="margin: 0; padding: 0 5px;"><i
                                style="color: white" class="far fa-eye"></i></a>
                        <a href="{{route('saveObject', ['id'=>$object->id])}}" style="margin: 0; padding: 0 5px;"
                           class="btn btn-danger eye"
                        ><i class="fas fa-cog" style="color: white"></i></a>

                    </div>
                    <div class="col mb-1 bg-white col-2 shadow-sm p-2">{{$object->user->fullName}}
                        <br>{{$object->user->phone}}

                    </div>
                    <div class="col mb-1 bg-white col-2 shadow-sm p-2">

                        @if ($object->isModerated())
                            <a href="{{route('admin.objects.unmoderate', ['id' => $object->id])}}"
                               class="btn btn-success">
                                Скрыть из поиска
                            </a>
                        @else
                            <a href="{{route('admin.objects.moderate', ['id' => $object->id])}}" class="btn btn-danger">
                                Добавить в поиск
                            </a>
                        @endif
                    </div>
                    <div class="col mb-1 bg-white col-2 shadow-sm p-2 text-center money-button">
                        @if (!$object->hasRooms())
                            <a href="{{route('saveRoom').'?object_id='.$object->id}}" class="btn btn-danger">
                                {{count($object->rooms)}} + добавить
                            </a>
                        @else
                            <a href="{{route('saveRoom').'?object_id='.$object->id}}" class="btn btn-success eye"
                               style="margin: 0; padding: 0 5px;">
                                + добавить
                            </a>
                            <hr>
                            @foreach($object->rooms as $room)
                                id{{$room->id}}
                                <a href="{{route('room', ['id'=>$room->id])}}" style="margin: 0; padding: 0 5px;"
                                   class=" btn  btn-success eye"><i class="far fa-eye"></i></a>
                                <a href="{{route('saveRoom', ['id'=>$room->id])}}" style="margin: 0; padding: 0 5px;"
                                   class=" btn  btn-danger eye"><i class="fas fa-cog"></i></a>

                                <a href="
{{route('deleteRoom', ['id'=>$room->id])}}
                                    " class="eye"
                                ><i class="fas fa-trash-alt" style="color: #1b1e21;"></i></a>
                                <br>

                            @endforeach
                        @endif
                    </div>
                </div>
            @endforeach


        </div>
        <div class="container">
            <div class="row m-3">
                <div class="col">
                    {{ $objects->links() }}
                </div>
            </div>
        </div>



    </div>

    </div>

@endsection

