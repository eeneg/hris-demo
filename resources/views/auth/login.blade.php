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
      <title>HRIS - Davao del Sur</title>
      <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/project_files/ddsICON.ico') }}" />
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
                        <input type="email" id="inputEmail" class="form-control input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email address" required autofocus>
                        <span class="underline"></span>
                        <label class="text-muted label-input" for="inputEmail">{{ __('E-mail Address') }}</label>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                     <div class="form-label-group">
                        <input type="password" id="inputPassword" class="form-control input @error('password') is-invalid @enderror" name="password" placeholder="Password" required>
                        <span class="underline"></span>
                        <label class="text-muted label-input" for="inputPassword">{{ __('Password') }}</label>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                     <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="remember">{{ __('Remember Me') }}</label>
                     </div>
                     <div class="text-center">
                        <button class="btn btn-lg btn-primary btn-block text-uppercase mb-1" type="submit">{{ __('Sign in') }}</button>
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password') }}
                        </a>
                        @endif
                        <br>
                        <a href="{{ route('step-one') }}">
                        Sign in as Employee
                        </a>
                     </div>
                  </form>
                  <!-- /.social-auth-links -->
               </div>
               <!-- /.login-card-body -->
            </div>
         </div>
      </div>
      <!-- REQUIRED SCRIPTS -->
      <script src="{{ asset('js/app.js') }}"></script>
   </body>
</html>
