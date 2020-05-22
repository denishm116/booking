@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Проверьте ваш E-mail, который был указан при регистрации') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('На ваш E-mail отправлена ссылка для подтверждения.') }}
                        </div>
                    @endif

                    {{ __('Прежде чем продолжить, проверьте свою электронную почту на наличие ссылки для подтверждения.') }}
                    {{ __('Если вы не получили письмо') }}, <a href="{{ route('verification.resend') }}">{{ __('нажмите здесь, для повторной отправки письма с кодом подтверждения') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
