@extends('layouts.editor.template')
@section('content')

<section class="content box box-solid">
	<div class="row">
	    <div class="col-md-12 col-sm-12 col-xs-12">
	    	<div class="col-md-1"></div>
	    	<div class="col-md-5">
		        <div class="x_panel">
	                <h2>
	                	@if(isset($role))
	                	<i class="fa fa-pencil"></i>
	                	@else
	                	<i class="fa fa-plus"></i> 
	                	@endif
	                	<i class="fa fa-user-secret"></i> Role
                	</h2>
	                <hr>
		            <div class="x_content">
		                @include('errors.error')
                        @if(isset($role))
		                {!! Form::model($role, array('route' => ['editor.role.update', $role->id], 'method' => 'PUT'))!!}
	                    @else
	                    {!! Form::open(array('route' => 'editor.role.store'))!!}
	                    @endif
	                    {{ csrf_field() }}
	                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
	                    	{{ Form::label('name', 'Name') }}
	                        {{ Form::text('name', old('name'), array('class' => 'form-control', 'placeholder' => 'Name*', 'required' => 'true')) }}<br/>

                            <button type="submit" class="btn btn-success pull-right" onclick="this.disabled=true; this.form.submit();"><i class="fa fa-check"></i> Save</button>
                    	</div>
                        {!! Form::close() !!}
		            </div>
		        </div>
	        </div>
	    </div>
	</div>
</section>

@stop