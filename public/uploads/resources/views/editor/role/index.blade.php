@extends('layouts.editor.template')
@section('content')

<section class="content box box-solid">
	<div class="row">
	    <div class="col-md-12 col-sm-12 col-xs-12">
	    	<div class="col-md-1"></div>
	    	<div class="col-md-10">
		        <div class="x_panel">
	                <h2>
	                	<i class="fa fa-user-secret"></i> Role List
	                	<a href="{{ URL::route('editor.role.create') }}" class="btn btn-default btn-lg pull-right"><i class="fa fa-plus"></i> Add</a>
                	</h2>
	                <hr>
		            <div class="x_content">
		                <table id="roleTable" class="table table-striped dataTable">
						  	<thead>
						  	  	<tr>
							      	<th>#</th>
							      	<th>Role</th>
							      	<th>User Count</th>
							      	<th></th>
						    	</tr>
						  	</thead>
						  	<tbody>
						    @foreach($roles as $key => $role)
						    	<tr>
						      		<td>{{$key+1}}</td>
							      	<td>{{$role->name}}</td>
							      	<td>{{$role->user_role->count()}}</td>
							      	<td align="center">
							      		<div class="col-md-2 nopadding">
							      			<a href="{{ URL::route('editor.role.detail', [$role->id]) }}" class="btn btn-default btn-sm"><i class="fa fa-search"></i></a>
							      		</div>
						      			<div class="col-md-2 nopadding">
							      			{!! Form::open(array('route' => ['editor.role.delete', $role->id], 'method' => 'delete'))!!}
	                    					{{ csrf_field() }}	                    				
							      			<button type="submit" class="btn btn-default btn-sm"><i class="fa fa-trash"></i></a>
							      			{!! Form::close() !!}
						      			</div>
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