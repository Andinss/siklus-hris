@extends('layouts.editor.template')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Profil</h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/') }}/editor"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="{{ url('/editor/profile') }}">Profil</a></li>
                        <li class="active">Edit Password</li>
                    </ol>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="white-box">
                    <div class="box-body">
                        <div class="x_panel">
                            <hr>
                            @include('errors.error')
                            {!! Form::open(['route' => 'editor.profile.update_password', 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6">

                                    <label for="password_current">Current Password</label>
                                    <input type="password" class="form-control" name="password_current"
                                        id="password_current" required><br>

                                    <label for="password_new">New Password</label>
                                    <input type="password" class="form-control" name="password_new" id="password_new"
                                        required><br>

                                    <label for="password_new_confirmation">Confirm New Password</label>
                                    <input type="password" class="form-control" name="password_new_confirmation"
                                        id="password_new_confirmation" required><br>

                                    <button type="submit" class="btn btn-success pull-right btn-flat btn-lg btn-flat"><i
                                            class="fa fa-check"></i> Save</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
