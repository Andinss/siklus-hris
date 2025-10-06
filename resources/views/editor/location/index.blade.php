@extends('layouts.editor.template')
@section('module', 'Seting')
@section('title', 'Lokasi')
@section('required', 'errorEmployeeStatusName')
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row align-items-center bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h6 class="page-title">@yield('title')</h6>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                        <li><a href="#">@yield('module')</a></li>
                        <li class="active">@yield('title')</li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <!-- /row -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <div class="col-sm-12">
                            <div class="white-box">
                                @include('layouts.editor.template_button_master', [
                                    'add_action' => 'default',
                                    'back_button' => false,
                                    'info_button' => false,
                                ])
                                <hr>
                                <div class="table-responsive">
                                    <table id="dtTable" class="display nowrap" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Aksi</th>
                                                <th>Nama Lokasi</th>
                                                <th>Longitude</th>
                                                <th>Latitude</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('popup')
    <!-- Bootstrap modal -->
    <div class="modal fade" id="modal_form" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" style="width:40% !important">
            <div class="modal-content">
                <form action="#" id="form" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <div class="form-group pull-right">
                            <label for="real_name" class="control-label">Status</label>
                            <div class="col-sm-8 pull-right">
                                <select class="form-control" name="status" id="status">
                                    <option value="0">Aktif</option>
                                    <option value="1">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                        <h4 class="modal-title">Form Lokasi</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-body">
                            <div class="col-lg-12" class="col-md-12" class="col-sm-12">
                                <label class="control-label col-md-4 pull-left">Nama Lokasi</label>
                                <div class="col-md-8">
                                    <input name="location_name" id="location_name" class="form-control" type="text">
                                    <small class="@yield('required') hidden alert-danger"></small>
                                </div>
                            </div>
                            <div class="col-lg-12" class="col-md-12" class="col-sm-12">
                                <label class="control-label col-md-4 pull-left">Longitude</label>
                                <div class="col-md-8">
                                    <input name="longitude" id="longitude" class="form-control" type="text">
                                </div>
                            </div><br>
                            <div class="col-lg-12" class="col-md-12" class="col-sm-12">
                                <label class="control-label col-md-4 pull-left">Latitude</label>
                                <div class="col-md-8">
                                    <input name="latitude" id="latitude" class="form-control" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                </form><br>
                <div class="modal-footer">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i
                                class="fa fa-close"></i> Tutup</button>
                        <button type="button" id="btnSave" class="btn btn-primary pull-right" style="margin-left: 5px">
                            <i class="fa fa-save"></i> Simpan & Tutup</button>
                        <button type="button" id="btnSaveAdd" onClick="saveadd()" class="btn btn-primary pull-right"> <i
                                class="fa fa-plus-square"></i> Simpan & Tambah</button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Bootstrap modal -->
