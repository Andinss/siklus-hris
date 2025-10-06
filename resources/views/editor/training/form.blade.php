@extends('layouts.editor.template')
@if (isset($training))
    @section('title', 'Edit Pelatihan')
@else
    @section('title', 'Tambah Baru Pelatihan')
@endif
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">
                        @if (isset($training))
                            Edit
                        @else
                            Tambah Baru
                        @endif Pelatihan
                    </h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/editor') }}">Dashboard</a></li>
                        <li class="active">
                            @if (isset($training))
                                Edit
                            @else
                                Tambah Baru
                            @endif Pelatihan
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
                                @if (isset($training))
                                    {!! Form::model($training, [
                                        'route' => ['editor.training.update', $training->id],
                                        'method' => 'PUT',
                                        'files' => 'true',
                                    ]) !!}
                                @else
                                    {!! Form::open(['route' => 'editor.training.store', 'files' => 'true']) !!}
                                @endif
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <section>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('no_trans', 'No Training *') }}
                                                    {{ Form::text('no_trans', old('no_trans'), ['class' => 'form-control', 'placeholder' => 'No Training *', 'required' => 'true', 'id' => 'no_trans', 'disabled' => 'disabled']) }}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('date_trans', 'Tanggal Training *') }}
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-calendar"></i></span>
                                                        {{ Form::text('date_trans', date('d-m-Y', strtotime($training->date_trans)), ['class' => 'form-control', 'placeholder' => 'Tanggal Training *', 'required' => 'true', 'id' => 'date_trans']) }}
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('education_type_id', 'Jenis Pendidikan') }}
                                                    {{ Form::select('education_type_id', $education_type_list, old('education_type_id'), ['class' => 'form-control', 'placeholder' => 'Pilih Jenis Pendidikan', 'id' => 'education_type_id']) }}
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('training_type_id', 'Jenis Pelatihan') }}
                                                    {{ Form::select('training_type_id', $training_type_list, old('training_type_id'), ['class' => 'form-control', 'placeholder' => 'Pilih Jenis Pelatihan', 'id' => 'training_type_id']) }}
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('provider', 'Pemberi Pelatihan') }}
                                                    {{ Form::select('provider', $training_provider_list, old('provider'), ['class' => 'form-control', 'placeholder' => 'Select Pemberi Pelatihan', 'id' => 'provider']) }}
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('training_from', 'Dari Tanggal') }}
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-calendar"></i></span>
                                                        {{ Form::text('training_from', date('d-m-Y', strtotime($training->training_from)), ['class' => 'form-control', 'placeholder' => 'Dari Tanggal', 'required' => 'true', 'id' => 'training_from', 'onchange' => 'diff_date()']) }}
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('training_to', 'Sampai Tanggal') }}
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-calendar"></i></span>
                                                        {{ Form::text('training_to', date('d-m-Y', strtotime($training->training_to)), ['class' => 'form-control', 'placeholder' => 'Sampai Tanggal', 'required' => 'true', 'id' => 'training_to', 'onchange' => 'diff_date()']) }}
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('cost', 'Biaya') }}
                                                    {{ Form::text('cost', old('cost'), ['class' => 'form-control', 'placeholder' => 'Biaya', 'required' => 'true', 'id' => 'cost']) }}
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('days', 'Hari') }}
                                                    {{ Form::text('days', old('days'), ['class' => 'form-control', 'placeholder' => 'Hari', 'required' => 'true', 'id' => 'days']) }}
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('time_in', 'Jam Masuk') }}
                                                    {{ Form::time('time_in', old('time_in'), ['class' => 'form-control', 'placeholder' => 'Jam Masuk', 'required' => 'true', 'id' => 'time_in']) }}
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('time_out', 'Jam Keluar') }}
                                                    {{ Form::time('time_out', old('time_out'), ['class' => 'form-control', 'placeholder' => 'Jam Keluar', 'required' => 'true', 'id' => 'time_out']) }}
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('certified', 'Sertifikat') }}
                                                    <select class="form-control" style="width: 100%;" name="certified"
                                                        id="certified">
                                                        <option value="0">No</option>
                                                        <option value="1">Yes</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('training_venue_id', 'Lokasi') }}
                                                    {{ Form::text('training_venue', old('training_venue'), ['class' => 'form-control', 'placeholder' => 'Lokasi', 'required' => 'true', 'id' => 'training_venue']) }}
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('attachment', 'Lampiran') }}<br>
                                                    <span class="btn btn-default"><input type="file"
                                                            name="attachment" /></span>
                                                    <br />
                                                </div>
                                            </div>
                                        </div>
                                        <h3 class="box-title m-t-40">Peserta Pelatihan</h3>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    {{ Form::select('employee_id', $employee_list, old('employee_id'), ['class' => 'form-control select2', 'placeholder' => 'Pilih Karyawan', 'id' => 'employee_id', 'onchange' => 'RefreshData();']) }}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <button type="button" id="btnSave" onclick="savedetail();"
                                                        class="btn btn-primary btn-flat"> <i class="fa fa-plus"></i>
                                                        Tambah</button>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <table id="dtTablePar" class="display nowrap" cellspacing="0"
                                                        width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Aksi</th>
                                                                <th>NIK</th>
                                                                <th>Nama Karyawan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button type="submit" id="btnsave"
                                                        class="btn btn-success pull-right btn-flat"><i
                                                            class="fa fa-check"></i> Simpan</button>
                                                    <a href="{{ URL::route('editor.training.index') }}"
                                                        class="btn btn-default pull-right" style="margin-right: 5px"><i
                                                            class="fa fa-close"></i> Tutup</a>
                                                </div>
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                </div>
                            </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@stop

