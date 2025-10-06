@extends('layouts.editor.template')
@section('content')

<section class="content box box-solid">
	<div class="row">
	    <div class="col-md-12 col-sm-12 col-xs-12">
	    	<div class="col-md-1"></div>
	    	<div class="col-md-5">
		        <div class="x_panel">
	                <h2>
	                	<i class="fa fa-users"></i> <i class="fa fa-pencil"></i> Edit Password
                	</h2>
	                <hr>
		            <div class="x_content">
			            @include('errors.error')
			            {!! Form::open(array('route' => ['editor.user.update_password', $user->id], 'method' => 'PUT'))!!}
	                    {{ csrf_field() }}
	                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
	                    	<label for="username">Username</label>
	                    	<p id="username">{{$user->username}}</p>

	                        <label for="password_new">New Password</label>
	                        <input type="password" class="form-control" name="password_new" id="password_new" required><br>

	                        <label for="password_new_confirmation">Confirm New Password</label>
	                        <input type="password" class="form-control" name="password_new_confirmation" id="password_new_confirmation" required><br>

                            <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check"></i> Save</button>
                    	</div>
                        {!! Form::close() !!}
		            </div>
		        </div>
	        </div>
	    </div>
	</div>
</section>

@stop