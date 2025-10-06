 <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{Config::get('constants.path.plugin')}}//images/favicon.png">
    <title>SpinelX - Login</title>
    <!-- Bootstrap Core CSS -->
  <link href="{{Config::get('constants.path.bootstrap2')}}/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{Config::get('constants.path.plugin')}}/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="{{Config::get('constants.path.css')}}/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{Config::get('constants.path.css')}}/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="{{Config::get('constants.path.css')}}/colors/default.css" id="theme" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  </head>
  <body>
  @yield('content')

  <!-- jQuery -->
  <script src="{{Config::get('constants.path.plugin')}}/bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap Core JavaScript -->
  <script src="{{Config::get('constants.path.bootstrap2')}}/dist/js/tether.min.js"></script>
  <script src="{{Config::get('constants.path.bootstrap2')}}/dist/js/bootstrap.min.js"></script>
  <script src="{{Config::get('constants.path.plugin')}}/bower_components/bootstrap-extension/js/bootstrap-extension.min.js"></script>
  <!-- Menu Plugin JavaScript -->
  <script src="{{Config::get('constants.path.plugin')}}/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
  <!--slimscroll JavaScript -->
  <script src="{{Config::get('constants.path.js')}}/jquery.slimscroll.js"></script>
  <!--Wave Effects -->
  <script src="{{Config::get('constants.path.js')}}/waves.js"></script>
  <!-- Custom Theme JavaScript -->
  <script src="{{Config::get('constants.path.js')}}/custom.min.js"></script>
  <!--Style Switcher -->
  <script src="{{Config::get('constants.path.plugin')}}/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


</body>
</html>
