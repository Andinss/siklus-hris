@extends('layouts.editor.template')
@section('title', 'Periode Gaji')
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row align-items-center bg-title">
                <div class="col-sm-6 col-xs-12">
                    <h4 class="page-title">@yield('title')</h4>
                </div>
                <div class="col-md-6 col-xs-12">
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
                                                <th rowspan="2">Nama Periode</th>
                                                <th rowspan="2">Hari Kerja</th>
                                                <th colspan="2">
                                                    <center>Tanggal Periode</center>
                                                </th>
                                                <th rowspan="2">Tanggal Dibayar</th>
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
                        <h4 class="modal-title">Form Departemen</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-body">
                            <div class="col-lg-12" class="col-md-12" class="col-sm-12">
                                <label class="control-label col-md-4 pull-left">Nama Periode *</label>
                                <div class="col-md-8">
                                    <input name="description" id="description" class="form-control" type="text">
                                    <small class="errorPayperiodName hidden alert-danger"></small>
                                </div>
                            </div>
                            <div class="col-lg-12" class="col-md-12" class="col-sm-12">
                                <label class="control-label col-md-4 pull-left">Hari Kerja *</label>
                                <div class="col-md-8">
                                    <input name="day_in" id="day_in" class="form-control" type="text">
                                    <small class="errorPayperiodName hidden alert-danger"></small>
                                </div>
                            </div><br><br><br>
                            <div class="col-lg-12" class="col-md-12" class="col-sm-12">
                                <label class="control-label col-md-4 pull-left">Dari Tanggal *</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        {{ Form::text('begin_date', old('begin_date'), ['class' => 'form-control', 'placeholder' => 'Dari Tanggal *', 'required' => 'true', 'id' => 'begin_date', 'onclick' => 'saveheader();']) }}
                                    </div><!-- /.input group -->
                                </div>
                            </div><br><br><br>
                            <div class="col-lg-12" class="col-md-12" class="col-sm-12">
                                <label class="control-label col-md-4 pull-left">Sampai Tanggal *</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        {{ Form::text('end_date', old('end_date'), ['class' => 'form-control', 'placeholder' => 'Sampai Tanggal *', 'required' => 'true', 'id' => 'end_date', 'onclick' => 'saveheader();']) }}
                                    </div>
                                </div>
                            </div><br><br><br>
                            <div class="col-lg-12" class="col-md-12" class="col-sm-12">
                                <label class="control-label col-md-4 pull-left">Tanggal Dibayar *</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        {{ Form::text('pay_date', old('pay_date'), ['class' => 'form-control', 'placeholder' => 'Tanggal Dibayar *', 'required' => 'true', 'id' => 'pay_date', 'onclick' => 'saveheader();']) }}
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
                        <button type="button" id="btnSave" class="btn btn-primary pull-right"
                            style="margin-left: 5px"> <i class="fa fa-save"></i> Simpan & Tutup</button>
                        <button type="button" id="btnSaveAdd" onClick="saveadd()" class="btn btn-primary pull-right">
                            <i class="fa fa-plus-square"></i> Simpan & Tambah</button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Bootstrap modal -->
