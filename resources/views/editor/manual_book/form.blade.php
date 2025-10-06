@extends('layouts.editor.template')
@if (isset($manual_book))
    @section('title', 'Edit Buku Manual')
@else
    @section('title', 'Tambah Buku Manual')
@endif
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">
                        @if (isset($manual_book))
                            Edit
                        @else
                            Tambah
                        @endif Buku Manual
                    </h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/editor') }}">Dashboard</a></li>
                        <li class="active">
                            @if (isset($manual_book))
                                Edit
                            @else
                                Tambah
                            @endif Buku Manual
                        </li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-wrapper collapse in" aria-expanded="true">
                            <div class="panel-body">
                                @if (isset($manual_book))
                                    {!! Form::model($manual_book, [
                                        'route' => ['editor.manual-book.update', $manual_book->id],
                                        'method' => 'PUT',
                                        'files' => 'true',
                                    ]) !!}
                                @else
                                    {!! Form::open(['route' => 'editor.manual-book.store', 'files' => 'true']) !!}
                                @endif
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <div class="row">
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {{ Form::label('manual_book_name', 'Judul *', ['class' => 'control-label']) }}
                                                {{ Form::text('manual_book_name', old('manual_book_name'), ['class' => 'form-control', 'placeholder' => 'Judul', 'id' => 'manual_book_name']) }}
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {{ Form::label('module_name', 'Module *', ['class' => 'control-label']) }}
                                                {{ Form::select('module_name', $module_list, old('module_name'), ['class' => 'form-control', 'placeholder' => 'Pilih Modul', 'id' => 'module_name', 'required' => 'true']) }}
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {{ Form::label('content', 'Konten', ['class' => 'control-label']) }}
                                                <textarea id="content" name="content"> 
                                              @if (isset($manual_book))
{{ $manual_book->content }}
@endif 
                                            </textarea>
                                            </div>
                                        </div>
                                        <!--/span-->
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i>
                                        Simpan</button>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('scripts')
    <script src="https://cdn.ckeditor.com/4.9.2/standard/ckeditor.js"></script>
    <script>
        $(function() {
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace('content', {
                height: 800
            });
            //bootstrap WYSIHTML5 - text editor
        });
    </script>
@stop
