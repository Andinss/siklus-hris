<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="">
    <link href="{{ asset('assets/plugins') }}/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/plugins') }}/images/favicon.png">
    <title>SIKLUS HRIS | @yield('title')</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('assets/bootstrap') }}/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('assets/plugins') }}/bower_components/bootstrap-extension/css/bootstrap-extension.css"
        rel="stylesheet">
    <link href="{{ asset('assets/plugins') }}/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet"
        type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet"
        type="text/css" />

    <link href="{{ asset('assets/plugins') }}/bower_components/Magnific-Popup-master/dist/magnific-popup.css"
        rel="stylesheet">

    <!-- Menu CSS -->
    <link href="{{ asset('assets/plugins') }}/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- vector map CSS -->
    <link href="{{ asset('assets/plugins') }}/bower_components/vectormap/jquery-jvectormap-2.0.2.css"
        rel="stylesheet" />
    <link href="{{ asset('assets/plugins') }}/bower_components/css-chart/css-chart.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="{{ asset('assets/css') }}/animate.css" rel="stylesheet">
    <link href="{{ asset('assets/plugins') }}/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('assets/css') }}/style.css" rel="stylesheet">
    <!-- <link href="{{ asset('assets/css') }}/custom.css" rel="stylesheet"> -->
    <!-- color CSS -->
    <!-- <link href="{{ asset('assets/css') }}/colors/default.css" id="theme" rel="stylesheet"> -->
    <!-- toastr notifications -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">


    <!--Style Switcher -->
    {{-- <script src="{{asset('assets/plugins')}}//bower_components/styleswitcher/jQuery.style.switcher.js"></script> --}}
    <!-- jQuery 2.2.3 -->
    <script src="{{ asset('assets/plugins') }}/jQuery/jquery-2.2.3.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    {{-- <script src="{{asset('assets/plugins')}}/jQueryUI/jquery-ui.min.js"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css"
        rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js">
    </script>


    <style type="text/css">
        .data-table-pagination {
            margin-top: 20px;
            border-top: 2px solid #eee;
            padding-top: 20px;
        }

        .vuetable-pagination-info {
            font-size: 1.8rem;
            padding-bottom: 10px;
        }

        .text-padding-behavior {
            padding: 5px !important;
            margin-top: 20px !important;
        }

        /* Loading Animation: */
        .data-table {
            opacity: 1;
            position: relative;
            filter: alpha(opacity=100);
            /* IE8 and earlier */
        }

        .data-table.loading {
            opacity: 0.5;
            transition: opacity .3s ease-in-out;
            -moz-transition: opacity .3s ease-in-out;
            -webkit-transition: opacity .3s ease-in-out;
        }

        .data-table.loading:after {
            position: absolute;
            content: '';
            top: 40%;
            left: 50%;
            margin: -30px 0 0 -30px;
            border-radius: 100%;
            -webkit-animation-fill-mode: both;
            animation-fill-mode: both;
            border: 4px solid #42A5F5;
            height: 60px;
            width: 60px;
            background: transparent !important;
            display: inline-block;
            -webkit-animation: pulse 1s 0s ease-in-out infinite;
            animation: pulse 1s 0s ease-in-out infinite;
        }

        @keyframes pulse {
            0% {
                -webkit-transform: scale(0.6);
                transform: scale(0.6);
            }

            50% {
                -webkit-transform: scale(1);
                transform: scale(1);
                border-width: 12px;
            }

            100% {
                -webkit-transform: scale(0.6);
                transform: scale(0.6);
            }
        }
    </style>

    <style type="text/css">
        .modal {
            text-align: center;
            padding: 0 !important;
        }

        .modal:before {
            content: '';
            display: inline-block;
            height: 100%;
            vertical-align: middle;
            margin-right: -4px;
        }

        .modal-dialog {
            display: inline-block;
            text-align: left;
            vertical-align: middle;
        }

        .panel-blue a,
        .panel-info a {
            color: #ffffff;
        }
    </style>
</head>


