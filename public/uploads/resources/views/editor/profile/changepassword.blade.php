@extends('layouts.auth.template')
@section('content')

<div class="login-box-body">
	<h2>
		<i class="fa fa-user"></i> <i class="fa fa-pencil"></i> Edit Password
	</h2>
	<hr>
	@include('errors.error')
	{!! Form::open(array('route' => 'editor.profile.update_password', 'method' => 'PUT', 'class' => 'form-horizontal'))!!}
	{{ csrf_field() }}
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">

			<label for="password_current">Current Password</label>
			<input type="password" class="form-control" name="password_current" id="password_current" required><br>

			<label for="password_new">New Password</label>
			<input type="password" class="form-control" name="password_new" id="password_new" required><br>

			<label for="password_new_confirmation">Confirm New Password</label>
			<input type="password" class="form-control" name="password_new_confirmation" id="password_new_confirmation" required><br>

			<button type="submit" class="btn btn-success pull-right btn-flat"><i class="fa fa-check"></i> Save</button>
		</div>
	</div>
	{!! Form::close() !!}
</div>
@stop