@stop
@section('scripts')
    <script>
        var table;
        $(document).ready(function() {
            //datatables
            table = $('#dtTable').DataTable({
                processing: true,
                serverSide: true,
                fixedColumns: {
                    leftColumns: 4
                },
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'print'
                ],
                ajax: "{{ URL::route('editor.location.data') }}",
                columns: [{
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'location_name',
                        name: 'location_name'
                    },
                    {
                        data: 'longitude',
                        name: 'longitude'
                    },
                    {
                        data: 'latitude',
                        name: 'latitude'
                    },
                    {
                        data: 'status',
                        render: function(data, type, row) {
                            let output = '<span class="label label-success"> Active </span>';
                            if (row.status == 0) {
                                return output;
                            } else {
                                output = '<span class="label label-danger"> Not Active </span>';
                                return output;
                            }
                        }
                    }
                ]
            });
        });

        function reload_table() {
            table.ajax.reload(null, false); //reload datatable ajax 
        }

        function add() {
            $("#btnSave").attr("onclick", "save()");
            $("#btnSaveAdd").attr("onclick", "saveadd()");

            $("#btnSave").prop("disabled", false);
            $("#btnSaveAdd").prop("disabled", false);

            $('.@yield('required')').addClass('hidden');

            save_method = 'add';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string

            // $('#modal_form').modal('show'); // show bootstrap modal
            // $('#modal_form').modal('toggle');
            // $('.modal-title').text('Add Position'); // Set Title to Bootstrap modal title
        }

        function save() {
            $("#btnSave").prop("disabled", true);
            $("#btnSaveAdd").prop("disabled", true);
            var url;
            url = "{{ URL::route('editor.location.store') }}";

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    '_token': $('input[name=_token]').val(),
                    'location_name': $('#location_name').val(),
                    'longitude': $('#longitude').val(),
                    'latitude': $('#latitude').val(),
                    'status': $('#status').val()
                },
                success: function(data) {

                    $('.@yield('required')').addClass('hidden');

                    if ((data.errors)) {
                        var options = {
                            "locationClass": "toast-bottom-right",
                            "timeOut": 1000,
                        };
                        toastr.error('Data is required!', 'Error Validation', options);
                        $("#btnSave").prop("disabled", false);
                        $("#btnSaveAdd").prop("disabled", false);

                        if (data.errors.location_name) {
                            $('.@yield('required')').removeClass('hidden');
                            $('.@yield('required')').text(data.errors.location_name);
                        }
                    } else {

                        var options = {
                            "locationClass": "toast-bottom-right",
                            "timeOut": 1000,
                        };
                        toastr.success('Successfully added data!', 'Success Alert', options);
                        $('#modal_form').modal('hide');
                        $('#form')[0].reset(); // reset form on modals
                        reload_table();
                    }
                },
            })
        };

        function saveadd() {
            $("#btnSave").prop("disabled", true);
            $("#btnSaveAdd").prop("disabled", true);
            $.ajax({
                type: 'POST',
                url: "{{ URL::route('editor.location.store') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'location_name': $('#location_name').val(),
                    'longitude': $('#longitude').val(),
                    'latitude': $('#latitude').val(),
                    'status': $('#status').val()
                },
                success: function(data) {
                    $('.@yield('required')').addClass('hidden');

                    if ((data.errors)) {
                        var options = {
                            "locationClass": "toast-bottom-right",
                            "timeOut": 1000,
                        };
                        toastr.error('Data is required!', 'Error Validation', options);
                        $("#btnSave").prop("disabled", false);
                        $("#btnSaveAdd").prop("disabled", false);

                        if (data.errors.location_name) {
                            $('.@yield('required')').removeClass('hidden');
                            $('.@yield('required')').text(data.errors.location_name);
                        }
                    } else {
                        var options = {
                            "locationClass": "toast-bottom-right",
                            "timeOut": 1000,
                        };
                        toastr.success('Successfully added data!', 'Success Alert', options);
                        $('#form')[0].reset(); // reset form on modals
                        reload_table();
                        $("#btnSave").prop("disabled", true);
                        $("#btnSaveAdd").prop("disabled", true);
                    }
                },
            })
        };

        function edit(id) {

            $("#btnSave").prop("disabled", false);
            $("#btnSaveAdd").prop("disabled", false);

            $('.@yield('required')').addClass('hidden');

            $("#btnSave").attr("onclick", "update(" + id + ")");

            $("#btnSaveAdd").attr("onclick", "updateadd(" + id + ")");

            save_method = 'update';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string

            //Ajax Load data from ajax
            $.ajax({
                url: 'location/edit/' + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {

                    $('[name="id_key"]').val(data.id);
                    $('[name="location_name"]').val(data.location_name);
                    $('[name="status"]').val(data.status);
                    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Edit Position'); // Set title to Bootstrap modal title
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        }

        function update(id) {
            $("#btnSave").prop("disabled", true);
            $("#btnSaveAdd").prop("disabled", true);

            save_method = 'update';
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string

            //Ajax Load data from ajax
            $.ajax({
                url: 'location/edit/' + id,
                type: "PUT",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'location_name': $('#location_name').val(),
                    'longitude': $('#longitude').val(),
                    'latitude': $('#latitude').val(),
                    'status': $('#status').val()
                },
                success: function(data) {
                    $('.@yield('required')').addClass('hidden');

                    if ((data.errors)) {
                        var options = {
                            "locationClass": "toast-bottom-right",
                            "timeOut": 1000,
                        };
                        toastr.error('Data is required!', 'Error Validation', options);

                        $("#btnSave").prop("disabled", false);
                        $("#btnSaveAdd").prop("disabled", false);

                        if (data.errors.location_name) {
                            $('.@yield('required')').removeClass('hidden');
                            $('.@yield('required')').text(data.errors.location_name);
                        }
                    } else {
                        var options = {
                            "locationClass": "toast-bottom-right",
                            "timeOut": 1000,
                        };
                        toastr.success('Successfully updated data!', 'Success Alert', options);
                        $('#modal_form').modal('hide');
                        $('#form')[0].reset(); // reset form on modals
                        reload_table();
                    }
                },
            })
        };

        function updateadd(id) {
            $("#btnSave").prop("disabled", true);
            $("#btnSaveAdd").prop("disabled", true);

            save_method = 'update';
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string

            //Ajax Load data from ajax
            $.ajax({
                url: 'location/edit/' + id,
                type: "PUT",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'location_name': $('#location_name').val(),
                    'longitude': $('#longitude').val(),
                    'latitude': $('#latitude').val(),
                    'status': $('#status').val()
                },
                success: function(data) {
                    if ((data.errors)) {
                        swal("Error!", "Gat data failed!", "error")
                    } else {
                        var options = {
                            "locationClass": "toast-bottom-right",
                            "timeOut": 1000,
                        };
                        toastr.success('Successfully updated data!', 'Success Alert', options);
                        $('#form')[0].reset(); // reset form on modals
                        reload_table();
                        $("#btnSave").attr("onclick", "save()");
                        $("#btnSaveAdd").attr("onclick", "saveadd()");
                        $("#btnSave").prop("disabled", true);
                        $("#btnSaveAdd").prop("disabled", true);
                    }
                },
            })
        };

        function delete_id(id, location_name) {
            var location_name = location_name.bold();

            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure to delete ' + location_name + ' data?',
                type: 'red',
                typeAnimated: true,
                buttons: {
                    cancel: {
                        action: function() {}
                    },
                    confirm: {
                        text: 'DELETE',
                        btnClass: 'btn-red',
                        action: function() {
                            $.ajax({
                                url: 'location/delete/' + id,
                                type: "DELETE",
                                data: {
                                    '_token': $('input[name=_token]').val()
                                },
                                success: function(data) {
                                    var options = {
                                        "locationClass": "toast-bottom-right",
                                        "timeOut": 1000,
                                    };
                                    toastr.success('Successfully deleted data!', 'Success Alert',
                                        options);
                                    reload_table();
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    $.alert({
                                        type: 'red',
                                        icon: 'fa fa-danger', // glyphicon glyphicon-heart
                                        title: 'Warning',
                                        content: 'Error deleteing data!',
                                    });
                                }
                            });
                        }
                    },
                }
            });
        }

        $('#modal_form').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                var options = {
                    "locationClass": "toast-bottom-right",
                    "timeOut": 1000,
                };
                toastr.warning('Click button save please!', 'Warning', options);
                return false;

            }
        });
    </script>
@stop
