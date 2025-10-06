@extends('layouts.editor.template')
@section('title', 'Lembur')
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row align-items-center bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h6 class="page-title">Lembur</h6>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                        <li><a href="#">Aktivitas</a></li>
                        <li class="active">Lembur</li>
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
                                    'add_action' => 'link',
                                    'link' => 'editor.overtime.create',
                                    'back_button' => true,
                                    'info_button' => false,
                                ])
                                <hr>
                                <!-- filter jam -->
                                <form class="row gx-3 gy-2 justify-content-md-end align-items-center mb-3">
                                    <div class="col-1">
                                        <label for="" class="mb-0">Filter</label>
                                    </div>
                                    <div class="col-sm-6 col-md-3 col-lg-2 d-flex align-items-center">
                                        {{ Form::text('date_from', old('date_from'), ['class' => 'form-control', 'placeholder' => 'Dari Tanggal', 'required' => 'true', 'id' => 'date_from']) }}
                                    </div>
                                    <div class="col-sm-6 col-md-3 col-lg-2 d-flex align-items-center">
                                        {{ Form::text('date_to', old('date_to'), ['class' => 'form-control', 'placeholder' => 'Sampai Tanggal', 'required' => 'true', 'id' => 'date_to']) }}
                                    </div>
                                    <div class="col-sm-6 col-md-3 col-lg-2 d-flex align-items-center">
                                        {{ Form::text('search', old('search'), ['class' => 'form-control', 'placeholder' => 'Cari berdasarkan', 'required' => 'true', 'id' => 'search']) }}
                                    </div>
                                </form>
                                <!-- filter jam -->
                                <div class="table-responsive">
                                    <table id="dtTable" class="display nowrap" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Aksi</th>
                                                <th>No Lembur</th>
                                                <th>Nama Karyawan</th>
                                                <th>Jabatan</th>
                                                <th>ID Karyawan</th>
                                                <th>Dari Jam</th>
                                                <th>Sampai Jam</th>
                                                <th>Jumlah Rate</th>
                                                <th>Keterangan</th>
                                                <th>Lampiran</th>
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



    {{-- @stop --}}
    {{-- @section('scripts') --}}
    <script src="{{ asset('assets/plugins') }}/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script>
        jQuery('.mydatepicker, #date_from').datepicker();
        jQuery('.mydatepicker, #date_to').datepicker();

        $('#date_from').datepicker({
            format: 'dd-mm-yyyy'
        });
        $('#date_to').datepicker({
            format: 'dd-mm-yyyy'
        });

        // Load Datatable
        var table;
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
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'print'
                ],
                ajax: "{{ URL::route('editor.overtime.data') }}",
                columns: [{
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'no_trans',
                        name: 'no_trans'
                    },
                    {
                        data: 'employee_name',
                        name: 'employee_name'
                    },
                    {
                        data: 'position_name',
                        name: 'position_name'
                    },
                    {
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'time_from',
                        name: 'time_from'
                    },
                    {
                        data: 'time_to',
                        name: 'time_to'
                    },
                    {
                        data: 'total_rate',
                        name: 'total_rate'
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'attachment',
                        render: function(data, type, row) {
                            let output = "No Attachment";
                            if (row.attachment == "" || row.attachment == null) {
                                return output;
                            } else {
                                output = '<a href="{{ asset('uploads/overtime') }}/' + row
                                    .attachment +
                                    '" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fas fa-download"></i> Download </a>';
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

        function delete_id(id) {

            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure to delete this data?',
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
                                url: 'overtime/delete/' + id,
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
    </script>

@stop
