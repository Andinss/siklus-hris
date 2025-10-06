
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>PoHuman Resource Management System</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Pondok Laras" />
	<meta name="keywords" content="food, jogja, makanan, pondok laras, pondok, laras, tempat makan" />
	<meta name="author" content="Pondok Laras" />

  

  	<!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<link rel="shortcut icon" href="favicon.ico">

	<link href='https://fonts.googleapis.com/css?family=Playfair+Display:400,700,400italic,700italic|Merriweather:300,400italic,300italic,400,700italic' rel='stylesheet' type='text/css'>
	
	<!-- Font Awesome -->
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	<!-- Animate.css -->
	<link rel="stylesheet" href="{{Config::get('constants.path.css')}}/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="{{Config::get('constants.path.css')}}/icomoon.css">
	<!-- Simple Line Icons -->
	<link rel="stylesheet" href="{{Config::get('constants.path.css')}}/simple-line-icons.css">
	<!-- Datetimepicker -->
	<link rel="stylesheet" href="{{Config::get('constants.path.css')}}/bootstrap-datetimepicker.min.css">
	<!-- Flexslider -->
	<link rel="stylesheet" href="{{Config::get('constants.path.css')}}/flexslider.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="{{Config::get('constants.path.css')}}/bootstrap.css">

	<link rel="stylesheet" href="{{Config::get('constants.path.css')}}/style.css">


	<!-- Modernizr JS -->
	<script src="{{Config::get('constants.path.js')}}/modernizr-2.6.2.min.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="{{Config::get('constants.path.js')}}/respond.min.js"></script>
	<![endif]-->

	</head>
	<body>

	<div id="fh5co-container">
		@yield('content')
	</div>
	
	@include('layouts.home.footer')
	
	<!-- jQuery -->
	<script src="{{Config::get('constants.path.js')}}/jquery.min.js"></script>
	<!-- jQuery Easing -->
	<script src="{{Config::get('constants.path.js')}}/jquery.easing.1.3.js"></script>
	<!-- Bootstrap -->
	<script src="{{Config::get('constants.path.js')}}/bootstrap.min.js"></script>
	<!-- Bootstrap DateTimePicker -->
	<script src="{{Config::get('constants.path.js')}}/moment.js"></script>
	<script src="{{Config::get('constants.path.js')}}/bootstrap-datetimepicker.min.js"></script>
	<!-- Waypoints -->
	<script src="{{Config::get('constants.path.js')}}/jquery.waypoints.min.js"></script>
	<!-- Stellar Parallax -->
	<script src="{{Config::get('constants.path.js')}}/jquery.stellar.min.js"></script>

	<!-- Flexslider -->
	<script src="{{Config::get('constants.path.js')}}/jquery.flexslider-min.js"></script>
	<script>
		$(function () {
	       $('#datereservation').datetimepicker({format: 'YYYY-MM-DD HH:mm:ss'});
	       
	   });


	</script>
	<!-- Main JS -->
	<script src="{{Config::get('constants.path.js')}}/main.js"></script>

	</body>
</html>

