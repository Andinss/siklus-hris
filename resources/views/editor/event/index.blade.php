@extends('layouts.editor.template')
@section('title', 'Event')
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row align-items-center bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h6 class="page-title">Event</h6>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                        <li><a href="#">Aktivitas</a></li>
                        <li class="active">Event</li>
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
                                    'link' => 'editor.event.create',
                                    'back_button' => true,
                                    'info_button' => true,
                                ])
                                <hr>
                                <div class="table-responsive">
                                    <table id="dtTable" class="display nowrap" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Aksi</th>
                                                <th>No Event</th>
                                                <th>Tanggal Event</th>
                                                <th>Nama Event</th>
                                                <th>Jumlah Peserta</th>
                                                <th>Tagline</th>
                                                <th>Foto Sampul</th>
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
                {!! Form::open([
                    'route' => 'editor.event.store',
                    'class' => 'form-horizontal',
                    'files' => 'true',
                    'id' => 'form_floor',
                ]) !!}
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4 class="modal-title">SELECT EVENT CODE</h4>
                </div>
                <div class="modal-body">
                    <div class="form-body">
                        <div class="col-lg-12" class="col-md-12" class="col-sm-12">
                            <label class="control-label col-md-4 pull-left">Transaction</label>
                            <div class="col-md-8">
                                <select class="form-control" name="codetrans" id="codetrans" placeholder="Transaction Code">
                                    <option value="EVENT">Event</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="modal-footer">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <button class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Submit</button>
                        <input type="hidden" value="1" name="submit" />
                        <button type="button" onclick="ClearVal()" class="btn btn-default btn-flat pull-left"
                            data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                    </div>
                </div>
                {!! Form::close() !!}
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
                "initComplete": function(settings, json) {
                    $("#dtTable").wrap(
                        "<div style='overflow:auto; width:100%;position:relative;'></div>");
                },
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'print'
                ],
                ajax: "{{ URL::route('editor.event.data') }}",
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
                        data: 'event_name',
                        name: 'event_name'
                    },
                    {
                        data: 'time_from',
                        name: 'time_from'
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
                        data: 'status',
                        render: function(data, type, row) {
                            let output =
                                '<span class="label label-success"> <i class="fa fa-check"></i> Active </span>';
                            if (row.status == 0) {
                                return output;
                            } else if (row.status == 9) {
                                output =
                                    '<span class="label label-danger"> <i class="fa fa-minus-square"></i> Cancel </span>';
                                return output;
                            }
                        }
                    }
                ]
            });
        });

        function add() {
            $("#btnSave").attr("onclick", "save()");
            $("#btnSaveAdd").attr("onclick", "saveadd()");

            $('.errorMaterial UsedName').addClass('hidden');

            save_method = 'add';
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#modal_form').modal('show'); // show bootstrap modal
            $('.modal-title').text('Add Punishment'); // Set Title to Bootstrap modal title
        }

        function reload_table() {
            table.ajax.reload(null, false); //reload datatable ajax 
        }

        function delete_id(id, event_name) {
            var event_name = event_name.bold();

            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure to delete ' + event_name + ' data?',
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
                                url: 'event/delete/' + id,
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
