@extends('layouts.backend')

@section('content')
    <div class="container">
        <ul class="nav nav-tabs mb-3">

            <li class="nav-item"><a class="nav-link" href="{{route('index')}}">Пользователи</a></li>
            <li class="nav-item"><a class="nav-link active" href="{{route('adminpage')}}">Владельцы</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Бронирования</a></li>

        </ul>

        <h3 class="">Владельцы</h3>

        <div class="container">
            <div class="row pb-2">
                <div class="col mb-1 bg-white col-1 shadow-sm"><b>№</b></div>
                <div class="col mb-1 bg-white col-2 shadow-sm"><b>ФИО</b></div>
                <div class="col mb-1 bg-white col-3 shadow-sm"><b>Телефон/email</b></div>
                <div class="col mb-1 bg-white col-3 shadow-sm"><b>Объект/действия</b></div>
                <div class="col mb-1 bg-white col-2 shadow-sm"><b>Дата</b></div>
            </div>
            @foreach($owners as $owner)
                <div class="row pb-2 checkObj">
                    <div class="col mb-1 bg-white col-1 shadow-sm">{{$owner->id}}</div>
                    <div class="col mb-1 bg-white col-2 shadow-sm">{!! $owner->getFullPayNameAttribute() !!}</div>
                    <div class="col mb-1 bg-white col-3 shadow-sm">{{$owner->phone}}<br><a
                            href="mailto: {{$owner->email}}">{{$owner->email}}</a></div>
                    <div class="col mb-1 bg-white col-3 shadow-sm checkObj">
                        @foreach($objects as $obj)

                            @foreach($citys as $city)
                                @if($obj->user_id == $owner->id && $obj->city_id === $city->id)
                                    <a href="{{ route('saveObject',['id'=>$obj->id])}}">{{$obj->name}}</a> <br>
                                    <b>{{$city->name}}</b>,<br>
                                    {{$obj->address->street}} д. {{$obj->address->number}}
                                    <hr>

                                @endif
                            @endforeach


                        @endforeach


                    </div>

                    <div class="col mb-1 bg-white col-2 shadow-sm ">{{$owner->created_at}}</div>
                </div>
            @endforeach
        </div>

    </div>
    @push('scripts')
    <script>
        let emtyField = document.querySelectorAll('.checkObj');
        for (let item of emtyField) {
            if(!item.innerHTML) {

                item.classList.remove('bg-white');
                item.classList.add('bg-info');
                item.innerHTML = `<h3 class="pt-2">Нет объекта</h3>`;

            }
        }

    </script>
    @endpush
@endsection

