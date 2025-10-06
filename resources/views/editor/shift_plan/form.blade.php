@extends('layouts.editor.template_shift')
@section('title', 'Jadwal Shift')
@section('module', 'Detail Form')
@section('content')

    <?php
    $tanggal = '2015-06-03';
    $day = date('D', strtotime($tanggal));
    $dayList = [
        'Sun' => 'Minggu',
        'Mon' => 'Senin',
        'Tue' => 'Selasa',
        'Wed' => 'Rabu',
        'Thu' => 'Kamis',
        'Fri' => 'Jumat',
        'Sat' => 'Sabtu',
    ];
    ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css"
        rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js">
    </script>

    <style>
        /* Center the loader */
        #loader {
            position: absolute;
            left: 50%;
            top: 50%;
            z-index: 1;
            width: 150px;
            height: 150px;
            margin: -75px 0 0 -75px;
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Add animation to "page content" */
        .animate-bottom {
            position: relative;
            -webkit-animation-name: animatebottom;
            -webkit-animation-duration: 1s;
            animation-name: animatebottom;
            animation-duration: 1s
        }

        @-webkit-keyframes animatebottom {
            from {
                bottom: -100px;
                opacity: 0
            }

            to {
                bottom: 0px;
                opacity: 1
            }
        }

        @keyframes animatebottom {
            from {
                bottom: -100px;
                opacity: 0
            }

            to {
                bottom: 0;
                opacity: 1
            }
        }

        #myDiv {
            display: none;
            text-align: center;
        }

        thead th {
            /*font-size: 0.9em;*/
            padding: 1px !important;
            height: 10px;
        }
    </style>

    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">@yield('title')</h4>
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
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Periode</label>
                                                    <div class="col-md-8">
                                                        : {{ $period->description }}
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <table id="table_capitalgood"
                                                class="table table-bordered table-hover stripe display nowrap"
                                                cellspacing="0" width="100%">
                                                <thead style="background-color: #f8e7c5;">
                                                    <tr>
                                                        <th>
                                                            <center>#</center>
                                                        </th>
                                                        <th>
                                                            <center>ID</center>
                                                        </th>
                                                        <th>
                                                            <center>Nama</center>
                                                        </th>
                                                        @foreach ($shift_schedule_date as $shift_schedule_dates)
                                                            @php
                                                                $day = date(
                                                                    'D',
                                                                    strtotime($shift_schedule_dates->date_in),
                                                                );
                                                            @endphp
                                                            <th style="font-size: 12px"> &nbsp;
                                                                {{ date('d-m-Y', strtotime($shift_schedule_dates->date_in)) }}
                                                                <center>
                                                                    <p
                                                                        @if ($dayList[$day] == 'Minggu') style="color: red;" @endif>
                                                                        <i>
                                                                            @php
                                                                                echo $dayList[$day];
                                                                            @endphp
                                                                        </i>
                                                                    </p>
                                                                </center>
                                                                &nbsp;
                                                            </th>
                                                        @endforeach
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $i = 1;
                                                        $i_val = 0;
                                                    @endphp

                                                    @php
                                                        $get_shift_val = [];
                                                    @endphp
                                                    @foreach ($shift_schedule_detail as $shift_schedule_details)
                                                        @php
                                                            $get_shift_val[] = $shift_schedule_details->shift_id;
                                                            $get_shift_text[] = $shift_schedule_details->shift_name;
                                                            // print_r($get_shift_text);
                                                        @endphp
                                                    @endforeach

                                                    @foreach ($employee_list as $key => $employee_lists)
                                                        <tr>
                                                            <td>
                                                                {{ $i++ }}
                                                            </td>
                                                            <td>
                                                                {{ $employee_lists->nik }}
                                                            </td>
                                                            <td>
                                                                {{ $employee_lists->employee_name }}
                                                            </td>
                                                            @if (isset($shift_schedule_date))
                                                                @php
                                                                @endphp
                                                                @foreach ($shift_schedule_date as $shift_schedule_dates)
                                                                    @php
                                                                        $day = date(
                                                                            'D',
                                                                            strtotime($shift_schedule_dates->date_in),
                                                                        );
                                                                    @endphp
                                                                    <td
                                                                        data-original-title="{{ $employee_lists->employee_name }} : @php
echo $dayList[$day]; @endphp, {{ date('d-m-Y', strtotime($shift_schedule_dates->date_in)) }}">
                                                                        @php
                                                                            $foo = $i_val++;
                                                                        @endphp
                                                                        <a href="" class="update"
                                                                            data-name="shift_id"
                                                                            id="{{ $employee_lists->id }}_{{ $shift_schedule_dates->date_in }}"
                                                                            data-pk="{{ $employee_lists->id }}_{{ $shift_schedule_dates->date_in }}_{{ $shift_schedule_dates->period_id }}"
                                                                            data-type="select"
                                                                            data-source='{{ url('editor/shift-plan/lookup') }}'>@php print_r($get_shift_text[$foo]); @endphp</a>
                                                                        {{-- <a href="" class="update" data-name="totalmodal" data-pk="{{ $employee_lists->id }}" data-type="text" data-title="Modal:" data-emptytext="Null">{{ $employee_lists->id }}</a> --}}
                                                                    </td>
                                                                @endforeach
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- /.box-body -->
                                        <a href="{{ URL::route('editor.shift-plan.index', ['period' => '1']) }}"
                                            class="btn btn-default pull-right btn-flat" style="margin-right: 10px"><i
                                                class="fa fa-close"></i> Tutup</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.update').editable({
            url: '../../shift-plan/create',
            type: 'text',
            pk: 1,
            name: 'name',
            title: 'Enter Shift'
        });

        $(document).ready(function() {
            $("#table_capitalgood").dataTable({
                "bPaginate": false,
                "dom": '<"toolbar">frtip',
                "autoWidth": false,
                "ordering": false,
                "bInfo": false,
                "paging": false,
                "searching": true,
                "initComplete": function(settings, json) {
                    $("#table_capitalgood").wrap(
                        "<div style='overflow:auto; width:100%;position:relative;'></div>");
                },
            });

            // $("div.toolbar").html('');

            $.fn.editable.defaults.mode = 'inline';

            //make username editable
            $('#username').editable({
                emptytext: 'Leer',
            });

        });

        // $(document).ready(function() {  
        //     $("#table_capitalgood").dataTable( {
        //         "sScrollX": true,
        //          "scrollY": "330px",
        //          "scrollX": true,
        //          "autowidth": true,
        //          "sScrollXInner": "240%",
        //          "bPaginate": false,
        //          "dom": '<"toolbar">frtip',
        //          "autoWidth": false,
        //          "ordering": false,
        //          "bInfo" : false,
        //          "paging": false,
        //          "searching": false, 
        //          "initComplete": function (settings, json) {  
        //           $("#table_capitalgood").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
        //         },
        //     });

        //     $("div.toolbar").html('');

        //      $.fn.editable.defaults.mode = 'inline';     

        //       //make username editable
        //       $('#username').editable({
        //       emptytext: 'Leer',
        //       });
        // });



        webshims.setOptions('forms-ext', {
            replaceUI: 'auto',
            types: 'number'
        });
        webshims.polyfill('forms forms-ext');

        $('#c').on('update', function(e, editable) {
            alert('new value: ');
        });
    </script>
@stop
