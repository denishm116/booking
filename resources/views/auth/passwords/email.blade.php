@extends('layouts.layout')
@section('title', 'Сброс пароля')

@section('description', 'Сброс пароля krim-leto.ru' )
@section('content')
<div class="container">

    <div class="row  justify-content-center parent">
        {{--<div class="row">--}}
        <div class="col-md-8 my-3 ml-0">
            <h2 class="about__title">Сброс пароля</h2>
            <div class="col-xl-4 line"></div>
        </div>

    </div>
    <div class="row justify-content-center block">
        <div class="col-md-8  shadow-lg pt-5 center-block">


            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Введите ваш E-Mail') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn choice__button px-4 w-100">
                                {{ __('Отправить ссылку на сброс пароля') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>


        </div>
    </div>



</div>
@endsection


