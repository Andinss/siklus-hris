@extends('layouts.editor.template')
@section('module', 'Setting')
@section('title', 'Shift Group')
@section('required', 'errorEmployeeStatusName')
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">@yield('title')</h4>
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
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-wrapper collapse in" aria-expanded="true">
                            <div class="panel-body">
                                {!! Form::model($shift_group, [
                                    'route' => ['editor.shift-group.update', $shift_group->id],
                                    'method' => 'PUT',
                                    'files' => 'true',
                                    'id' => 'form_employee',
                                ]) !!}
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <section>
                                        <!-- Coloumn 1-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kode Group Shift</label>
                                                {{ Form::text('shift_group_code', old('shift_group_code'), ['class' => 'form-control', 'placeholder' => 'Kode Group Shift', 'required' => 'true']) }}
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Grup Shift</label>
                                                {{ Form::text('shift_group_name', old('shift_group_name'), ['class' => 'form-control', 'placeholder' => 'Nama Grup Shift', 'required' => 'true']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Hari Libur Tetap</label>
                                                <select class="form-control" name="default_holiday" id="default_holiday"
                                                    onchange="setholiday();">
                                                    @if (isset($shift_group->dafault_holiday))
                                                        <option value="{{ $shift_group->dafault_holiday }}">
                                                            @if ($shift_group->dafault_holiday == 1)
                                                                Ya
                                                            @else
                                                                Tidak
                                                            @endif
                                                        </option>
                                                    @endif
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" id="off_day">
                                                <label>Hari Libur</label> <br>
                                                <label class="checkbox-inline">
                                                    <input class="form-check-input" type="checkbox" id="off_friday"
                                                        name="off_friday[]" value="1"
                                                        @if ($shift_group->off_friday == 1) checked @endif> Jumat
                                                </label><br>
                                                <label class="checkbox-inline">
                                                    <input class="form-check-input" type="checkbox" id="off_saturday"
                                                        name="off_saturday[]" value="1"
                                                        @if ($shift_group->off_saturday == 1) checked @endif> Sabtu
                                                </label><br>
                                                <label class="checkbox-inline">
                                                    <input class="form-check-input" type="checkbox" id="off_sunday"
                                                        name="off_sunday[]" value="1"
                                                        @if ($shift_group->off_sunday == 1) checked @endif> Minggu
                                                </label>
                                            </div>
                                        </div>
                                </div>
                            </div><!-- /.box-header -->
                            <hr>
                            <div class="panel-body">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kode Shift</label>
                                        <select class="form-control" name="shift_id" id="shift_id">
                                            @foreach ($shift_list as $shift_lists)
                                                <option value="{{ $shift_lists->id }}"
                                                    @if ($shift_lists->absence_type_id == 9) style="background-color: #e06b6b" @endif>
                                                    {{ $shift_lists->shift_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Hari</label>
                                        <input type="number" value="" class="form-control" id="day"
                                            name="day">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Aksi</label><br />
                                        <a href="#" onclick="save_detail();" type="button"
                                            class="btn btn-primary btn-flat" style="margin-left: 2px; margin-right: 2px"> <i
                                                class="fa fa-plus"></i> Tambah</a>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <table id="dtTable" class="table table-bordered table-hover stripe">
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Kode Shift</th>
                                                <th>Keterangan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <hr>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="real_name" class="col-sm-3 control-label">Keterangan</label>
                                        <div class="col-sm-9">
                                            <textarea style="height: 40px !important" class="form-control" id="remark" name="remark" onchange="saveheader();"> {{ $shift_group->remark }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary pull-right btn-flat"><i
                                        class="fa fa-check"></i> Save</button>
                                <a href="{{ URL::route('editor.shift-group.index') }}" type="button"
                                    class="btn btn-default btn-flat pull-right" style="margin-left: 2px; margin-right: 2px">
                                    <i class="fa fa-close"></i> Close</a>&nbsp;
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
                        <h4 class="modal-title">Shift Group Form</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-body">
                            <div class="col-lg-12" class="col-md-12" class="col-sm-12">
                                <label class="control-label col-md-4 pull-left">Shift Group</label>
                                <div class="col-md-8">
                                    <input name="shift_group_name" id="shift_group_name" class="form-control"
                                        type="text">
                                    <small class="@yield('required') hidden alert-danger"></small>
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
    <script type="text/javascript">
        var table;
        $(document).ready(function() {
            //datatables
            setholiday();
            table = $('#dtTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('editor/shift-group/data-detail') }}/{{ $shift_group->id }}",
                "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    if (aData[1] == "1") {
                        $('td', nRow).css('background-color', 'red');
                    } else if (aData[0] == "4") {
                        $('td', nRow).css('background-color', 'Orange');
                    }
                },
                columns: [{
                        data: 'day',
                        name: 'day'
                    },
                    {
                        data: 'shift_name',
                        render: function(data, type, row) {
                            let lblShift = '<b style="color: red">' + row.shift_name + '</b>';
                            if (row.shift_name == 'OFF') {
                                return lblShift;
                            } else {
                                lblShift = row.shift_name;
                                return lblShift;
                            }
                        }
                    },
                    {
                        data: 'description',
                        render: function(data, type, row) {
                            let output = '<li> Start - End: ' + row.start_time + ' - ' + row
                                .end_time + ' </li> <li> Break: ' + row.start_break + ' - ' + row
                                .end_break + ' </li> <li> Absence Type: ' + row.absence_type_name +
                                ' </li>  <li> Grace for late: ' + row.grace_for_late +
                                ' Minute(s) </li>';
                            return output;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action'
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

            $('.errorMaterial UsedName').addClass('hidden');

            save_method = 'add';
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#modal_form').modal('show'); // show bootstrap modal
            $('.modal-title').text('Add Asset Request'); // Set Title to Bootstrap modal title
        }

        function reload_table_detail() {
            table_detail.ajax.reload(null, false); //reload datatable ajax 
        }


        function save_detail(id) {
            var shiift_id = $("#shiift_id").val();
            save_method = 'update';

            if (shiift_id == '') {
                var options = {
                    "positionClass": "toast-bottom-right",
                    "timeOut": 1000,
                };
                toastr.error('Shift data is required!', 'Error Validation', options);
            } else {
                //Ajax Load data from ajax
                $.ajax({
                    url: '../../shift-group/save-detail/{{ $shift_group->id }}',
                    type: "PUT",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'day': $('#day').val(),
                        'shift_id': $('#shift_id').val()
                    },
                    success: function(data) {


                        var options = {
                            "positionClass": "toast-bottom-right",
                            "timeOut": 1000,
                        };
                        toastr.success('Successfully add detail data!', 'Success Alert', options);

                        if ((data.errors)) {
                            toastr.error('Data is required!', 'Error Validation', options);
                        }
                        reload_table_detail();
                        reload_table();

                        $('#shift_id').val(''),
                            $('#day').val('')

                    },

                })
            }
        };

        function delete_id(id, employeename) {
            var employeename = employeename.bold();

            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure to delete data?',
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
                                url: '../../shift-group/delete-detail/' + id,
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

        function setholiday() {
            var default_holiday = $("#default_holiday").val();
            var off_day = $("#shiift_id").val(0);
            if (default_holiday == 1) {
                $("#off_day").show(100);
            } else {
                $("#off_day").hide(200);
                $('#off_sunday').prop('checked', false); // Unchecks it
                $('#off_saturday').prop('checked', false); // Unchecks it
            }
        };
    </script>
@stop