<body class="fix-sidebar">

    @include('layouts.editor.header')
    @include('layouts.editor.popup')

    @yield('content')
    @yield('popup')
    @yield('scripts')

    @include('layouts.editor.footer')
    <!-- jQuery -->

    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <script src="{{ asset('assets/plugins') }}/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="{{ asset('assets/plugins') }}/bower_components/datatables/jquery.dataTables.min.js"></script>

    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('assets/bootstrap') }}/dist/js/tether.min.js"></script>
    <script src="{{ asset('assets/bootstrap') }}/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('assets/plugins') }}/bower_components/bootstrap-extension/js/bootstrap-extension.min.js">
    </script>
    <!-- Menu Plugin JavaScript -->
    <script src="{{ asset('assets/plugins') }}/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>

    <script src="{{ asset('assets/js') }}/jquery.PrintArea.js" type="text/JavaScript"></script>
    <script>
        $(document).ready(function() {
            $("#print").click(function() {
                var mode = 'iframe'; //popup
                var close = mode == "popup";
                var options = {
                    mode: mode,
                    popClose: close
                };
                $("div.printableArea").printArea(options);
            });
        });
    </script>
    <!--slimscroll JavaScript -->
    <script src="{{ asset('assets/js') }}/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="{{ asset('assets/js') }}/waves.js"></script>
    <!-- Flot Charts JavaScript -->
    <script src="{{ asset('assets/plugins') }}/bower_components/flot/jquery.flot.js"></script>
    <script src="{{ asset('assets/plugins') }}/bower_components/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
    <!-- google maps api -->
    <script src="{{ asset('assets/plugins') }}/bower_components/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="{{ asset('assets/plugins') }}/bower_components/vectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- Sparkline charts -->
    <script src="{{ asset('assets/plugins') }}/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
    <!-- EASY PIE CHART JS -->
    <script src="{{ asset('assets/plugins') }}/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js">
    </script>
    <script src="{{ asset('assets/plugins') }}/bower_components/jquery.easy-pie-chart/easy-pie-chart.init.js"></script>
    <script src="{{ asset('assets/plugins') }}/bower_components/Magnific-Popup-master/dist/jquery.magnific-popup.min.js">
    </script>
    <script src="{{ asset('assets/plugins') }}/bower_components/Magnific-Popup-master/dist/jquery.magnific-popup-init.js">
    </script>
    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('assets/plugins') }}/bower_components/waypoints/lib/jquery.waypoints.js"></script>
    <script src="{{ asset('assets/plugins') }}/bower_components/counterup/jquery.counterup.min.js"></script>
    <script src="{{ asset('assets/js') }}/custom.min.js"></script>
    {{-- <script src="{{asset('assets/js')}}/widget.js"></script> --}}
    <script src="{{ asset('assets/plugins') }}/bower_components/custom-select/custom-select.min.js" type="text/javascript">
    </script>
    <script src="{{ asset('assets/plugins') }}/bower_components/bootstrap-select/bootstrap-select.min.js"
        type="text/javascript"></script>
    {{-- <script src="{{asset('assets/js')}}/dashboard2.js"></script>  --}}
    <script>
        $(".select2").select2();
        $(document).ready(function() {
            $('#myTable').DataTable();
            $(document).ready(function() {
                var table = $('#example').DataTable({
                    "columnDefs": [{
                        "visible": false,
                        "targets": 2
                    }],
                    "order": [
                        [2, 'asc']
                    ],
                    "displayLength": 25,
                    "drawCallback": function(settings) {
                        var api = this.api();
                        var rows = api.rows({
                            page: 'current'
                        }).nodes();
                        var last = null;

                        api.column(2, {
                            page: 'current'
                        }).data().each(function(group, i) {
                            if (last !== group) {
                                $(rows).eq(i).before(
                                    '<tr class="group"><td colspan="5">' + group +
                                    '</td></tr>'
                                );

                                last = group;
                            }
                        });
                    }
                });

                // Order by the grouping
                $('#example tbody').on('click', 'tr.group', function() {
                    var currentOrder = table.order()[0];
                    if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                        table.order([2, 'desc']).draw();
                    } else {
                        table.order([2, 'asc']).draw();
                    }
                });
            });
        });

        function log_out() {
            $("#form_logout").submit();
        }
    </script>
    <script src="{{ asset('assets/plugins') }}/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
    {{-- <script src="https://cdn.datatables.net/fixedcolumns/3.2.3/js/dataTables.fixedColumns.min.js"></script> --}}
    <script src="{{ asset('assets/plugins') }}/bower_components/jQueryConfirm/jquery-confirm.min.js"></script>
    {{-- toastr --}}
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    {{-- <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


    <!-- Sparkline chart JavaScript -->
    <script src="{{ asset('assets/plugins') }}/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="{{ asset('assets/plugins') }}/bower_components/jquery-sparkline/jquery.charts-sparkline.js"></script>
    <script src="{{ asset('assets/plugins') }}/bower_components/toast-master/js/jquery.toast.js"></script>

    <!--Style Switcher -->
    <script src="{{ asset('assets/plugins') }}/bower_components/styleswitcher/jQuery.style.switcher.js"></script>

    {{-- Windows Open --}}
    <script src="{{ asset('assets/js') }}/windows-open.js"></script>

    {{-- <script src="https://cdn.datatables.net/fixedcolumns/3.2.3/js/dataTables.fixedColumns.min.js"></script> --}}

</body>

</html>
