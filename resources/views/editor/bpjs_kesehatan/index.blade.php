@extends('layouts.editor.template')
@section('module', 'Setting')
@section('title', 'Tarif Perhitungan BPJS Kesehatan')
@section('current_page', 'BPJS Kesehatan')
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
                        <li><a href="{{ url('/editor') }}">Dashboard</a></li>
                        <li><a href="#">@yield('module')</a></li>
                        <li class="active">@yield('current_page')</li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-wrapper collapse in" aria-expanded="true">
                            <div class="panel-body">
                                @include('layouts.editor.template_button_master', [
                                    'add_action' => 'link',
                                    'link' => 'editor.bpjs-kesehatan.create',
                                    'back_button' => true,
                                    'info_button' => false,
                                ])
                                <hr>
                                <div class="table-responsive">
                                    <table id="dtTable" class="display nowrap" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Aksi</th>
                                                <th>Nama Skema Perhitungan</th>
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
                ajax: "{{ URL::route('editor.bpjs-kesehatan.data') }}",
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'print'
                ],
                columns: [{
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'schema_name',
                        name: 'schema_name'
                    },
                ]
            });
        });

        function reload_table() {
            table.ajax.reload(null, false); //reload datatable ajax 
        }

        function delete_id(id, schema) {
            let schemaName = schema.bold();
            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure to delete ' + schemaName + ' data?',
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
                                url: 'bpjs-kesehatan/delete/' + id,
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
