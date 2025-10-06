@extends('layouts.editor.template')
@section('content')

<section class="content box box-solid">
	<div class="row">
	    <div class="col-md-12 col-sm-12 col-xs-12"> 
	    	<div class="col-md-5">
		        <div class="x_panel">
	                <h2>
	                	<i class="fa fa-user"></i> <i class="fa fa-pencil"></i> Edit Profile
                	</h2>
	                <hr>
		            <div class="x_content">

		            	{!! session()->get('msg') !!}
			            @include('errors.error')
			            {!! Form::open(array('route' => 'editor.profile.update', 'method' => 'PUT', 'files' => 'true'))!!}
	                    {{ csrf_field() }}
	                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
	                        <label for="username">Username</label>
	                        <p id="username">{{Auth::user()->username}}</p>

	                        <label for="password">Password</label>
	                        <p><a href="{{ URL::route('editor.profile.edit_password') }}">Change password</a></p>

	                        <label for="email">E-mail</label>
	                        <input type="email" class="form-control" name="email" id="email" value="{{ old('email', Auth::user()->email) }}" placeholder="E-mail address*" required><br>

	                        <label for="full_name">Name</label>
	                        <div id="full_name">
		                        <div class="col-md-6 col-sm-6 col-xs-6 form-group">
			                        <input type="first_name" class="form-control" name="first_name" id="first_name" value="{{ old('first_name', Auth::user()->first_name) }}" placeholder="First name*" required><br>
		                        </div>
		                        <div class="col-md-6 col-sm-6 col-xs-6 form-group">
			                        <input type="last_name" class="form-control" name="last_name" id="last_name" value="{{ old('last_name', Auth::user()->last_name) }}" placeholder="Last name" required><br>
		                        </div>
	                        </div>

	                        <label for="image">Upload Profile Picture</label>
	                        <input type="file" name="image" id="image">
	                        
                            <button type="submit" class="btn btn-success pull-right btn-lg btn-flat"><i class="fa fa-check"></i> Save</button>
                    	</div>
                        {!! Form::close() !!}
		            </div>
		        </div>
	        </div>
	    </div>
	</div>
</section>

@stop