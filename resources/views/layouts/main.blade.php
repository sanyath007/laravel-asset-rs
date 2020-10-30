<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Asset Management System</title>

	<link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">

	<!-- Compiled and minified CSS -->
  	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css"> -->
	<!-- <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/> -->
	<link rel="stylesheet" href="{{ asset('/css/select2.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/css/bootstrap-datepicker.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/css/daterangepicker.css') }}">
	<link rel="stylesheet" href="{{ asset('/bower/fullcalendar/dist/fullcalendar.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/bower/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/bower/ng-tags-input/ng-tags-input.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/bower/AngularJS-Toaster/toaster.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/bower/angular-xeditable/dist/css/xeditable.css') }}">
	<!-- Tags Input -->
	<!-- <link href="{{ asset('/css/bootstrap-tagsinput.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/bootstrap-tagsinput-typeahead.css') }}" rel="stylesheet"> -->
	<!-- <link rel="stylesheet" href="{{ asset('/css/theme.css') }}"> -->

	<!-- Ionicons -->
  	<link rel="stylesheet" href="{{ asset('/css/ionicons.min.css') }}">
  	<!-- jQuery jvectormap -->
  	<link rel="stylesheet" href="{{ asset('/css/jquery-jvectormap.css') }}">
  	<!-- Theme style -->
  	<link rel="stylesheet" href="{{ asset('/css/AdminLTE.min.css') }}">
 	<!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
  	<link rel="stylesheet" href="{{ asset('/css/skins/_all-skins.min.css') }}">
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/balloon-css/0.5.0/balloon.min.css">
	<!-- Fonts -->
	<!-- <link rel='stylesheet' href='//fonts.googleapis.com/css?family=Roboto:400,300' type='text/css'> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Inline Style -->
	<style type="text/css">
		.has-error .select2-selection {
		    border-color:#a94442;
		    -webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);
		    box-shadow:inset 0 1px 1px rgba(0,0,0,.075)
		}
	</style>
	
	<!-- Scripts -->
	<script src="{{ asset('/js/env.js') }}"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="{{ asset('/bower/angular/angular.min.js') }}"></script>
	<script src="{{ asset('/bower/moment/moment.js') }}"></script>
    <script src="{{ asset('/bower/fullcalendar/dist/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('/bower/fullcalendar/dist/locale/th.js') }}"></script>
	<script src="{{ asset('/bower/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
	<script src="{{ asset('/bower/ng-tags-input/ng-tags-input.min.js') }}"></script>
	<script src="{{ asset('/bower/angular-animate/angular-animate.min.js') }}"></script>
	<script src="{{ asset('/bower/AngularJS-Toaster/toaster.min.js') }}"></script>
	<script src="{{ asset('/bower/angular-xeditable/dist/js/xeditable.js') }}"></script>
	<script src="{{ asset('/bower/angular-modal-service/dst/angular-modal-service.min.js') }}"></script>
	<script src="{{ asset('/bower/underscore/underscore-min.js') }}"></script>
	<!-- Tags Input -->
	<!-- <script src="{{ asset('/js/bootstrap-tagsinput.min.js') }}"></script> -->
	<!-- <script src="{{ asset('/js/bootstrap-tagsinput-angular.min.js') }}"></script> -->
	<!-- jQuery-UI -->
	<script src="{{ asset('/js/jquery-ui.min.js') }}"></script>
	<!-- Other -->
	<script src="{{ asset('/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
	<script src="{{ asset('/js/select2.full.min.js') }}"></script>
	<script src="{{ asset('/js/daterangepicker.js') }}"></script>
	<script src="{{ asset('/js/bootstrap-datepicker.min.js') }}"></script>
	<script src="{{ asset('/js/bootstrap-datepicker-custom.js') }}"></script>
	<script src="{{ asset('/js/locales/bootstrap-datepicker.th.js') }}"></script>
	<script src="{{ asset('/js/jquery.knob.min.js') }}"></script>
	<script src="{{ asset('/js/fastclick.js') }}"></script>
	<script src="{{ asset('/js/thaibath.js') }}"></script>
	<!-- Highcharts -->
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="http://code.highcharts.com/highcharts-more.js"></script>	
	<!-- AdminLTE App -->
	<script src="{{ asset('/js/adminlte.min.js') }}"></script>
	<!-- AngularJS Components -->
	<script src="{{ asset('/js/main.js') }}"></script>
	<script src="{{ asset('/js/controllers/mainCtrl.js') }}"></script>
	<script src="{{ asset('/js/controllers/homeCtrl.js') }}"></script>
	<script src="{{ asset('/js/controllers/assetCtrl.js') }}"></script>
	<script src="{{ asset('/js/controllers/assetCateCtrl.js') }}"></script>
	<script src="{{ asset('/js/controllers/assetTypeCtrl.js') }}"></script>	
	<script src="{{ asset('/js/controllers/supplierCtrl.js') }}"></script>
	<script src="{{ asset('/js/controllers/accountCtrl.js') }}"></script>
	<script src="{{ asset('/js/controllers/reportCtrl.js') }}"></script>
	<script src="{{ asset('/js/controllers/approveCtrl.js') }}"></script>
	<script src="{{ asset('/js/controllers/paymentCtrl.js') }}"></script>
	<!--<script src="{{ asset('/js/directives/highcharts.js') }}"></script>-->
	<script src="{{ asset('/js/services/report.js') }}"></script>
	<script src="{{ asset('/js/services/stringFormat.js') }}"></script>
	<script src="{{ asset('/js/services/pagination.js') }}"></script>

	<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
	<!--<script src="{{ asset('/js/services/dashboard.js') }}"></script>-->
	<!-- AdminLTE for demo purposes -->
	<!--<script src="{{ asset('/js/services/demo.js') }}"></script>-->

</head>
<!-- To set sidebar mini style on init use .sidebar-collapse to body tag -->
<body class="skin-blue hold-transition sidebar-mini" ng-app="app" ng-controller="mainCtrl"> 
	<div class="wrapper">
		<!-- header -->		
		@include('layouts.header')		

		<!-- sidebar -->
		@include('layouts.sidebar')

		<!-- Content Wrapper. Contains page content -->
  		<div class="content-wrapper">

				@yield('content')

				<toaster-container></toaster-container>
				
		</div><!-- /.content-wrapper -->

	  	<!-- Footer -->
		@include('layouts.footer')

		<!-- Control Sidebar -->
		@include('layouts.control-sidebar')

	</div><!-- ./wrapper -->
</body>
</html>
