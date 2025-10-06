 
@extends('layouts.editor.template')
@section('content')
<!-- Main content -->
<section class="content">
	<div class="row">
		<!-- <div class="col-xs-2">
	</div> -->
	<div class="col-xs-8">
		<div class="box box-danger">
			@include('errors.error')
			@if(isset($room))
			{!! Form::model($room, array('route' => ['editor.room.update', $room->id], 'method' => 'PUT', 'class'=>'update', 'files' => 'true', 'id'=>'form_room'))!!}
			@else
			{!! Form::open(array('route' => 'editor.room.store', 'class'=>'create', 'files' => 'true', 'id'=>'form_room'))!!}
			@endif
			{{ csrf_field() }}
			<div class="box-header with-border">
				<section class="content-header" style="margin-top:-25px !important; margin-bottom:-10px !important; margin-left: -15px !important">
					<h4>
						@if(isset($module))
						<i class="fa fa-pencil"></i> Edit
						@else
						<i class="fa fa-plus"></i> 
						@endif
						Room
					</h4>
				</section>
			</div>
			<div class="box-header with-border">
				<div class="row">
					<div class="col-md-8">
						<div class="form-group">
							{{ Form::label('roomname', 'Room Name') }}
							{{ Form::text('roomname', old('roomname'), array('class' => 'form-control', 'placeholder' => 'Room Name*', 'required' => 'true', 'id' => 'roomname')) }}<br/> 
						</div>
					</div>
					<div class="col-md-8">
						<div class="form-group">
							{{ Form::label('image', 'Image') }}
							{{ Form::file('image') }}<br/>
						</div>
					</div>
				</div>
			</div>
			<div class="box-header with-border">
				<div class="col-md-12">
					<div class="form-group">
						<button type="submit" class="btn btn-success pull-right"><i class="fa fa-check"></i> Save</button>
						<a href="{{ URL::route('editor.room.index') }}" class="btn btn-default pull-right" style="margin-right: 10px"><i class="fa fa-close"></i> Close</a>
					</div>
				</div>
			</div>
		</section><!-- /.content -->
	</div>
</div>
</section>
@stop

