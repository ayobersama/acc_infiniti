@extends('layouts.app')
@section('content')
<script>
        function toggle_password_user() {
            var x = document.getElementById("password1");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        } 
</script>
    <div class="sec-login">
        <div class="login"> 
            <div class="panel text-center">
                <div>
                    <img src="{{ asset('images/logo_login.png')}}" width="100%;">
                </div>
                <hr style="border-width:2px">
                <h4 class="mb-3 text-left">Login</h4>
                <form action="{{url('admin/login')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text color-sc2"><i class="fa fa-user"></i></span>
                            </div>
                            <input type="text" id="username" name="username" class="form-control" placeholder="Username"
                                aria-label="email" aria-describedby="basic-addon1" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text color-sc2"><i class="fa fa-lock"></i></span>
                            </div>
                            <input type="password" name="password" id="password1" class="form-control" placeholder="password"
                                aria-label="password" aria-describedby="basic-addon1" autocomplete="off">
                                <a href="javascript:void(0)" class="input-group-text" style="background:#fff" onclick="toggle_password_user()"><i class="fa fa-eye"></i></a>
                        </div>
                    </div>               
                    @if (\Session::has('error'))
                          <div class="text-center" style="color:red">
                          {{ \Session::get('error') }}
                          </div>
                    @endif     
                    <button class="btn btn-lg btn-std mt-2 w-100" type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>
@endsection    
    