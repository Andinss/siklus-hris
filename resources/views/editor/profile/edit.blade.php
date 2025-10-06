@extends('layouts.editor.template')
@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Profil</h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/') }}/editor"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="{{ url('/editor/profile') }}">Profil</a></li>
                        <li class="active">Edit</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="offset-md-4">
                    <div class="white-box">
                        <div class="box-body">
                            <div class="x_panel">
                                <hr>
                                <div class="x_content">
                                    {!! session()->get('msg') !!}
                                    @include('errors.error')
                                    {!! Form::open(['route' => 'editor.profile.update', 'method' => 'PUT', 'files' => 'true']) !!}
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <p id="username">{{ Auth::user()->username }}</p>

                                    </div>
                                    <div class="form-group">
                                        <label for="password">Sandi</label>
                                        <p><a href="{{ URL::route('editor.profile.edit_password') }}">Ganti Sandi</a></p>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">E-mail</label>
                                        <input type="email" class="form-control" name="email" id="email"
                                            value="{{ old('email', Auth::user()->email) }}" placeholder="E-mail address*"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="full_name">Nama</label>
                                        <input type="first_name" class="form-control" name="first_name" id="first_name"
                                            value="{{ old('first_name', Auth::user()->first_name) }}"
                                            placeholder="First name*" required><br>
                                        <input type="last_name" class="form-control" name="last_name" id="last_name"
                                            value="{{ old('last_name', Auth::user()->last_name) }}" placeholder="Last name"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Upload Foto Profil</label>
                                        <input type="file" name="image" id="image">
                                    </div>

                                    <button type="submit" class="btn btn-success mt-2 mb-2"><i class="fa fa-check"></i>
                                        Simpan</button>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
