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
                        <p class="login-box-msg" style="font-size: 1rem"><b> Human Resource</b> Information System</p>
                  
                        <form class="form-signin" method="POST" action="{{ route('login') }}">
                          @csrf
                          <div class="form-label-group">
                            <input type="email" id="inputEmail" class="form-control input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email address" required autofocus>
                            <span class="underline"></span>
                            <label for="inputEmail">{{ __('E-mail Address') }}</label>
                              @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                          </div>
            
                          <div class="form-label-group">
                            <input type="password" id="inputPassword" class="form-control input @error('password') is-invalid @enderror" name="password" placeholder="Password" required>
                            <span class="underline"></span>
                            <label for="inputPassword">{{ __('Password') }}</label>
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
                          <div>
                          <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">{{ __('Sign in') }}</button>
                          @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
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
