@extends('layouts.editor.template')
@section('content')

<section class="content box box-solid">
	<div class="row">
	    <div class="col-md-12 col-sm-12 col-xs-12">
	    	<div class="col-md-1"></div>
	    	<div class="col-md-10">
		        <div class="x_panel">
	                <h2>
	                	<i class="fa fa-user-secret"></i> Role List <i class="fa fa-caret-right"></i> {{$role->name}}
                	</h2>
	                <hr>
		            <div class="x_content">
		                <table id="roleTable" class="table table-striped dataTable">
						  	<thead>
						  	  	<tr>
							      	<th>#</th>
							      	<th>ID</th>
							      	<th>Name</th>
							      	<th>E-mail</th>
							      	<th>Name</th>
							      	<th>Register Date</th>
							      	<th>Action</th>
						    	</tr>
						  	</thead>
						  	<tbody>
						    @foreach($role->user_role as $key => $user_role)
						    	<tr>
						      		<td>{{$key+1}}</td>
						      		<td>{{$user_role->user->id}}</td>
							      	<td>{{$user_role->user->username}}</td>
							      	<td>{{$user_role->user->email}}</td>
							      	<td>{{$user_role->user->first_name}} {{$user_role->user->last_name}}</td>
							      	<td>{{date("d-m-Y h:i:s", strtotime($user_role->user->created_at))}}</td>
							      	<td align="center">
							      		<a href="{{ URL::route('editor.user.detail', [$user_role->user->id]) }}" class="btn btn-default btn-sm"><i class="fa fa-search"></i></a>
							      		<a href="{{ URL::route('editor.user.edit', [$user_role->user->id]) }}" class="btn btn-default btn-sm"><i class="fa fa-pencil"></i></a>
							      		<a href="{{ URL::route('editor.user.delete', [$user_role->user->id]) }}" class="btn btn-default btn-sm"><i class="fa fa-trash"></i></a>
						      		</td>
							    </tr>
						    @endforeach
							</tbody>
						</table>
		            </div>
		        </div>
	        </div>
	    </div>
	</div>
</section>

@stop
@section('scripts')
<script src="{{Config::get('constants.path.plugin')}}/datatables/jquery.dataTables.min.js"></script> 
<script src="{{Config::get('constants.path.plugin')}}/datatables/dataTables.bootstrap.min.js"></script>
<script>
  $(document).ready(function () {
    $("#roleTable").DataTable();
    });
</script>
@stop