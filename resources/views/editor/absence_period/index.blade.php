@extends('layouts.editor.template')
@section('module', 'Setting')
@section('title', 'Periode Absensi')
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
                                    'back_button' => true,
                                    'info_button' => false,
                                ])
                                <hr>
                                <div class="table-responsive">
                                    <table id="dtTable" class="display nowrap" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th rowspan="2">Aksi</th>
                                                <th rowspan="2">Periode Absensi</th>
                                                <th colspan="2">
                                                    <center>Tanggal Periode</center>
                                                </th>
                                                <th rowspan="2">Status</th>
                                            </tr>
                                            <tr>
                                                <th>Dari Tanggal</th>
                                                <th>Sampai Tanggal</th>
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
                        <h4 class="modal-title">Form Periode Absensi</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-body">
                            <div class="w-100 row">
                                <div class="col-sm-12 mb-4">
                                    <div class="row">
                                        <label class="control-label col-md-4 pull-left">Nama</label>
                                        <div class="col-md-8">
                                            <input name="absence_group_name" id="absence_group_name" class="form-control"
                                                type="text">
                                            <small class="@yield('required') hidden alert-danger"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-4">
                                    <div class="row">
                                        <label class="control-label col-md-4 pull-left">Hari Kerja *</label>
                                        <div class="col-md-8">
                                            <input name="day_in" id="day_in" class="form-control" type="text">
                                            <small class="errorPayperiodName hidden alert-danger"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-4">
                                    <div class="row">
                                        <label class="control-label col-md-4 pull-left">Dari Tanggal *</label>
                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                {{ Form::date('begin_date', old('begin_date'), ['class' => 'form-control', 'placeholder' => 'Dari Tanggal *', 'required' => 'true', 'id' => 'begin_date', 'onchange' => 'updateWorkingDays()']) }}
                                            </div><!-- /.input group -->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <label class="control-label col-md-4 pull-left">Sampai Tanggal *</label>
                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                {{ Form::date('end_date', old('end_date'), ['class' => 'form-control', 'placeholder' => 'Sampai Tanggal *', 'required' => 'true', 'id' => 'end_date', 'onchange' => 'updateWorkingDays()']) }}
                                            </div>
                                        </div>
                                    </div>
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
        var data = [{
                "id": "1",
                "absence_group_name": "Grup Kohicha 1",
                "period_from": "01-01-2024",
                "period_to": "31-01-2024",
                "status": 0
            },
            {
                "id": "2",
                "absence_group_name": "Grup Kohicha 2",
                "period_from": "01-01-2024",
                "period_to": "31-01-2024",
                "status": 0
            }
        ];
        $(document).ready(function() {
            //datatables
            table = $('#dtTable').DataTable({
                processing: true,
                serverSide: true,
                fixedColumns: {
                    leftColumns: 4
                },
                "initComplete": function(settings, json) {
                    $("#dtTable").wrap(
                        "<div style='overflow:auto; width:100%;position:relative;'></div>");
                },
                //  dom: 'Bfrtip',
                //  buttons: [
                //       'copy', 'excel', 'print'
                //  ],
                //    data: data,
                ajax: "{{ URL::route('editor.absence-period.data') }}",
                columns: [{
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'absence_group_name',
                        name: 'absence_group_name'
                    },
                    {
                        data: 'begin_date',
                        name: 'begin_date'
                    },
                    {
                        data: 'end_date',
                        name: 'end_date'
                    },
                    {
                        data: 'status',
                        render: function(data, type, row) {
                            let output = '<span class="label label-success"> Aktif </span>';
                            if (row.status == 0) {
                                return output;
                            } else {
                                return output =
                                    '<span class="label label-danger"> Tidak Aktif </span>';
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
            // $('.modal-title').text('Add Periode Absensi'); // Set Title to Bootstrap modal title
        }

        // Fungsi untuk menghitung hari kerja (Senin-Jumat)
        function countWorkingDays(startDate, endDate) {
            const start = new Date(startDate);
            const end = new Date(endDate);
            let count = 0;

            while (start <= end) {
                const day = start.getDay(); // Mendapatkan hari (0 = Minggu, 1 = Senin, ..., 6 = Sabtu)
                if (day >= 1 && day <= 5) { // Hanya menghitung Senin-Jumat
                    count++;
                }
                start.setDate(start.getDate() + 1); // Geser ke hari berikutnya
            }
            return count;
        }

        // Fungsi untuk memperbarui input day_in
        function updateWorkingDays() {
            const beginDate = document.getElementById('begin_date').value;
            const endDate = document.getElementById('end_date').value;

            if (beginDate && endDate) {
                const workingDays = countWorkingDays(beginDate, endDate);
                document.getElementById('day_in').value = workingDays;
            }
        }

        // Event listener untuk memicu perhitungan saat input berubah
        document.getElementById('begin_date').addEventListener('change', updateWorkingDays);
        document.getElementById('end_date').addEventListener('change', updateWorkingDays);

        function save() {
            $("#btnSave").prop("disabled", true);
            $("#btnSaveAdd").prop("disabled", true);
            var url;
            url = "{{ URL::route('editor.absence-period.store') }}";

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    '_token': $('input[name=_token]').val(),
                    'absence_group_name': $('#absence_group_name').val(),
                    'day_in': $('#day_in').val(),
                    'begin_date': $('#begin_date').val(),
                    'end_date': $('#end_date').val(),
                    'status': $('#status').val()
                },
                success: function(data) {

                    $('.@yield('required')').addClass('hidden');

                    if ((data.errors)) {
                        var options = {
                            "positionClass": "toast-bottom-right",
                            "timeOut": 1000,
                        };
                        toastr.error('Data is required!', 'Error Validation', options);
                        $("#btnSave").prop("disabled", false);
                        $("#btnSaveAdd").prop("disabled", false);

                        if (data.errors.absence_group_name) {
                            $('.@yield('required')').removeClass('hidden');
                            $('.@yield('required')').text(data.errors.absence_group_name);
                        }
                    } else {

                        var options = {
                            "positionClass": "toast-bottom-right",
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
                url: "{{ URL::route('editor.absence-period.store') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'absence_group_name': $('#absence_group_name').val(),
                    'day_in': $('#day_in').val(),
                    'begin_date': $('#begin_date').val(),
                    'end_date': $('#end_date').val(),
                    'status': $('#status').val()
                },
                success: function(data) {
                    $('.@yield('required')').addClass('hidden');

                    if ((data.errors)) {
                        var options = {
                            "positionClass": "toast-bottom-right",
                            "timeOut": 1000,
                        };
                        toastr.error('Data is required!', 'Error Validation', options);
                        $("#btnSave").prop("disabled", false);
                        $("#btnSaveAdd").prop("disabled", false);

                        if (data.errors.absence_group_name) {
                            $('.@yield('required')').removeClass('hidden');
                            $('.@yield('required')').text(data.errors.absence_group_name);
                        }
                    } else {
                        var options = {
                            "positionClass": "toast-bottom-right",
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
                url: 'shift-group/edit/' + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {

                    $('[name="id_key"]').val(data.id);
                    $('[name="absence_group_name"]').val(data.absence_group_name);
                    $('[name="status"]').val(data.status);
                    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Edit Periode Absensi'); // Set title to Bootstrap modal title
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
                url: 'shift-group/edit/' + id,
                type: "PUT",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'absence_group_name': $('#absence_group_name').val(),
                    'status': $('#status').val()
                },
                success: function(data) {
                    $('.@yield('required')').addClass('hidden');

                    if ((data.errors)) {
                        var options = {
                            "positionClass": "toast-bottom-right",
                            "timeOut": 1000,
                        };
                        toastr.error('Data is required!', 'Error Validation', options);

                        $("#btnSave").prop("disabled", false);
                        $("#btnSaveAdd").prop("disabled", false);

                        if (data.errors.absence_group_name) {
                            $('.@yield('required')').removeClass('hidden');
                            $('.@yield('required')').text(data.errors.absence_group_name);
                        }
                    } else {
                        var options = {
                            "positionClass": "toast-bottom-right",
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
                url: 'shift-group/edit/' + id,
                type: "PUT",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'absence_group_name': $('#absence_group_name').val(),
                    'status': $('#status').val()
                },
                success: function(data) {
                    if ((data.errors)) {
                        swal("Error!", "Gat data failed!", "error")
                    } else {
                        var options = {
                            "positionClass": "toast-bottom-right",
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

        function delete_id(id, absence_period_name) {
            var absence_period_name = absence_period_name.bold();

            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure to delete ' + absence_period_name + ' data?',
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
                                url: 'absence-period/delete/' + id,
                                type: "DELETE",
                                data: {
                                    '_token': $('input[name=_token]').val()
                                },
                                success: function(data) {
                                    var options = {
                                        "positionClass": "toast-bottom-right",
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
                    "positionClass": "toast-bottom-right",
                    "timeOut": 1000,
                };
                toastr.warning('Click button save please!', 'Warning', options);
                return false;

            }
        });
    </script>
@stop
