@extends('layouts.auth.template')
@section('content')
	<div class="auth-container">
		<div class="card card-login">
			<div class="card-body">
				<a href="/" class="text-center brand">
					<img src="{{ asset('uploads') }}/preference/{{ $preference->logo }}" alt="{{ $preference->logo }}" />
				</a>
				<p class="login-title">Masuk ke Portal</p>

				@include('errors.error')

				<form class="form-material" role="form" method="POST" id="loginform"
					action="{{ url('/login') }}">
					@csrf
					<div class="form-group">
						<label>Alamat surel</label>
						<input class="form-control" type="email" name="email" placeholder="admin@email.com" required />
					</div>
					<div class="form-group">
						<label>Kata sandi</label>
						<div class="custom-toggle-password">
							<input class="form-control" type="password" name="password" id="passField" placeholder="Kata sandi" required />
							<div class="btn-toggle-password" id="togglePassword" aria-hidden="false" aria-target="#passField">
								<span class="iconify closed" data-icon="ri:eye-off-line"></span>
								<span class="iconify open" data-icon="ri:eye-line"></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-6">
								<div class="checkbox checkbox-secondary">
									<input id="checkbox-signup" type="checkbox">
									<label for="checkbox-signup">
										<span class="iconify" data-icon="ri:check-fill"></span>
										Ingat saya
									</label>
								</div>
							</div>
							<div class="col-6 text-right">
								<a href="javascript:void(0)" class="button-forgot">
									<span class="iconify iconify-lg" data-icon="ri:rotate-lock-line"></span>
									Lupa Password?
								</a>
							</div>
							<div class="col-md-12">
								<div class="pt-5">
									<button class="btn btn-primary btn-lg text-uppercase w-100" type="submit">Masuk</button>
								</div>
							</div>
						</div>
					</div>
					<p class="pt-4 text-center">&copy;<span class="appCopyright"></span> - Siklus HRIS</p>
				</form>

				{{-- <form class="form-horizontal" id="recoverform" action="index.html">
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<h3>Recover Password</h3>
								<p class="text-muted">Enter your Email and instructions will be sent to you! </p>
							</div>
						</div>
						<div class="col-xs-12">
							<input class="form-control" type="text" required="" placeholder="Email">
						</div>
						<div class="col-xs-12 text-center">
							<button class="btn btn-primary btn-lg text-uppercase" type="submit">Reset</button>
						</div>
					</div>
				</form> --}}
			</div>
		</div>
	</div>
@stop
