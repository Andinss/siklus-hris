<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="robots" content="noindex">
		<meta name="author" content="PT Catur Jaya Solusi Bersama">
		<meta name="google" content="notranslate" />

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<meta name="keywords" content="Siklus HRIS" />
		<meta name="description" content="Siklus HRIS">

		{{-- No Cache --}}
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Expires" content="0" />

		{{-- THEME --}}
		<meta name="theme-color" content="#1445d9" />
		<meta name="msapplication-navbutton-color" content="#1445d9" />
		<meta name="apple-mobile-web-app-status-bar-style" content="#1445d9" />

		{{-- CSRF --}}
		<meta name="csrf-token" content="{{ csrf_token() }}" />

		{{-- ICON --}}
		<link rel="icon" href="{{ asset('uploads') }}/images/favicon.png" type="image/x-icon" />
		<link rel="shortcut icon" href="{{ asset('uploads') }}/images/favicon.png" type="image/x-icon" />
		<link rel="apple-touch-icon" href="{{ asset('uploads') }}/images/favicon.png" />

		<title>SIKLUS HRIS | @yield('title')</title>

		{{-- Google font - Inter --}}
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700;900&display=swap" rel="stylesheet">

		<!-- Bootstrap Core CSS -->
		{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.1/normalize.min.css">
		<link href="{{ asset('assets/bootstrap') }}/dist/css/bootstrap.min.css" rel="stylesheet">
		<link href="{{ asset('assets/plugins') }}/bower_components/bootstrap-extension/css/bootstrap-extension.css"
			rel="stylesheet"> --}}

		{{-- Datatables --}}
		<link href="{{ asset('assets/plugins') }}/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet"
			type="text/css" />
		<link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet"
			type="text/css" />

		{{-- Magnific popup? --}}
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

		<!-- toastr notifications -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
		<link href="{{ asset('assets/plugins') }}/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
				<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
				<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
				<![endif]-->

		{{-- Daterange picker --}}
		<link href="{{ asset('assets/plugins') }}/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css"
			rel="stylesheet" type="text/css" />

		{{-- Custom select --}}
		<link href="{{ asset('assets/plugins') }}/bower_components/custom-select/custom-select.css" rel="stylesheet"
			type="text/css" />
		<link href="{{ asset('assets/plugins') }}/bower_components/bootstrap-select/bootstrap-select.min.css"
			rel="stylesheet" />

		{{-- Jquery confirm --}}
		<link rel="stylesheet" href="{{ asset('assets/plugins') }}/bower_components/jQueryConfirm/jquery-confirm.min.css">
		<link rel="stylesheet" href="{{ asset('assets/plugins') }}/bower_components/jQueryConfirm/jquery-confirm.min.css">
		<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

		<!-- jQuery -->
		<script src="{{ asset('assets/plugins') }}/bower_components/jquery/dist/jquery.min.js"></script>
		<script src="{{ asset('assets/plugins') }}/bower_components/datatables/jquery.dataTables.min.js"></script>

		{{-- Bootstrap --}}
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
			integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
			integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
		</script>

		<!-- Leaflet -->
		<link rel="stylesheet" href="https://npmcdn.com/leaflet@0.7.7/dist/leaflet.css" />

		<script type="text/javascript">
			const basepath = '{{ Request::root() }}';
			const baseURL = "{{ url('/') }}";

			$('[data-toggle="tooltip"]').tooltip();
			$('[data-bs-toggle="tooltip"]').tooltip();
			$('[data-toggle="popover"]').popover();
			$('[data-bs-toggle="popover"]').popover();

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
		</script>

		<!-- Custom Theme JavaScript -->
		<script src="{{ asset('assets/js') }}/custom.js"></script>

		<!-- Custom CSS -->
		{{-- <link href="{{ asset('assets/build/assets/css') }}/style.css" rel="stylesheet"> --}}
		{{-- @vite(['resources/sass/style.scss', 'resources/js/app.js']) --}}
		<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
		<script src="{{ asset('assets/js/app.js') }}"></script>
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

	<body class="on-preloader">
		<div class="preloader">
			<img src="{{ asset('assets') }}/img/loader.svg" class="circular" alt="loader.svg" />
		</div>

		<div class="page-content">
			@include('layouts.editor.nav-navbar')
			{{-- @include('layouts.editor.popup') --}}
			<div class="content sidebar-open">
				@include('layouts.editor.nav-sidebar')
				@yield('content')
				@yield('popup')
				{{-- @include('layouts.editor.footer') --}}
			</div>
			<footer class="footer text-center">&copy;2025 Siklus HRIS - All rights reserved</footer>
		</div>
		@yield('scripts')

		<!-- jQuery -->
		<script src="{{ asset('assets/plugins') }}/bower_components/jquery/dist/jquery.min.js"></script>
		<script src="{{ asset('assets/plugins') }}/bower_components/datatables/jquery.dataTables.min.js"></script>

		<!-- Iconify -->
		<script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
		<script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>

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
		{{-- <script src="{{ asset('assets/bootstrap') }}/dist/js/tether.min.js"></script>
		<script src="{{ asset('assets/bootstrap') }}/dist/js/bootstrap.min.js"></script>
		<script src="{{ asset('assets/plugins') }}/bower_components/bootstrap-extension/js/bootstrap-extension.min.js">
		</script> --}}

		<!-- Menu Plugin JavaScript -->
		<script src="{{ asset('assets/plugins') }}/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>

		{{-- Print area --}}
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

				$(".toggle-sidebar").on('click', function(e) {
					e.preventDefault();

					let thisEl = $(this);
					let isExpanded = thisEl.attr('aria-expanded');
					let iconEl = thisEl.find(".iconify");

					if (isExpanded === 'true') {
						$(".page-content .content").removeClass('sidebar-open');
						$(".toggle-sidebar").attr('aria-expanded', false);
						iconEl.attr("data-icon", "ri:sidebar-unfold-line");
					} else {
						$(".page-content .content").addClass('sidebar-open');
						$(".toggle-sidebar").attr('aria-expanded', true);
						iconEl.attr("data-icon", "ri:sidebar-fold-line");
					}
				})
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

		{{-- <script src="{{asset('assets/js/widget.js')}}"></script> --}}

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

		{{-- Daterange picker --}}
		<script src="{{ asset('assets/plugins') }}/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>

		{{-- <script src="https://cdn.datatables.net/fixedcolumns/3.2.3/js/dataTables.fixedColumns.min.js"></script> --}}

	</body>

</html>
