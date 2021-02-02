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
                    <form class="form-signin" method="POST" action="{{ route('employee_login') }}">
                        @csrf
                        <div class="form-label-group">
                            <input id="emp_firstname" type="text" class="form-control input @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}" placeholder="Firstname" >
                            <span class="underline"></span>
                            <label class="text-muted label-input" for="emp_firstname">Firstname</label>
                            @error('firstname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-label-group">
                            <input id="emp_surname" type="text" class="form-control input @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname') }}" placeholder="Surname" >
                            <span class="underline"></span>
                            <label class="text-muted label-input" for="emp_surname">Surname</label>
                            @error('surname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-label-group">
                            <input id="emp_ext" type="text" class="form-control input @error('nameextension') is-invalid @enderror" name="nameextension" value="{{ old('nameextension') }}" placeholder="Name extension" >
                            <span class="underline"></span>
                            <label class="text-muted label-input" for="emp_ext">Name extension</label>
                            @error('nameextension')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-label-group">
                            <input id="emp_birthdate" type="text" class="form-control input @error('birthdate') is-invalid @enderror" name="birthdate" value="{{ old('birthdate') }}" placeholder="yyyy-mm-dd"
                            onkeypress="return event.charCode > 47 && event.charCode < 58;"
                            onkeydown="var date = this.value;
                                if (window.event.keyCode == 8) {
                                    this.value = date;
                                } else if (date.match(/^\d{4}$/) !== null) {
                                    this.value = date + '-';
                                } else if (date.match(/^\d{4}\-\d{2}$/) !== null) {
                                    this.value = date + '-';
                                }"
                            maxlength="10" >
                            <span class="underline"></span>
                            <label class="text-muted label-input" for="emp_birthdate">Birthdate (yyyy-mm-dd)</label>
                            @error('birthdate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-lg btn-primary btn-block text-uppercase mb-1">Next</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

