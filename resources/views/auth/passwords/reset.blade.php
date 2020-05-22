@extends('layouts.layout')
@section('title', 'Сброс пароля')

@section('description', 'Сброс пароля krim-leto.ru' )
@section('content')
<div class="container">
    <div class="row  justify-content-center parent">
        {{--<div class="row">--}}
        <div class="col-md-8 my-3 ml-0">
            <h1 class="about__title">Сброс пароля</h1>
            <div class="col-xl-4 line"></div>
        </div>

    </div>
    <div class="row justify-content-center block">
        <div class="col-md-8  shadow-lg pt-5 center-block">

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Новый пароль</label>
{{--                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>--}}

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Подтвердите новый пароль</label>
                            {{--<label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>--}}

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    ИЗМЕНИТЬ ПАРОЛЬ
{{--                                    {{ __('Reset Password') }}--}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    </div></div>
@endsection
