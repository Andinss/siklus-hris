@extends('layouts.editor.template')
@section('title', 'Preferense')
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row align-items-center bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Preferense</h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                        <li><a href="#">Aktivitas</a></li>
                        <li class="active">Preferense</li>
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
                                    'link' => 'editor.document.create',
                                    'back_button' => true,
                                    'info_button' => true,
                                ])
                                <hr>
                                <div class="table-responsive">
                                    <table id="dtTable" class="display nowrap" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Aksi</th>
                                                <th>Nomor Preferense</th>
                                                <th>Nama Preferense</th>
                                                <th>Tanggal</th>
                                                <th>Tanggal Kadaluarsa</th>
                                                <th>Hari Proses</th>
                                                <th>Nominal</th>
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
@section('popup')
    <!-- Bootstrap modal -->
    <div class="modal fade" id="modal_form" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" style="width:40% !important">
            <div class="modal-content">
                {!! Form::open([
                    'route' => 'editor.document.store',
                    'class' => 'form-horizontal',
                    'files' => 'true',
                    'id' => 'form_floor',
                ]) !!}
                {{ csrf_field() }}
                <div class="modal-header">
                    <h4 class="modal-title">SELECT TRAINING CODE</h4>
                </div>
                <div class="modal-body">
                    <div class="form-body">
                        <div class="col-lg-12" class="col-md-12" class="col-sm-12">
                            <label class="control-label col-md-4 pull-left">Transaction</label>
                            <div class="col-md-8">
                                <select class="form-control" name="codetrans" id="codetrans" placeholder="Transaction Code">
                                    <option value="DOK">Document</option>
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
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'print'
                ],
                "initComplete": function(settings, json) {
                    $("#dtTable").wrap(
                        "<div style='overflow:auto; width:100%;position:relative;'></div>");
                },
                ajax: "{{ URL::route('editor.document.data') }}",
                columns: [{
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'documentno',
                        name: 'documentno'
                    },
                    {
                        data: 'documentname',
                        name: 'documentname'
                    },
                    {
                        data: 'documentdate',
                        name: 'documentdate',
                        render: function(d) {
                            return moment(d).format("DD-MM-YYYY");
                        }
                    },
                    {
                        data: 'expireddate',
                        name: 'expireddate',
                        render: function(d) {
                            return moment(d).format("DD-MM-YYYY");
                        }
                    },
                    {
                        data: 'dayprocess',
                        name: 'dayprocess'
                    },
                    {
                        data: 'amount',
                        name: 'amount',
                        render: $.fn.dataTable.render.number(',', '.', 0, 'Rp. ')
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

        function add() {
            $("#btnSave").attr("onclick", "save()");
            $("#btnSaveAdd").attr("onclick", "saveadd()");

            $('.errorMaterial UsedName').addClass('hidden');

            save_method = 'add';
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#modal_form').modal('show'); // show bootstrap modal
            $('.modal-title').text('Add Document'); // Set Title to Bootstrap modal title
        }

        function reload_table() {
            table.ajax.reload(null, false); //reload datatable ajax 
        }

        function delete_id(id, document_name) {
            var document_name = document_name.bold();

            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure to delete ' + document_name + ' data?',
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
                                url: 'document/delete/' + id,
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
