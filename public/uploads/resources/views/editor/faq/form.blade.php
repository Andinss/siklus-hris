@extends('layouts.editor.templatefaq')
@section('content')
<section class="content-header" style="margin-top: -10px; margin-bottom: -10px">
  <h1>
    <i class="fa fa-question"></i> Faq
    <small>Faq</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{url('/')}}/editor"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Faq</a></li>
    <li class="active">Faq</li>
  </ol>
</section>
@actionStart('faq', 'create|update')
<section class="content">
	<div class="col-md-8 col-sm-8 col-xs-8"> 
		<section class="content box box-solid">
			<div class="row">
			    <div class="col-md-12 col-sm-12 col-xs-12">
			    	<div class="col-md-1"></div>
			    	<div class="col-md-12">
			        <div class="x_panel">
		                <h2>
		                	@if(isset($faq))
		                	<i class="fa fa-pencil"></i>
		                	@else
		                	<i class="fa fa-plus"></i>
		                	@endif
		                	&nbsp;Faq
	                	</h2>
		                <hr>
			            <div class="x_content">
			                @include('errors.error')

			                @if(isset($faq))
			                {!! Form::model($faq, array('route' => ['editor.faq.update', $faq->id], 'method' => 'PUT', 'files' => 'true'))!!}
		                    @else
		                    {!! Form::open(array('route' => 'editor.faq.store', 'files' => 'true'))!!}
		                    @endif
		                    {{ csrf_field() }}
		                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
		                    	{{ Form::label('title', 'Title') }} 
		                    	{{ Form::text('title', old('title'), ['class' => 'form-control']) }}
		                    	<br>

		                    	{{ Form::label('content', 'Content') }}
		                    	<textarea id="editor1" name="content" rows="10" cols="80">@if(isset($faq)) {{$faq->content}} @endif</textarea>
		                    	<br>
		                    	<br>

	                            <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check"></i> Save</button>
	                    	</div>
	                        {!! Form::close() !!}
				        </div>
			        </div>
			    </div>
			</div>
		</section>
	</div>
</section>
@actionEnd
@stop





