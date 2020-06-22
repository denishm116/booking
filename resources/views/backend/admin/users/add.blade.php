@extends('layouts.backend')

@section('content')
    <div class="container">
        <ul class="nav nav-tabs mb-3">

            <li class="nav-item"><a class="nav-link active" href="{{route('index')}}">Пользователи</a></li>

            <li class="nav-item"><a class="nav-link" href="#">Бронирования</a></li>

        </ul>

        @if( $user ?? false )
            <div class="row">
                <div class="col"><h3 class="">Редактировать пользователя</h3></div>


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
        @else
            <div class="row">
                <div class="col"><h3 class="">Добваить пользователя</h3></div>
            </div>

        @endif

        @if(Session::has('message'))
            <div class="alert alert-warning">{{Session::get('message')}}</div>
        @endif
        <form method="POST" action="{{ route('addUser', ['id' => $user->id ?? null]) }}">
            {{ csrf_field() }}

            <div class="form-group row">
                <label for="surname" class="col-md-4 col-form-label text-md-right">Фамилия</label>

                <div class="col-md-6">
                    <input id="surname" type="text"
                           class="form-control{{ $errors->has('surname') ? ' is-invalid' : '' }}" name="surname"
                           value="{{ $user->surname ?? ''}}" required>

                    @if ($errors->has('surname'))
                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('surname') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">Имя</label>

                <div class="col-md-6">
                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                           name="name" value="{{ $user->name ?? ''}}" required autofocus>

                    @if ($errors->has('name'))
                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>


            <div class="form-group row">
                <label for="patronymic" class="col-md-4 col-form-label text-md-right">Отчество</label>

                <div class="col-md-6">
                    <input id="patronymic" type="text"
                           class="form-control{{ $errors->has('patronymic') ? ' is-invalid' : '' }}" name="patronymic"
                           value="{{ $user->patronymic ?? ''}}">

                    @if ($errors->has('patronymic'))
                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('patronymic') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>


            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">адрес E-Mail</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                           name="email" value="{{ $user->email ?? ''}}" required>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Номер телефона') }}</label>

                <div class="col-md-6">
                    <input id="phone" type="phone" class="form-control @error('phone') is-invalid @enderror"
                           name="phone" value="{{ $user->phone ?? ''}}" required>

                    @if ($errors->has('phone'))
                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">Пароль</label>

                <div class="col-md-6">
                    <input id="password" type="password"
                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" disabled
                           name="password" required>

                    @if ($errors->has('password'))
                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>


            <div class="form-group row">
                <label for="role" class="col-md-4 col-form-label text-md-right">Роль</label>

                <div class="col-md-6">
                    <select size="3" multiple id="role" name="roles[]" class="select-roles">
                        @foreach ($roles as $role)
                            @if($user ?? false)
                            <option value="{{$role->id}}"
                            @foreach ($user->roles as $rol)
                            @if ($role->name == $rol->name)
                            selected
                                    @endif
                            @endforeach
                            >{{$role->name}}</option>
                                @else
                                <option value="{{$role->id}}">{{$role->name}}</option>
                            @endif
                        @endforeach
                        {{--@foreach($user->roles as $role)--}}
                            {{--<option value="{{$role->name}}">{{$role->name}}</option>--}}
                        {{--@endforeach--}}


                    </select>

                </div>
            </div>


            <div class="form-group row">
                <div class="col-4 ">

                </div>
                <div class="col-4 ">
                    <label for='sendMail'> Отправить письмо с паролем</label>
                   <input type="checkbox" name="sendmail" id="sendmail">
                </div>
                <div class="col-4 ">

                    <button type="submit" class="btn choice__button">
                        Сохранить
                    </button>
                </div>
            </div>
        </form>

    </div>

@endsection

