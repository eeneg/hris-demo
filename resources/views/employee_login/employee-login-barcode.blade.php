@extends('employee_login.index')

@section('content')
<div class="flex-center position-ref full-height bg">
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
                <div class="errors text-center">
                    @if($errors->first('barcode'))
                        <h4 class="text-danger">{{$errors->first('barcode')}}</h4>
                    @endif
                </div>
                <form class="form-signin" method="POST" action="{{ route('employee_login_barcode') }}">
                    @csrf
                    <div class="form-label-group">
                        <input id="emp_barcode" type="password" class="form-control input @error('barcode') is-invalid @enderror" name="barcode" placeholder="Scan Barcode" autofocus required>
                        <span class="underline"></span>
                        <label class="text-muted label-input" for="emp_barcode">Input Barcode</label>
                        @error('barcode')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ __('Login') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

