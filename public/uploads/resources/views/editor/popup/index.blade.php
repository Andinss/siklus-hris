@extends('layouts.editor.template')
@section('content')
<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header" style="margin-top: -10px; margin-bottom: -10px">
  <h1>
    <i class="fa fa-cog"></i> Popup
    <small>Popup</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Popup</a></li>
    <li class="active">Popup</li>
  </ol>
</section>

<section class="content">
{{ csrf_field() }}
  <div class="row">
    <div class="col-xs-3">
    </div>
    <div class="col-xs-6">
      <div class="box box-danger">
         <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Popup</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              @foreach($popup AS $popups)
              {{-- <div class="box-group" id="accordion{{$popups->id}}"> --}}
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                {{-- <div class="panel box box-primary"> --}}
                  {{-- <div class="box-header with-border"> --}}
                    <h4 class="box-title">
                        {{$popups->popup_name}}
                    </h4>
                    {{$popups->date_popup}}
                  </div>
                    <div class="box-body">
                       {!!$popups->description!!}
                       <hr>
                       @actionStart('userbranch', 'update')
                        <a href="{{ URL::route('editor.popup.edit', [$popups->id]) }}" class="btn btn-primary btn-xs btn-flat pull-right"> <i class="fa fa-pencil"></i> Edit</a>
                      @actionEnd
                    {{-- </div> --}}
                {{-- </div> --}}
              {{-- </div> --}}
              @endforeach
            </div>
            <!-- /.box-body -->
    </div>
  </div>
</section>
@stop
