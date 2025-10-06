@extends('layouts.auth.template')

@section('content')
<div class="register-logo">
    <a href="{{url('/')}}"><b>Asset</b> Management System</a>
</div>
<!-- /.register-logo -->
<div class="register-box-body">
    <p class="login-box-msg">Register a new membership</p>

    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
        {{ csrf_field() }}
        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
            <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Username" required autofocus>

            @if ($errors->has('username'))
                <span class="help-block">
                    <strong>{{ $errors->first('username') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-mail Address" required autofocus>

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <input type="hidden" name="role_id" value="1">

        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
            <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" placeholder="First Name" required autofocus>

            @if ($errors->has('first_name'))
                <span class="help-block">
                    <strong>{{ $errors->first('first_name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
            <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name" required autofocus>

            @if ($errors->has('last_name'))
                <span class="help-block">
                    <strong>{{ $errors->first('last_name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>

            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>

            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif
        </div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label class="">
                    <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div> I agree to the <a href="#">terms</a>
                    </label>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
            </div>
            <!-- /.col -->
        </div>
    </form>
    <hr>
    Already have an account? <a href="{{url('/')}}/login" class="text-center">Sign in here</a>
</div>
<!-- /.form-box -->
@stop