@stop
@section('scripts')
    <script src="{{ asset('assets/plugins') }}/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript">
        jQuery('.mydatepicker, #begin_date').datepicker();
        jQuery('.mydatepicker, #end_date').datepicker();
        jQuery('.mydatepicker, #pay_date').datepicker();

        $('#begin_date').datepicker({
            format: 'dd-mm-yyyy'
        });
        $('#end_date').datepicker({
            format: 'dd-mm-yyyy'
        });
        $('#pay_date').datepicker({
            format: 'dd-mm-yyyy'
        });
    </script>
    <script>
        var table;
        $(document).ready(function() {
            //datatables
            table = $('#dtTable').DataTable({
                processing: true,
                serverSide: true,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'print'
                ],
                ajax: "{{ url('editor/period/data') }}",
                columns: [{
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'day_in',
                        name: 'day_in'
                    },
                    {
                        data: 'begin_date',
                        name: 'begin_date',
                        render: function(d) {
                            return moment(d).format("DD-MM-YYYY");
                        }
                    },
                    {
                        data: 'end_date',
                        name: 'end_date',
                        render: function(d) {
                            return moment(d).format("DD-MM-YYYY");
                        }
                    },
                    {
                        data: 'pay_date',
                        name: 'pay_date',
                        render: function(d) {
                            return moment(d).format("DD-MM-YYYY");
                        }
                    },
                    {
                        data: 'status',
                        render: function(data, type, row) {
                            let output = '<span class="label label-success"> Aktif </span>';
                            if (row.status == 0) {
                                return output;
                            } else {
                                output = '<span class="label label-danger"> Tidak Aktif </span>';
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

            $('.errorPayperiodName').addClass('hidden');

            save_method = 'add';
            $('#form')[0].reset(); // reset form on modals 
        }

        function save() {
            var url;
            url = "{{ URL::route('editor.period.store') }}";

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    '_token': $('input[name=_token]').val(),
                    'description': $('#description').val(),
                    'day_in': $('#day_in').val(),
                    'begin_date': $('#begin_date').val(),
                    'end_date': $('#end_date').val(),
                    'pay_date': $('#pay_date').val(),
                    'status': $('#status').val()
                },
                success: function(data) {

                    $('.errorPayperiodName').addClass('hidden');

                    if ((data.errors)) {
                        var options = {
                            "positionClass": "toast-bottom-right",
                            "timeOut": 1000,
                        };
                        toastr.error('Data is required!', 'Error Validation', options);

                        if (data.errors.description) {
                            $('.errorPayperiodName').removeClass('hidden');
                            $('.errorPayperiodName').text(data.errors.description);
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
            $.ajax({
                type: 'POST',
                url: "{{ URL::route('editor.period.store') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'description': $('#description').val(),
                    'day_in': $('#day_in').val(),
                    'status': $('#status').val()
                },
                success: function(data) {
                    $('.errorPayperiodName').addClass('hidden');

                    if ((data.errors)) {
                        var options = {
                            "positionClass": "toast-bottom-right",
                            "timeOut": 1000,
                        };
                        toastr.error('Data is required!', 'Error Validation', options);

                        if (data.errors.description) {
                            $('.errorPayperiodName').removeClass('hidden');
                            $('.errorPayperiodName').text(data.errors.description);
                        }
                    } else {
                        var options = {
                            "positionClass": "toast-bottom-right",
                            "timeOut": 1000,
                        };
                        toastr.success('Successfully added data!', 'Success Alert', options);
                        $('#form')[0].reset(); // reset form on modals
                        reload_table();
                    }
                },
            })
        };

        function edit(id) {

            $('.errorPayperiodName').addClass('hidden');

            //alert("asdad");

            $("#btnSave").attr("onclick", "update(" + id + ")");

            $("#btnSaveAdd").attr("onclick", "updateadd(" + id + ")");

            save_method = 'update';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string

            //Ajax Load data from ajax
            $.ajax({
                url: 'period/edit/' + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {

                    $('[name="id_key"]').val(data.id);
                    $('[name="description"]').val(data.description);
                    $('[name="day_in"]').val(data.day_in);
                    $('[name="date_period"]').val(data.date_period);
                    $('[name="begin_date"]').val(data.begin_date);
                    $('[name="end_date"]').val(data.end_date);
                    $('[name="pay_date"]').val(data.pay_date);
                    $('[name="month"]').val(data.month);
                    $('[name="year"]').val(data.year);
                    $('[name="status"]').val(data.status);
                    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Edit Payperiod'); // Set title to Bootstrap modal title
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        }

        function update(id) {
            save_method = 'update';
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string

            //Ajax Load data from ajax
            $.ajax({
                url: 'period/edit/' + id,
                type: "PUT",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'description': $('#description').val(),
                    'day_in': $('#day_in').val(),
                    'date_period': $('#date_period').val(),
                    'begin_date': $('#begin_date').val(),
                    'end_date': $('#end_date').val(),
                    'pay_date': $('#pay_date').val(),
                    'status': $('#status').val()
                },
                success: function(data) {
                    $('.errorPayperiodName').addClass('hidden');

                    if ((data.errors)) {
                        var options = {
                            "positionClass": "toast-bottom-right",
                            "timeOut": 1000,
                        };
                        toastr.error('Data is required!', 'Error Validation', options);

                        if (data.errors.description) {
                            $('.errorPayperiodName').removeClass('hidden');
                            $('.errorPayperiodName').text(data.errors.description);
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
            save_method = 'update';
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string

            //Ajax Load data from ajax
            $.ajax({
                url: 'period/edit/' + id,
                type: "PUT",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'description': $('#description').val(),
                    'day_in': $('#day_in').val(),
                    'date_period': $('#date_period').val(),
                    'begin_date': $('#begin_date').val(),
                    'end_date': $('#end_date').val(),
                    'pay_date': $('#pay_date').val(),
                    'pay_date': $('#pay_date').val(),
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
                    }
                },
            })
        };

        function delete_id(id, description) {
            //var varnamre= $('#description').val();
            var description = description.bold();
            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure to delete ' + description + ' data?',
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
                                url: 'period/delete/' + id,
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

        function bulk_delete() {
            var list_id = [];
            $(".data-check:checked").each(function() {
                list_id.push(this.value);
            });
            if (list_id.length > 0) {
                $.confirm({
                    title: 'Confirm!',
                    content: 'Are you sure to delete ' + list_id.length + ' data?',
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
                                    data: {
                                        '_token': $('input[name=_token]').val(),
                                        'idkey': list_id,
                                    },
                                    url: "period/deletebulk",
                                    type: "POST",
                                    dataType: "JSON",
                                    success: function(data) {
                                        if (data.status) {
                                            reload_table();
                                        } else {
                                            alert('Failed.');
                                        }

                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        $.alert({
                                            type: 'red',
                                            icon: 'fa fa-danger', // glyphicon glyphicon-heart
                                            title: 'Warning',
                                            content: 'Error deleting data!',
                                        });
                                    }
                                });
                            }
                        },

                    }
                });
            } else {
                $.alert({
                    type: 'orange',
                    icon: 'fa fa-warning', // glyphicon glyphicon-heart
                    title: 'Warning',
                    content: 'No data selected!',
                });
            }
        }
    </script>
@stop
