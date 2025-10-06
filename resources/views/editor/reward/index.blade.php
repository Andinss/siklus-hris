@extends('layouts.editor.template')
@section('title', 'Penghargaan')
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row align-items-center bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h6 class="page-title">Penghargaan</h6>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                        <li><a href="#">Master Data</a></li>
                        <li class="active">Penghargaan</li>
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
                                    'link' => 'editor.reward.create',
                                    'back_button' => true,
                                    'info_button' => true,
                                ])
                                <hr>
                                <div class="table-responsive">
                                    <table id="dtTable" class="display nowrap" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Aksi</th>
                                                <th>No Penghargaan</th>
                                                <th>Tanggal Penggargaan</th>
                                                <th>Nama Karyawan</th>
                                                <th>Jenis Penghargaan</th>
                                                <th>Alasan</th>
                                                <th>Lampiran</th>
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
                "initComplete": function(settings, json) {
                    $("#dtTable").wrap(
                        "<div style='overflow:auto; width:100%;position:relative;'></div>");
                },
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'print'
                ],
                ajax: "{{ URL::route('editor.reward.data') }}",
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
                        data: 'date_trans',
                        name: 'date_trans'
                    },
                    {
                        data: 'employee_name',
                        name: 'employee_name'
                    },
                    {
                        data: 'reward_type_name',
                        name: 'reward_type_name'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'attachment',
                        name: 'attachment'
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

        function delete_id(id, reward_name) {
            var reward_name = reward_name.bold();

            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure to delete ' + reward_name + ' data?',
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
                                url: 'reward/delete/' + id,
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
