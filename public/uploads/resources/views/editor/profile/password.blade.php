@extends('layouts.editor.template')
@section('content')
<section class="content-header hidden-xs">
  	<h1 style="margin-top: -20px">
    	CMS
    	<small>Content Management System</small>
  	</h1>
  	<ol class="breadcrumb">
    	<li><a href="{{ URL::route('editor.index') }}"><i class="fa fa-home"></i> Home</a></li>
    	<li class="active"><i class="fa fa-vcard"></i> User List</li>
  	</ol>
</section>
<section class="content">
	<section class="content box mobile box-solid">
		<div class="row">
		    <div class="col-md-12 col-sm-12 col-xs-12"> 
		        <div class="x_panel">
					<hr>
					@include('errors.error')
					{!! Form::open(array('route' => 'editor.profile.update_password', 'method' => 'PUT', 'class' => 'form-horizontal'))!!}
					{{ csrf_field() }}
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-6">

							<label for="password_current">Current Password</label>
							<input type="password" class="form-control" name="password_current" id="password_current" required><br>

							<label for="password_new">New Password</label>
							<input type="password" class="form-control" name="password_new" id="password_new" required><br>

							<label for="password_new_confirmation">Confirm New Password</label>
							<input type="password" class="form-control" name="password_new_confirmation" id="password_new_confirmation" required><br>

							<button type="submit" class="btn btn-success pull-right btn-flat btn-lg btn-flat"><i class="fa fa-check"></i> Save</button>
						</div>
					</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</section>
</section> 
@stop