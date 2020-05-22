
@extends('layouts.layout')
@section('title', 'Регистрация на сервисе krim-leto.ru')

@section('description', 'Регистрация на сервисе krim-leto.ru. ')

@section('content')
    <div class="container">
        <div class="row  justify-content-center parent">
            {{--<div class="row">--}}
                <div class="col-md-8 my-3 ml-0">
                    <h2 class="about__title">Регистрация</h2>
                    <div class="col-xl-4 line"></div>
                </div>

        </div>
<div class="row justify-content-center block">
            <div class="col-md-8  shadow-lg mb-5 pt-5">





                        @if(Session::has('message'))
                            <div class="alert alert-warning">{{Session::get('message')}}</div>
                        @endif

                        <form {{ $novalidate /* 36 */ }} method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}

                            <div class="form-group row">
                                <label for="surname" class="col-md-4 col-form-label text-md-right">Фамилия</label>

                                <div class="col-md-6">
                                    <input id="surname" type="text" class="form-control{{ $errors->has('surname') ? ' is-invalid' : '' }}" name="surname" value="{{ old('surname') }}" required>

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
                                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

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
                                    <input id="patronymic" type="text" class="form-control{{ $errors->has('patronymic') ? ' is-invalid' : '' }}" name="patronymic" value="{{ old('patronymic') }}" required autofocus>

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
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

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
                                    <input id="phone" type="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required>

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
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Подтвердите проль</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>



                            <div class="row mt-4 text-center align-content-center align-self-center">
                                <div class="col col-md-auto ">
                                    <div class="checkbox px-5">

                                            <input type="checkbox" name="owner" value="1">
                                        Зарегистрировать меня, как <b>арендодателя</b>. Я принимаю условия  <a href="landlord_agreement">договора на оказание возмездных услуг</a>.

                                    </div>
                                </div>
                            </div>


                            <div class="row mb-5 text-center">
                                <div class="col col-md-auto">
                                    <div class="checkbox px-5">

                                            <input type="checkbox" name="confirm" value="1">
                                        Зарегистрировать меня, как <b>гостя</b>. Я согласен на обработку моих персональных данных и <a href="guest_agreement">правила и условия для поездок</a>.

                                    </div>
                                </div>
                            </div>




                            <div class="form-group row mb-5">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn choice__button">
                                        Зарегистрироваться
                                    </button>
                                </div>
                            </div>
                        </form>

            </div>
    </div>
    </div>
@endsection

