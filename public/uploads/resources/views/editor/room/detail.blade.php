@extends('layouts.editor.template')
@section('content')

<section class="content box box-solid">
	<div class="row">
	    <div class="col-md-12 col-sm-12 col-xs-12">
	    	<div class="col-md-1"></div>
	    	<div class="col-md-5">
		        <div class="x_panel">
	                <h2>
	                	<i class="fa fa-users"></i> <i class="fa fa-search"></i> User Detail
	                	<a href="{{ URL::route('editor.user.edit', [$user->id]) }}" class="btn btn-default btn-sm pull-right"><i class="fa fa-pencil"></i> Edit</a>
                	</h2>
	                <hr>
		            <div class="x_content">
	                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
	                    	<div class="col-md-6 col-sm-6 col-xs-6">
	                    		<label>Profile Picture</label>
		                        @if($user->filename == null)
        							<br/><a class="fancybox" rel="group" href="{{Config::get('constants.path.uploads')}}/user/placeholder.png"><img src="{{Config::get('constants.path.uploads')}}/user/thumbnail/placeholder.png" class="img-thumbnail img-responsive" width="80%"/></a><br/>
        						@else
		        					<br/><a class="fancybox" rel="group" href="{{Config::get('constants.path.uploads')}}/user/{{$user->username}}/{{$user->filename}}"><img src="{{Config::get('constants.path.uploads')}}/user/{{$user->username}}/thumbnail/{{$user->filename}}" class="img-thumbnail img-responsive" width="80%"/></a>
		        					{!! Form::open(array('route' => ['editor.user.delete_image', $user->id], 'method' => 'PUT'))!!}
		        						<button type="submit"><i class="fa fa-trash"></i></button>
		        					{!! Form::close() !!}
		        					<br/>
		        				@endif
	                        </div>
	                        <div class="col-md-6 col-sm-6 col-xs-6">
	                        	<label for="username">Name</label>
		                        <p id="username">{{$user->username}}</p>
		                        <label for="email">E-mail</label>
		                        <p id="email">{{$user->email}}</p>
		                        <label for="full_name">Name</label>
		                        <p id="full_name">{{$user->first_name}} {{$user->last_name}}</p>
		                        <label for="role">Role</label>
		                        <p id="role">{{$user->user_role->role->name}}</p>
		                        <label for="date">Register</label>
		                        <p id="date">{{date("d-m-Y h:i:s", strtotime($user->created_at))}}</p>
	                        </div>
                    	</div>
		            </div>
		        </div>
	        </div>
	    </div>
	</div>
</section>

@stop
@section('scripts')
<!-- Add fancyBox -->
<link rel="stylesheet" href="{{Config::get('constants.path.plugin')}}/fancybox/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="{{Config::get('constants.path.plugin')}}/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox();
	});
</script>
@stop