@extends('layouts.editor.template')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">
                        <i class="fa fa-plus"></i> Hak Akses
                        <small>Pengguna</small>
                    </h4>

                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                    <ol class="breadcrumb">
                        <li><a href="{{ url('/') }}/editor"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">User Management</a></li>
                        <li class="active">Hak Akses</li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-wrapper collapse in" aria-expanded="true">
                            <div class="panel-body">

                                <div class="table-responsive">
                                    @include('errors.error')

                                    @if (isset($user))
                                        {!! Form::model($user, [
                                            'route' => ['editor.privilege.update', $user->id],
                                            'method' => 'PUT',
                                            'files' => 'true',
                                        ]) !!}
                                    @else
                                        {!! Form::open(['route' => 'editor.privilege.store', 'files' => 'true']) !!}
                                    @endif
                                    {{ csrf_field() }}
                                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                        {{ Form::label('user_id', 'Username') }}
                                        @if (isset($user))
                                            {{ Form::text('user_id', $user->username, ['class' => 'form-control', 'disabled' => 'true']) }}
                                        @else
                                            {{ Form::select('user_id', $username_list, old('user_id'), ['class' => 'form-control']) }}
                                        @endif
                                        <br>

                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th><i class="fa fa-gear"></i>|<i class="fa fa-wrench"></i></th>
                                                    @foreach ($action_list as $action_key => $action)
                                                        <th>{{ $action }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($module_list as $module_key => $module)
                                                    <tr>
                                                        <td>{{ $module }}</td>
                                                        @foreach ($action_list as $action_key => $action)
                                                            <td>{{ Form::checkbox('privilege[' . $module_key . '][' . $action_key . ']', 'checked', null, ['id' => 'privilege_' . $module_key . '_' . $action_key]) }}
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <button type="submit" class="btn btn-success pull-right"><i
                                                class="fa fa-check"></i> Simpan</button>
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
    @if (isset($user))
        <script>
            $.each({!! $user->privilege !!}, function(key, value) {
                let attributeLabel = `#privilege_${value['module_id']}_${value['action_id']}`
                $(attributeLabel).attr('checked', true)
            });
        </script>
    @endif
@stop
