@extends('layouts.editor.template')
@section('title', 'Buku Manual')
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Buku Manual</h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/editor') }}">Dashboard</a></li>
                        <li><a href="#">Master Data</a></li>
                        <li class="active">Buku Manual</li>
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
                                    <a href="{{ URL::route('editor.manual-book.create') }}" type="button"
                                        class="fcbtn btn btn-primary btn-outline btn-1b waves-effect">Add New</a>
                                    <a href="#" onClick="history.back()" type="button"
                                        class="fcbtn btn btn-info btn-outline btn-1b waves-effect">Back</a>
                                    <a href="#" onClick="reload_table()" type="button"
                                        class="fcbtn btn btn-warning btn-outline btn-1b waves-effect">Refresh</a>
                                </div>
                                <hr>
                                <div class="table-responsive">
                                    <table id="dtTable" class="display nowrap" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Nama</th>
                                                {{-- <th>Status</th> --}}
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
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'print'
                ],
                ajax: "{{ URL::route('editor.manual-book.data') }}",
                columns: [{
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'manual_book_name',
                        name: 'manual_book_name'
                    },
                    // { data: 'mstatus', name: 'mstatus' }
                ]
            });
        });

        function reload_table() {
            table.ajax.reload(null, false); //reload datatable ajax 
        }

        function delete_id(id, manual_book_name) {
            var manual_book_name = manual_book_name.bold();

            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure to delete ' + manual_book_name + ' data?',
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
                                url: 'manual-book/delete/' + id,
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

    <!-- Add fancyBox -->
    <link rel="stylesheet" href="{{ Config::get('constants.path.plugin') }}/fancybox/jquery.fancybox.css?v=2.1.5"
        type="text/css" media="screen" />
    <script type="text/javascript"
        src="{{ Config::get('constants.path.plugin') }}/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".fancybox").fancybox();
        });
    </script>
@stop
