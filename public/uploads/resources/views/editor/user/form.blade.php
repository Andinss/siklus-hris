@extends('layouts.editor.template')
@section('content')
<div id="page-wrapper">
  <div class="container-fluid">
      <div class="row bg-title">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">
              <i class="fa fa-user"></i> User
              <small>Auth</small>
            </h4>

          </div>
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

            <ol class="breadcrumb">
              <li><a href="{{url('/')}}/editor"><i class="fa fa-dashboard"></i> Home</a></li>
              <li><a href="#">Auth</a></li>
              <li class="active">User</li>
            </ol>

          </div>
          <!-- /.col-lg-12 -->
      </div>
      @actionStart('user', 'create|update')

      <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">


                      <div class="x_panel">
                            <h2>
                              @if(isset($user))
                              <i class="fa fa-pencil"></i>
                              @else
                              <i class="fa fa-plus"></i>
                              @endif
                              &nbsp;User
                            </h2>
                            <hr>
                          <div class="x_content">
                              @include('errors.error')

                              @if(isset($user))
                              {!! Form::model($user, array('route' => ['editor.user.update', $user->id], 'method' => 'PUT', 'files' => 'true'))!!}
                                @else
                                {!! Form::open(array('route' => 'editor.user.store', 'files' => 'true'))!!}
                                @endif
                                {{ csrf_field() }}
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                  {{ Form::label('username', 'Username') }}
                                  @if(isset($user))
                                  {{ Form::text('username', old('username'), ['class' => 'form-control', 'disabled' => 'true']) }}
                                  @else
                                  {{ Form::text('username', old('username'), ['class' => 'form-control']) }}
                                  @endif
                                  <br>

                                  {{ Form::label('password', 'Password') }}
                                  {{ Form::password('password', ['class' => 'form-control']) }}
                                  <br>

                                  {{ Form::label('password_confirmation', 'Confirm Password') }}
                                  {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
                                  <br>
                                  <div class="form-actions">
                                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                                    <a href="{{ URL::route('editor.user.index') }}" type="button" class="btn btn-default">Cancel</a>
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
@actionEnd
@stop
