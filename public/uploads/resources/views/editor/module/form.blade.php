@extends('layouts.editor.template')
@section('content')
<div id="page-wrapper">
  <div class="container-fluid">
      <div class="row bg-title">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">
              <i class="fa fa-plus"></i> Modul
              <small>User</small>
            </h4>

          </div>
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

            <ol class="breadcrumb">
              <li><a href="{{url('/')}}/editor"><i class="fa fa-dashboard"></i> Home</a></li>
              <li><a href="#">Auth</a></li>
              <li class="active">Modul</li>
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
                              <h2>
                                @if(isset($module))
                                <i class="fa fa-pencil"></i>
                                @else
                                <i class="fa fa-plus"></i>
                                @endif
                                &nbsp;Modul
                              </h2>
                              <hr>
                            <div class="x_content">
                              @include('errors.error')

                              @if(isset($module))
                              {!! Form::model($module, array('route' => ['editor.module.update', $module->id], 'method' => 'PUT', 'files' => 'true'))!!}
                                @else
                                {!! Form::open(array('route' => 'editor.module.store', 'files' => 'true'))!!}
                                @endif
                                {{ csrf_field() }}
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                  {{ Form::label('name', 'Nama Modul') }}
                                  @if(isset($module))
                                  {{ Form::text('name', old('name'), ['class' => 'form-control', 'disabled' => 'true']) }}
                                  @else
                                  {{ Form::text('name', old('name'), ['class' => 'form-control']) }}
                                  @endif
                                  <br>

                                  {{ Form::label('description', 'Keterangan') }}
                                  {{ Form::text('description', old('description'), ['class' => 'form-control']) }}
                                  <br>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Simpan</button>
                                    <a href="{{ URL::route('editor.module.index') }}" type="button" class="btn btn-default">Tutup</a>
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

@stop
