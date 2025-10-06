@extends('layouts.editor.template')
@section('content')
<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header" style="margin-top: -10px; margin-bottom: -10px">
  <h1>
    <i class="fa fa-bell"></i> Faq
    <small>Faq</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Faq</a></li>
    <li class="active">Faq</li>
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
              <h3 class="box-title">Faq</h3>
              @actionStart('userbranch', 'read')
                <a href="{{ URL::route('editor.faq.create') }}" class="btn btn-primary btn-xs btn-flat pull-right"> <i class="fa fa-sticky-note-o"></i> Add New</a>
              @actionEnd
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              @foreach($faq AS $faqs)
              <div class="box-group" id="accordion{{$faqs->id}}">
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                <div class="panel box box-primary">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion{{$faqs->id}}" href="#collapseOne{{$faqs->id}}">
                        {{$faqs->title}}
                      </a>
                    </h4>
                  </div>
                  <div id="collapseOne{{$faqs->id}}" class="panel-collapse collapse">
                    <div class="box-body">
                       {!!$faqs->content!!}
                       <hr>
                       @actionStart('userbranch', 'update')
                        <a href="{{ URL::route('editor.faq.edit', [$faqs->id]) }}" class="btn btn-primary btn-xs btn-flat pull-right"> <i class="fa fa-pencil"></i> Edit</a> 
                      @actionEnd
                      @actionStart('faq', 'delete')
                      {!! Form::open(array('route' => ['editor.faq.delete', $faqs->id], 'method' => 'delete'))!!}
                        {{ csrf_field() }}                              
                        <button type="submit" class="btn btn-danger btn-xs btn-flat pull-right"><i class="fa fa-trash"></i> Delete</a></button>
                        {!! Form::close() !!}
                      @actionEnd
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
            <!-- /.box-body -->
    </div>
  </div>
</section>  
@stop
