@extends('layouts.mobileauth.template')
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
		            	<strong class="pull-right" style="color:green"> {!! session()->get('error') !!} </strong>
			            @include('errors.error')  
		                {!! Form::model($profile, array('route' => ['editor.profile.updatemobile', $profile->customer_id], 'method' => 'PUT', 'files' => 'true'))!!}

	                    {{ csrf_field() }}
	                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
	                        <label for="username">Username</label>
	                        <p id="username">{{$profile->username}}</p> 

	                        <label for="email">No HP</label>
		                    <div class="input-group">
                              <div class="input-group-addon">
                                +62
                              </div>
		                        <input type="telf1" class="form-control" name="telf1" id="telf1" value="{{ old('telf1', $profile->telf1) }}" placeholder="No HP*" required>
		                    </div><br> 
			                
	                        <label for="first_name">First Name</label>  
			                <input type="text" class="form-control" name="first_name" id="first_name" value="{{ old('first_name', $profile->first_name) }}" placeholder="First name*" required><br> 

	                        <label for="last_name">Last Name</label> 
			                <input type="text" class="form-control" name="last_name" id="last_name" value="{{ old('last_name', $profile->last_name) }}" placeholder="Last name" required><br>  
		                         

	                        <label for="image">Upload Picture</label>
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