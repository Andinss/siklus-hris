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
		<link rel="icon" href="{{ asset('uploads') }}/preference/{{ $preference->logo }}" type="image/x-icon" />
		<link rel="shortcut icon" href="{{ asset('uploads') }}/preference/{{ $preference->logo }}" type="image/x-icon" />
		<link rel="apple-touch-icon" href="{{ asset('uploads') }}/preference/{{ $preference->logo }}" />

		<title>SIKLUS HRIS - Login</title>

		{{-- Google font - Inter --}}
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700;900&display=swap" rel="stylesheet">

		<!-- Bootstrap Core CSS -->
		<link href="{{ asset('assets/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
		<link href="{{ asset('assets/plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css') }}"
			rel="stylesheet">

		<!-- animation CSS -->
		<link href="{{ asset('assets/css/animate.css') }}/" rel="stylesheet">

		<!-- Daterange picker -->
		<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

		<!-- jQuery -->
		<script src="{{ asset('assets/plugins') }}/bower_components/jquery/dist/jquery.min.js"></script>

		<script type="text/javascript">
			const basepath = '{{ Request::root() }}';
			const baseURL = "{{ url('/') }}";

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
		</script>

		<!-- Custom Theme JavaScript -->
		<script src="{{ asset('assets/js') }}/custom.js"></script>

		<!-- Custom CSS -->
		{{-- <link href="{{ asset('assets/css') }}/style.css" rel="stylesheet"> --}}
		{{-- @vite(['resources/sass/style.scss', 'resources/js/app.js']) --}}
		<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
		<script src="{{ asset('assets/js/app.js') }}"></script>
	</head>

	<body>
		<div class="bg-auth" style="background-image: url('{{ asset('assets') }}/img/auth-bg.jpg')"></div>

		<div class="preloader">
			<img src="{{ asset('assets') }}/img/loader.svg" class="circular" alt="loader.svg" />
		</div>

		@yield('content')

		<script>
			$(function() {
				$("#togglePassword").on('click', function(e) {
					let thisEl = $(this);
					let ariaHidden = thisEl.attr('aria-hidden');
					let target = thisEl.attr('aria-target');

					if (ariaHidden === 'false') {
						$(target).attr('type', 'text');
						thisEl.attr('aria-hidden', 'true');
					} else {
						$(target).attr('type', 'password');
						thisEl.attr('aria-hidden', 'false');
					}
				});
			})
		</script>

		<!-- Iconify -->
		<script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
		<script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>

		<!-- Bootstrap Core JavaScript -->
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

		<!--Style Switcher -->
		<script src="{{ asset('assets/plugins') }}/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js"></script>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
		<script>
			const get_date = new Date();
			let get_full_year = get_date.getFullYear();
			$("span.appCopyright").text(get_full_year);
		</script>

	</body>

</html>
