@extends('layouts.editor.template')
@section('module', 'Setting')
@section('title', 'Gaji')
@section('required', 'errorEmployeeStatusName')
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row align-items-center bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h6 class="page-title">@yield('title')</h6>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/editor') }}">Dashboard</a></li>
                        <li><a href="#">@yield('module')</a></li>
                        <li class="active">@yield('title')</li>
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
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <div class="row align-items-center">
                                                <div class="col-md-2 col-lg-1 pull-left">
                                                    <label class="control-label mb-md-0">Periode</label>
                                                </div>
                                                <div class="col-md-4">
                                                    @if (empty($period))
                                                        {{ Form::select('periodid', $period_list, old('periodid'), ['class' => 'form-control', 'placeholder' => 'Select Period', 'id' => 'periodid', 'onchange' => 'CreateData();']) }}
                                                    @else
                                                        {{ Form::select('periodid', $period_list, old('periodid', $period), ['class' => 'form-control', 'placeholder' => 'Select Period', 'id' => 'periodid', 'onchange' => 'CreateData();']) }}
                                                    @endif
                                                </div>
                                                <div class="col-lg-4">
                                                    <a onClick="GenerateData();" class="btn btn-danger"> <i
                                                            class="fa fa-magic"></i> Kalkulasi<sup><span
                                                                class="label label-warning">!</span></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <a href="#" onClick="showslip('{{ Request::segment(2) }}');"
                                                type="button" class="btn btn-outline-warning">?</a>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="table-responsive">
                                    <table id="dtTable" class="display nowrap" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Aksi</th>
                                                <th>Keterangan</th>
                                                {{-- <th>Periode</th>  --}}
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
                ajax: "{{ url('editor/payroll/data') }}",
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
                    // { data: 'date_period', name: 'date_period', render: function(d){return moment(d).format("DD-MM-YYYY");} },
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
                        data: 'status',
                        render: function(data, type, row) {
                            let output = '<span class="label label-success"> Aktif </span>';
                            if (row.status == 0) {
                                return output;
                            } else {
                                output = '<span class="label label-danger"> Tidak Aktif </span>';
                            }
                        }
                    }
                ]
            });
            //check all
            $("#check-all").click(function() {
                $(".data-check").prop('checked', $(this).prop('checked'));
            });
        });

        function reload_table() {
            table.ajax.reload(null, false); //reload datatable ajax 
        }

        function CreateData() {
            var periodid = $('#periodid').val();
            var perioddesc = $("#periodid option:selected").text();
            // waitingDialog.show('Process...', {dialogSize: 'sm', progressType: 'warning'});
            $.ajax({
                url: 'payroll/create/' + periodid,
                type: "POST",
                data: {
                    '_token': $('input[name=_token]').val()
                },
                success: function(data) {
                    var options = {
                        "positionClass": "toast-bottom-right",
                        "timeOut": 1000,
                    };
                    // waitingDialog.hide();
                    // toastr.success('Successfully created data!', 'Success Alert', options);
                    reload_table();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $.alert({
                        type: 'red',
                        icon: 'fa fa-danger', // glyphicon glyphicon-heart
                        title: 'Warning',
                        content: 'Error creating data!',
                    });
                }
            });
        }

        function GenerateData() {
            var periodid = $('#periodid').val();
            var perioddesc = $("#periodid option:selected").text();

            if (periodid == '') {
                $.alert({
                    type: 'red',
                    icon: 'fa fa-danger', // glyphicon glyphicon-heart
                    title: 'Warning',
                    content: 'Period can not be null!',
                });
            } else {
                $.confirm({
                    title: 'Confirm!',
                    content: 'Are you sure to generate <b><u>' + perioddesc + '</u></b> data?',
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        cancel: {
                            action: function() {}
                        },
                        confirm: {
                            text: 'CREATE',
                            btnClass: 'btn-red',
                            action: function() {
                                // waitingDialog.show('Process...', {dialogSize: 'sm', progressType: 'warning'});
                                $.ajax({
                                    url: 'payroll/generate/' + periodid,
                                    type: "POST",
                                    data: {
                                        '_token': $('input[name=_token]').val()
                                    },
                                    success: function(data) {
                                        var options = {
                                            "positionClass": "toast-bottom-right",
                                            "timeOut": 1000,
                                        };
                                        // waitingDialog.hide();
                                        toastr.success('Successfully generated data!',
                                            'Success Alert', options);
                                        reload_table();
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        $.alert({
                                            type: 'red',
                                            icon: 'fa fa-danger', // glyphicon glyphicon-heart
                                            title: 'Warning',
                                            content: 'Error generate data!',
                                        });
                                        waitingDialog.hide();
                                    }
                                });
                            }
                        },
                    }
                });
            }
        }

        function RefreshData() {
            $.ajax({
                type: 'POST',
                url: "{{ URL::route('editor.periodfilteronly') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'periodid': $('#periodid').val()
                },
                success: function(data) {
                    var options = {
                        "positionClass": "toast-bottom-right",
                        "timeOut": 1000,
                    };
                    toastr.success('Successfully filtering data!', 'Success Alert', options);
                    reload_table();
                }
            })
        };
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop
