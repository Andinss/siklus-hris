@extends('layouts.editor.template')
@section('module', 'Setting')
@section('title', 'Absen')
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
                        <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
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
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <label class="control-label col-md-1 pull-left">Periode</label>
                                            <div class="col-md-4 pull-left">
                                                @if (empty($period))
                                                    {{ Form::select('period_id', $period_list, old('period_id'), ['class' => 'form-control', 'placeholder' => 'Select Period', 'id' => 'period_id', 'onchange' => 'CreateData();']) }}
                                                @else
                                                    {{ Form::select('period_id', $period_list, old('period_id', $period), ['class' => 'form-control', 'placeholder' => 'Select Period', 'id' => 'period_id', 'onchange' => 'CreateData();']) }}
                                                @endif
                                                {{-- <div class="form-group">
                                        <label for="begin_date">Begin Date:</label>
                                        <input type="date" id="begin_date" class="form-control" onchange="reload_table();" value="{{ \Carbon\Carbon::now()->startOfMonth()->toDateString() }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="end_date">End Date:</label>
                                        <input type="date" id="end_date" class="form-control" onchange="reload_table();" value="{{ \Carbon\Carbon::now()->endOfMonth()->toDateString() }}">
                                    </div> --}}
                                            </div>
                                            <div class="col-md-4 pull-left">
                                                <a onClick="GenerateData();" class="btn btn-danger"> <i
                                                        class="fa fa-magic"></i> Kalkulasi<sup><span
                                                            class="label label-warning">!</span></a>
                                                </sup>
                                            </div>

                                            <!-- <a href="http://localhost/spinel-service/post-attendance" target="_blank" class="btn btn-primary"> <i class="fa fa-magic"></i>  Tarik Data Mesin</a>  -->

                                            <a href="#" onClick="showslip('{{ Request::segment(2) }}');"
                                                type="button"
                                                class="fcbtn btn btn-warning btn-outline btn-1b waves-effect pull-right">?</a>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="table-responsive">
                                    <table id="dtTable" class="display nowrap" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Aksi</th>
                                                <th>Nama Karyawan</th>
                                                <th>ID Karyawan</th>
                                                <th>Jabatan</th>
                                                <th>Divisi</th>
                                                <th>Email</th>
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
                buttons: [],
                ajax: "{{ url('editor/time/data') }}",
                columns: [{
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                    //{ data: 'description', name: 'description' },
                    {
                        data: 'employee_name',
                        name: 'employee_name'
                    },
                    {
                        data: 'identity_no',
                        name: 'identity_no'
                    },
                    {
                        data: 'position_name',
                        name: 'position_name'
                    },
                    {
                        data: 'department_name',
                        name: 'department_name'
                    },
                    {
                        data: 'email',
                        name: 'email'
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

        function GenerateData() {
            var period_id = $('#period_id').val();
            var perioddesc = $("#period_id option:selected").text();

            if (period_id == '') {
                $.alert({
                    type: 'red',
                    icon: 'fa fa-danger', // glyphicon glyphicon-heart
                    title: 'Warning',
                    content: 'Period can not be null!',
                });
            } else {
                $.confirm({
                    title: 'Konfirmasi!',
                    content: 'Anda akan mengkalkulasi absensi periode <b><u>' + perioddesc + '</u></b>?',
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        cancel: {
                            action: function() {}
                        },
                        confirm: {
                            text: 'KALKULASI',
                            btnClass: 'btn-red',
                            action: function() {
                                // $("#loader").show();
                                // waitingDialog.show('Process...', {dialogSize: 'sm', progressType: 'warning'});
                                $.ajax({
                                    url: "{{ url('editor/time/generate') }}/" + period_id + "",
                                    type: "POST",
                                    data: {
                                        '_token': $('input[name=_token]').val()
                                    },
                                    success: function(data) {
                                        toastr.success('Successfully genareted data!',
                                            'Success Alert', options);
                                        reload_table();
                                        waitingDialog.hide();
                                        var options = {
                                            "positionClass": "toast-bottom-right",
                                            "timeOut": 1000,
                                        };

                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        $.alert({
                                            type: 'red',
                                            icon: 'fa fa-danger', // glyphicon glyphicon-heart
                                            title: 'Warning',
                                            content: 'Error generate data!',
                                        });
                                    }
                                });
                            }
                        },

                    }
                });
            }
        }

        function RefreshData() {
            // waitingDialog.show('Process...', {dialogSize: 'sm', progressType: 'warning'});
            // CraeteData();
            $.ajax({
                type: 'POST',
                url: "{{ URL::route('editor.periodfilteronly') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'period_id': $('#period_id').val()
                },
                success: function(data) {
                    // $dialog.modal('hide');
                    // var options = {
                    //   "positionClass": "toast-bottom-right",
                    //   "timeOut": 1000,
                    // };
                    // alert('success');
                    toastr.success('Successfully filtering data!', 'Success Alert', options);
                    reload_table();
                },
            })
        };

        function CreateData() {
            // waitingDialog.show('Process...', {dialogSize: 'sm', progressType: 'warning'});
            var period_id = $('#period_id').val();
            var perioddesc = $("#period_id option:selected").text();
            $.ajax({
                url: "{{ route('editor.time.store') }}",
                type: "POST",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'period_id': $('#period_id').val(),
                },
                success: function(data) {
                    // toastr.success('Successfully filtering data!', 'Success Alert', options);
                    // $dialog.modal('hide');
                    // waitingDialog.hide();
                    reload_table();
                }
            })
        }

        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

        /**
         * Module for displaying "Waiting for..." dialog using Bootstrap
         *
         * @author Eugene Maslovich <ehpc@em42.ru>
         */

        var waitingDialog = waitingDialog || (function($) {
            'use strict';

            // Creating modal dialog's DOM
            var $dialog = $(
                '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
                '<div class="modal-dialog modal-m">' +
                '<div class="modal-content">' +
                '<div class="modal-header"><h3 style="margin:0;"></h3></div>' +
                '<div class="modal-body">' +
                '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
                '</div>' +
                '</div></div></div>');

            return {
                /**
                 * Opens our dialog
                 * @param message Process...
                 * @param options Custom options:
                 *          options.dialogSize - bootstrap postfix for dialog size, e.g. "sm", "m";
                 *          options.progressType - bootstrap postfix for progress bar type, e.g. "success", "warning".
                 */
                show: function(message, options) {
                    // Assigning defaults
                    if (typeof options === 'undefined') {
                        options = {};
                    }
                    if (typeof message === 'undefined') {
                        message = 'Loading';
                    }
                    var settings = $.extend({
                        dialogSize: 'm',
                        progressType: '',
                        onHide: null // This callback runs after the dialog was hidden
                    }, options);

                    // Configuring dialog
                    $dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings
                        .dialogSize);
                    $dialog.find('.progress-bar').attr('class', 'progress-bar');
                    if (settings.progressType) {
                        $dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType);
                    }
                    $dialog.find('h3').text(message);
                    // Adding callbacks
                    if (typeof settings.onHide === 'function') {
                        $dialog.off('hidden.bs.modal').on('hidden.bs.modal', function(e) {
                            settings.onHide.call($dialog);
                        });
                    }
                    // Opening dialog
                    $dialog.modal();
                },
                /**
                 * Closes dialog
                 */
                hide: function() {
                    $dialog.modal('hide');
                }
            };

        })(jQuery);
    </script>
@stop
