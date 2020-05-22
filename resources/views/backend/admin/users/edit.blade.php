@extends('layouts.backend')

@section('content')
<div class="container">
    <ul class="nav nav-tabs mb-3">

        <li class="nav-item"><a class="nav-link active" href="{{route('index')}}">Пользователи</a></li>
        <li class="nav-item"><a class="nav-link" href="{{route('adminpage')}}">Владельцы</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Бронирования</a></li>

    </ul>
    <div class="row">
        <div class="col"> <h3 class="">Редактировать пользователя</h3></div>
    </div>
    <div class="container">
        <div class="row pb-2">
            <div class="col mb-1 bg-white col-1 shadow-sm"><b>№</b></div>
            <div class="col mb-1 bg-white col-2 shadow-sm"><b>ФИО</b></div>
            <div class="col mb-1 bg-white col-3 shadow-sm"><b>Телефон/email</b></div>
            <div class="col mb-1 bg-white col-2 shadow-sm"><b>Роль</b></div>
            <div class="col mb-1 bg-white col-2 shadow-sm"><b>Дата</b></div>
            <div class="col mb-1 bg-white col-2 shadow-sm"><b>Удалить/редактировать</b></div>
        </div>

    </div>

</div>

@endsection

