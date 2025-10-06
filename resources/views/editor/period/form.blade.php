@extends('layouts.editor.template')
@section('module', 'Setting')
@section('title', 'Shift Group')
@section('required', 'errorEmployeeStatusName')
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
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-wrapper collapse in" aria-expanded="true">
                            <div class="panel-body">
                                {!! Form::model($period, [
                                    'route' => ['editor.period.save-detail', $period->id],
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
                                                <label>Periode</label>
                                                {{ Form::text('description', old('description'), ['class' => 'form-control', 'disabled' => 'disabled']) }}
                                            </div>
                                        </div>
                                </div>
                            </div><!-- /.box-header -->
                            <hr>
                            <div class="panel-body">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Grup Shift</label>
                                        <select class="form-control" name="shift_group_id" id="shift_group_id">
                                            @foreach ($shift_group_list as $shift_group_lists)
                                                <option value="{{ $shift_group_lists->id }}"
                                                    @if ($shift_group_lists->absence_type_id == 9) style="background-color: #e06b6b" @endif>
                                                    {{ $shift_group_lists->shift_group_name }}</option>
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
                                                <th>Grup Shift</th>
                                                <th>Hari</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <hr>
                                <a href="{{ URL::route('editor.period.index') }}" type="button"
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
@section('scripts')
    <script type="text/javascript">
        var table;
        $(document).ready(function() {
            //datatables
            setholiday();
            table = $('#dtTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('editor/period/data-detail') }}/{{ $period->id }}",
                "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    if (aData[1] == "1") {
                        $('td', nRow).css('background-color', 'red');
                    } else if (aData[0] == "4") {
                        $('td', nRow).css('background-color', 'Orange');
                    }
                },
                columns: [{
                        data: 'shift_group_name',
                        name: 'shift_group_name'
                    },
                    {
                        data: 'day',
                        name: 'day'
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
            tablle.ajax.reload(null, false); //reload datatable ajax 
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
                    url: '../../period/save-detail/{{ $period->id }}',
                    type: "PUT",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'day': $('#day').val(),
                        'shift_group_id': $('#shift_group_id').val()
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
                                url: '../../period/delete-detail/' + id,
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
