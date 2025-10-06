<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
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

    <!-- Menu CSS -->
    <link href="{{ asset('assets/plugins') }}/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- vector map CSS -->
    <link href="{{ asset('assets/plugins') }}/bower_components/vectormap/jquery-jvectormap-2.0.2.css"
        rel="stylesheet" />
    <link href="{{ asset('assets/plugins') }}/bower_components/css-chart/css-chart.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="{{ asset('assets/css') }}/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('assets/css') }}/style.css" rel="stylesheet">
    <link href="{{ asset('assets/css') }}/custom.css" rel="stylesheet">
    <!-- color CSS -->
    <!-- <link href="{{ asset('assets/css') }}/colors/default.css" id="theme" rel="stylesheet"> -->
    <!-- toastr notifications -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="{{ asset('assets/plugins') }}/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css"
        rel="stylesheet" type="text/css" />

    {{-- confirm --}}
    <link rel="stylesheet" href="{{ asset('assets/plugins') }}/bower_components/jQueryConfirm/jquery-confirm.min.css">
    <link rel="stylesheet" href="{{ asset('assets/plugins') }}/bower_components/jQueryConfirm/jquery-confirm.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <!-- jQuery -->

</head>


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
</style>

<body class="fix-sidebar">
    @include('layouts.editor.header')
    @include('layouts.editor.popup')
    @yield('content')

    @yield('customjs')
    @include('layouts.editor.footer')

    <script src="{{ asset('assets/plugins') }}/bower_components/jquery/dist/jquery.min.js"></script>

    <script src="{{ asset('assets/bootstrap') }}/dist/js/tether.min.js"></script>
    <script src="{{ asset('assets/bootstrap') }}/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('assets/plugins') }}/bower_components/bootstrap-extension/js/bootstrap-extension.min.js">
    </script>
    <!-- Menu Plugin JavaScript -->
    <script src="{{ asset('assets/plugins') }}/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="{{ asset('assets/js') }}/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="{{ asset('assets/js') }}/waves.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('assets/js') }}/custom.min.js"></script>
    <script src="{{ asset('assets/plugins') }}/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
    <script src="{{ asset('assets/plugins') }}/bower_components/jQueryConfirm/jquery-confirm.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        $.ajax({
            'url': '{{ URL::route('editor.popup.checkpopup') }}',
            'cache': false,
            'success': function(response) {
                // let count = Object.keys(response.data).length;
                let isEmpty = response.data === null ? true : false
                if (!isEmpty) {
                    $(".popup").show()
                } else {
                    $(".popup").hide()
                }
            }
        })

        var url = "{{ url()->current() }}"
        if (url.indexOf(url)) {
            $(".popup").hide()
        }

        function log_out() {
            $("#form_logout").submit();
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.16.1/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.2.6/vue.min.js"></script>
    <script src="https://unpkg.com/vuetable-2@1.6.0"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    @yield('js')


    @yield('customjs')
    {{-- @include('layouts.editor.scriptvuetable') --}}

</body>

</html>
