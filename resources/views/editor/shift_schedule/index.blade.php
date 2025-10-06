@extends('layouts.editor.template')
@section('title', 'Jadwal Shift')
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Jadwal Shift</h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                        <li><a href="#">Aktivitas</a></li>
                        <li class="active">Jadwal Shift</li>
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
                                <div class="button-box">
                                    <a href="#" onClick="history.back()" type="button"
                                        class="fcbtn btn btn-info btn-outline btn-1b waves-effect">Kembali</a>
                                    <a href="#" onClick="reload_table()" type="button"
                                        class="fcbtn btn btn-warning btn-outline btn-1b waves-effect">Refresh</a>
                                </div>
                                <hr>
                                <div class="table-responsive">
                                    <table id="dtTable" class="display nowrap" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Aksi</th>
                                                <th>Keterangan</th>
                                                <th>Dari Tanggal</th>
                                                <th>Sampai Tanggal</th>
                                                <th>Dibayar Tanggal</th>
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



    {{-- @stop --}}
    {{-- @section('scripts') --}}
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
                "initComplete": function(settings, json) {
                    $("#dtTable").wrap(
                        "<div style='overflow:auto; width:100%;position:relative;'></div>");
                },
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'print'
                ],
                ajax: "{{ URL::route('editor.shift-schedule.data') }}",
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
                        data: 'mstatus',
                        name: 'mstatus'
                    }
                ]
            });
        });

        function reload_table() {
            table.ajax.reload(null, false); //reload datatable ajax 
        }

        function delete_id(id, leave_name) {
            var leave_name = leave_name.bold();

            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure to delete ' + leave_name + ' data?',
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
                                url: 'leave/delete/' + id,
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
