@extends('layouts.editor.template')
@section('title')
  Action
@stop
@section('content')
<div id="page-wrapper">
  <div class="container-fluid">
      <div class="row bg-title">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">
              <i class="fa fa-plus"></i>
              <small>Action</small>
            </h4>

          </div>
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

            <ol class="breadcrumb">
              <li><a href="{{url('/')}}/editor"><i class="fa fa-dashboard"></i> Home</a></li>
              <li><a href="#">Auth</a></li>
              <li class="active">Action</li>
            </ol>

          </div>
          <!-- /.col-lg-12 -->
      </div>
      <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <div class="x_panel">
                              <div class="x_panel">
                                    <h2>
                                      @if(isset($action))
                                      <i class="fa fa-pencil"></i>
                                      @else
                                      <i class="fa fa-plus"></i>
                                      @endif
                                      &nbsp;Action
                                    </h2>
                                    <hr>
                                  <div class="x_content">
                                      @include('errors.error')

                                      @if(isset($action))
                                      {!! Form::model($action, array('route' => ['editor.action.update', $action->id], 'method' => 'PUT', 'files' => 'true'))!!}
                                        @else
                                        {!! Form::open(array('route' => 'editor.action.store', 'files' => 'true'))!!}
                                        @endif
                                        {{ csrf_field() }}
                                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                          {{ Form::label('name', 'Name') }}
                                          @if(isset($action))
                                          {{ Form::text('name', old('name'), ['class' => 'form-control', 'disabled' => 'true']) }}
                                          @else
                                          {{ Form::text('name', old('name'), ['class' => 'form-control']) }}
                                          @endif
                                          <br>

                                          {{ Form::label('description', 'Description') }}
                                          {{ Form::text('description', old('description'), ['class' => 'form-control']) }}
                                          <br>
                                          <div class="form-actions">
                                              <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Save</button>
                                              <a href="{{ URL::route('editor.action.index') }}" type="button" class="btn btn-default">Cancel</a>
                                        </div>
                                          {!! Form::close() !!}
                                  </div>
                              </div>
                        </div>
                      </div>

                    </div>
                </div>
            </div>

        </div>

    </div>

  </div>
</div>

@stop