@section('scripts')
    @if (isset($training))
        <script type="text/javascript">
            function cancel() {
                $.confirm({
                        title: 'Confirm!',
                        content: 'Are you sure to cancel this data?',
                        type: 'red',
                        typeAnimated: true,
                        buttons: {
                            cancel: {
                                action: function() {}
                            },
                            confirm: {
                                text: 'CANCEL',
                                btnClass: 'btn-red',
                                action: function() {
                                    $.ajax({
                                        url: '../../training/cancel/' + {{ $training->id }},
                                        type: "PUT",
                                        data: {
                                            '_token': $('input[name=_token]').val()
                                        },
                                        success: function(data) {
                                            //var loc = 'ap_invoice';
                                            if ((data.errors)) {
                                                alert("Cancel error!");
                                            } else {
                                                window.location.href =
                                                    "{{ URL::route('editor.training.index') }}";
                                            }
                                        },
                                    });
                                }
                            },
                        });
                }

                function hidebtnactive() {
                    $('#btnsave').hide(100);
                }

                function cekval() {
                    var test = $('#itemcost').val();
                    alert(test);
                }

                function cal_sparator() {

                    var cost = document.getElementById('cost').value;
                    var result = document.getElementById('cost');
                    var rsamount = (cost);
                    result.value = rsamount.replace(/,/g, "");
                }

                window.onload = function() {

                    n2 = document.getElementById('cost');

                    n2.onkeyup = n2.onchange = function(e) {
                        e = e || window.event;
                        var who = e.target || e.srcElement,
                            temp;
                        if (who.id === 'cost') temp = validDigits(who.value, 0);
                        else temp = validDigits(who.value);
                        who.value = addCommas(temp);
                    }
                    n2.onblur = function() {
                        var
                            temp2 = parseFloat(validDigits(n2.value));
                        if (temp2) n2.value = addCommas(temp2.toFixed(0));
                    }
                }
        </script>
    @endif

    <script>
        var tablepar;
        $(document).ready(function() {
            RefreshData();
            tablepar = $('#dtTablePar').DataTable({
                //dttables
                processing: true,
                serverSide: true,
                "pageLength": 8,
                "lengthMenu": [
                    [25, 50, 100, -1],
                    [25, 50, 100, "All"]
                ],
                ajax: "{{ url('editor/training/dataparticipant/') }}/{{ $training->id }}",
                columns: [{
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'employee_name',
                        name: 'employee_name'
                    },
                ]
            });
        });

        function reload_table() {
            table.ajax.reload(null, false); //reload datatable ajax 
        }

        function reload_table_par() {
            tablepar.ajax.reload(null, false); //reload datatable ajax 
        }

        // function diff_date() 
        // {
        //   var training_from = $("#training_from").val();
        //   var training_to = $("#training_to").val();

        //   var startDate = Date.parse(training_from);
        //   var endDate = Date.parse(training_to);
        //   var timeDiff = endDate - startDate;
        //   daysDiff = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
        //   $("#days").val(daysDiff);
        // }

        function RefreshData() {

            $.ajax({
                type: 'POST',
                url: "{{ URL::route('editor.employeefilter') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'employee_id': $('#employee_id').val()
                },
                success: function(data) {
                    reload_table();
                }
            })
        };

        function showslip(id) {
            var url = '../../mutation/slip/' + id;
            PopupCenter(url, 'Popup_Window', '700', '650');
        }

        function savedetail(id) {
            var employee_id = $("#employee_id").val();
            save_method = 'update';

            if (employee_id == '') {
                var options = {
                    "positionClass": "toast-bottom-right",
                    "timeOut": 1000,
                };
                toastr.error('Employee data is required!', 'Error Validation', options);
            } else {
                //Ajax Load data from ajax
                $.ajax({
                    url: '../../training/savedetail/{{ $training->id }}',
                    type: "PUT",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'employee_id': $('#employee_id').val()
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
                        reload_table_par();

                        $('#employee_id').val('')
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
                                url: '../../training/deletedet/' + id,
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
                                    reload_table_par();
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
    </script>
    <script src="{{ asset('assets/plugins') }}/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript">
        jQuery('.mydatepicker, #training_from').datepicker();
        jQuery('.mydatepicker, #training_to').datepicker();
        jQuery('.mydatepicker, #date_trans').datepicker();

        $('#training_from').datepicker({
            format: 'dd-mm-yyyy'
        });
        $('#training_to').datepicker({
            format: 'dd-mm-yyyy'
        });
        $('#date_trans').datepicker({
            format: 'dd-mm-yyyy'
        });
    </script>
    @if (isset($training) && $training->status != 0)
        <script>
            $("#form_training :input").prop("disabled", true);
        </script>
    @endif
@stop
