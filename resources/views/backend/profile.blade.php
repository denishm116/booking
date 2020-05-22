
@extends('layouts.backend')

@section('content')
    <div class="container">
    <h3 class="about__title">Кабинет пользователя</h3>
    <div class="col-xl-4 line"></div>

<form {{ $novalidate  }} action="{{ route('profile') }}" method="POST" enctype="multipart/form-data">
    <fieldset>

            <label for="name">Имя</label>
            <div class="col-lg-10">
                <input name="name" type="text"  class="form-control" id="name" value="{{ $user->name}}">
            </div>


            <label for="surname">Фамилия</label>
            <div class="col-lg-10">
                <input name="surname" type="text" class="form-control" id="surname" value="{{ $user->surname}}">

        </div>
        <div class="form-group">
            <label for="inputEmail" class="col-lg-2 control-label">E-mail</label>
            <div class="col-lg-10">
                <input name="email" type="email" class="form-control" id="inputEmail" value="{{ $user->email}}">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                <button type="submit" class="btn choice__button">Сохранить</button>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                <label for="userPicture">Добавьте аватарку</label>
                <input name="userPicture" type="file" id="userPicture">
            </div>
        </div>

    @if( $user->photos->first() )
        <div class="col-lg-10 col-lg-offset-2">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="thumbnail">
                        <img class="img-responsive" src="{{ $user->photos->first()->path ?? $placeholder }}" alt="...">
                        <div class="caption">
                            <p><a href="{{ route('deletePhoto',['id'=>$user->photos->first()->id])}}" class="btn btn-primary btn-xs" role="button">Delete</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    </fieldset>
    {{ csrf_field() }}
</form>
        <div>   @if( Auth::user()->hasRole(['admin']) )
                <li class="mb-3"><a href="{{ route('index') }}">Страница администратора</a></li>

            @endif </div>
    </div>
@endsection

