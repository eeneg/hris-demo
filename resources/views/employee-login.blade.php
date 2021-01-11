{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
        <!-- Styles -->
        <style>
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height bg">
            {{-- @if (Route::has('login'))
            <div class="top-right links">
                @auth
                <a href="{{ url('/home') }}">Home</a>
                @else
                <a href="{{ route('login') }}">Login</a>
                @if (Route::has('register'))
                <a href="{{ route('register') }}">Register</a>
                @endif
                @endauth
            </div>
            @endif --}}
            <div class="login-box" >
                <!-- /.login-logo -->
                <div class="">
                    <div class="card-body login-card-body">
                        <div class="login-logo">
                            <img src="/storage/project_files/davsur.png" alt="logo" width="120px" height="120px">
                        </div>
                        <div class="title-container">
                            <p class="logo-title">Human Resource<br></p>
                            <span class="logo-title2">Information System</span>
                        </div>
                        <form class="form-signin" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-label-group">
                                <input id="emp_firstname" type="text" class="form-control input" name="firstname" placeholder="Firstname" required>
                                <span class="underline"></span>
                                <label class="text-muted label-input" for="emp_firstname">Firstname</label>
                            </div>
                            <div class="form-label-group">
                                <input id="emp_surname" type="text" class="form-control input" name="surname" placeholder="Surname" required>
                                <span class="underline"></span>
                                <label class="text-muted label-input" for="emp_surname">Surname</label>
                            </div>
                            <div class="form-label-group">
                                <input id="emp_ext" type="text" class="form-control input" name="nameextension" placeholder="Name extension" required>
                                <span class="underline"></span>
                                <label class="text-muted label-input" for="emp_ext">Name extension</label>
                            </div>
                            <div class="form-label-group">
                                <input id="emp_birthdate" type="text" class="form-control input" name="birthdate" placeholder="yyyy-mm-dd" 
                                onkeypress="return event.charCode > 47 && event.charCode < 58;" 
                                onkeydown="var date = this.value;
                                    if (window.event.keyCode == 8) {
                                        this.value = date;
                                    } else if (date.match(/^\d{4}$/) !== null) {
                                        this.value = date + '-';
                                    } else if (date.match(/^\d{4}\-\d{2}$/) !== null) {
                                        this.value = date + '-';
                                    }" 
                                maxlength="10" required>
                                <span class="underline"></span>
                                <label class="text-muted label-input" for="emp_birthdate">Birthdate (yyyy-mm-dd)</label>
                            </div>
                            <div class="form-label-group">
                                <input id="emp_barcode" type="password" class="form-control input" name="barcode" placeholder="Scan Barcode" required>
                                <span class="underline"></span>
                                <label class="text-muted label-input" for="emp_barcode">Scan Barcode</label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>