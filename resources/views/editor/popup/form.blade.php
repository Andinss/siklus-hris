@extends('layouts.editor.templatefaq')
@section('content')
    <section class="content-header" style="margin-top: -10px; margin-bottom: -10px">
        <h1>
            <i class="fa fa-question"></i> Popup
            <small>Popup</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}/editor"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Popup</a></li>
            <li class="active">Popup</li>
        </ol>
    </section>
    @actionStart('popup', 'create|update')
    <section class="content">
        <div class="col-md-8 col-sm-8 col-xs-8">
            <section class="content box box-solid">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-1"></div>
                        <div class="col-md-12">
                            <div class="x_panel">
                                <h2>
                                    @if (isset($popup))
                                        <i class="fa fa-pencil"></i>
                                    @else
                                        <i class="fa fa-plus"></i>
                                    @endif
                                    &nbsp;Popup
                                </h2>
                                <hr>
                                <div class="x_content">
                                    @include('errors.error')

                                    @if (isset($popup))
                                        {!! Form::model($popup, ['route' => ['editor.popup.update', $popup->id], 'method' => 'PUT', 'files' => 'true']) !!}
                                    @else
                                        {!! Form::open(['route' => 'editor.popup.store', 'files' => 'true']) !!}
                                    @endif
                                    {{ csrf_field() }}
                                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                        {{ Form::label('popup_name', 'Popup Name') }}
                                        {{ Form::text('popup_name', old('popup_name'), ['class' => 'form-control']) }}
                                        <br>

                                        {{ Form::label('description', 'Content') }}
                                        <textarea id="editor1" name="description" rows="10" cols="80">
@if (isset($popup))
{{ $popup->description }}
@endif
</textarea>
                                        <br>
                                        <br>

                                        <div class="form-group">
                                            {{ Form::label('description', 'Date') }}
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input name="date" id="date" class="form-control" type="text">
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-success pull-right"><i
                                                class="fa fa-check"></i> Save</button>
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
