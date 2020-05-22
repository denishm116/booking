@extends('layouts.layout')

@section('content')
    <div class="container">
        <div class="row  justify-content-center parent">
            {{--<div class="row">--}}
            <div class="col-md-8 my-3 ml-0">
                <h2 class="about__title">Подтверждение номера телефона</h2>
                <div class="col-xl-4 line"></div>
            </div>

        </div>
        <div class="row justify-content-center block">


            <div class="col-md-8  shadow-lg mb-5 pt-5">
                <div class="col font-weight-bold text-center mb-3">
                    {{ __('Пожалуйста, введите код, пришедший вам на телефон, для активации аккаунта') }}
                </div>

                @if(Session::has('message'))
                    <div class="alert alert-danger">{{Session::get('message')}}</div>
                @endif
                <form method="POST" action="{{ route('verify') }}">
                    @csrf


                    <div class="form-group row">
                        <label for="code" class="col-md-4 col-form-label text-md-right">{{ __('Код') }}</label>

                        <div class="col-md-6">
                            <input id="code" type="number" class="form-control{{$errors->has('code')}}"
                                   name="code" required>

                            @if ($errors->has('code'))
                                <span class="invalid-feedback">
                                            <strong>{{$errors->first('code')}}</strong>
                                        </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mt-5">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn choice__button">
                                {{ __('Подтвердить') }}
                            </button>
                        </div>

                    </div>

                </form>

                <div class="row">
                    <div class="col text-right m-3">
                <a href="{{route('requestNewCode')}}">Запросить новый код </a>
                <input type="hidden" name="phone" value="{{request()->phone}}">
                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection
