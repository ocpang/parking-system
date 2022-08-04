@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('auth_header', __('adminlte::adminlte.verify_message'))

@section('auth_body')

    @if(session('resent'))
        <div class="alert alert-success" role="alert">
            {{ __('adminlte::adminlte.verify_email_sent') }}
        </div>
    @endif

    {{ __('adminlte::adminlte.verify_check_your_email') }}
    {{ __('adminlte::adminlte.verify_if_not_recieved') }},

    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
        @csrf
        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
            {{ __('adminlte::adminlte.verify_request_another') }}
        </button>.
    </form>

    <hr/>
    
    <form class="" method="POST" action="{{ route('email-verify') }}">
        @csrf

        <div class="form-group">
            <label for="email_token" class="">{{ __('Your Token') }}</label>

            <div class="">
                <input id="email_token" type="text" class="form-control @error('email_token') is-invalid @enderror" name="email_token" value="{{ old('email_token') }}" required autocomplete="email_token" autofocus>

                @error('email_token')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="">
            <button type="submit" class="btn btn-block btn-dark">{{ __('Submit') }}</button>
        </div>
    </form>
@stop
