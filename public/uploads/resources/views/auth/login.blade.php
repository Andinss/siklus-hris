@extends('layouts.auth.template')
@section('content')
	<!-- Preloader -->
	<div class="preloader">
		<svg class="circular" viewBox="25 25 50 50">
			<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
		</svg>
	</div>
	<section id="wrapper" class="login-register">
		<div class="login-box login-sidebar">
			<div class="white-box">
				<form class="form-horizontal form-material" role="form" method="POST" id="loginform"
					action="{{ url('/login') }}">
					{{ csrf_field() }}
					<a href="javascript:void(0)" class="text-center db"><img
							src="{{ Config::get('constants.path.plugin') }}/images/eliteadmin-logo-dark.png" alt="Home" />
						<br /><img src="{{ Config::get('constants.path.plugin') }}/images/eliteadmin-text-dark.png" alt="Home" /></a>
					<div class="form-group m-t-40">
						<div class="col-xs-12">
							<input class="form-control" type="email" required="" name="username" placeholder="Username">
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-12">
							<input class="form-control" type="password" required="" name="password" placeholder="Password">
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-12">
							<div class="checkbox checkbox-primary pull-left p-t-0">
								<input id="checkbox-signup" type="checkbox">
								<label for="checkbox-signup"> Ingat saya </label>
							</div>
							<a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Lupa
								Password?</a>
						</div>
					</div>
					<div class="form-group text-center m-t-20">
						<div class="col-xs-12">
							<button class="btn btn-warning btn-lg btn-block text-uppercase waves-effect waves-light"
								type="submit">Masuk</button>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 m-t-10 text-center">
							<div class="social">
								<a href="javascript:void(0)" class="btn  btn-facebook" data-toggle="tooltip" title="Login with Facebook"> <i
										aria-hidden="true" class="fa fa-facebook"></i> </a>
								<a href="javascript:void(0)" class="btn btn-googleplus" data-toggle="tooltip" title="Login with Google"> <i
										aria-hidden="true" class="fa fa-google-plus"></i> </a>
							</div>
						</div>
					</div>
					<div class="form-group m-b-0">
						<div class="col-sm-12 text-center">
							<p>2014-2018 &copy; PT. JAFELMIA MULTI ARTHA</p>
						</div>
					</div>
				</form>
				<form class="form-horizontal" id="recoverform" action="index.html">
					<div class="form-group ">
						<div class="col-xs-12">
							<h3>Recover Password</h3>
							<p class="text-muted">Enter your Email and instructions will be sent to you! </p>
						</div>
					</div>
					<div class="form-group ">
						<div class="col-xs-12">
							<input class="form-control" type="text" required="" placeholder="Email">
						</div>
					</div>
					<div class="form-group text-center m-t-20">
						<div class="col-xs-12">
							<button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light"
								type="submit">Reset</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</section>
@stop
