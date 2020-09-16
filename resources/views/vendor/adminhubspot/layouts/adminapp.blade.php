<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta charset="UTF-8">
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="shortcut icon" type="image/ico" href="/favicon.png" />
	<link rel="fluid-icon" type="image/png" href="/favicon.png" />
	<title>{{ ucwords(config('app.name')) }}</title>
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ asset('/plugins/fontawesome-free/css/all.min.css') }}">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Tempusdominus Bbootstrap 4 -->
	<link rel="stylesheet" href="{{ asset('/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
	<!-- iCheck -->
	<link rel="stylesheet" href="{{ asset('/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
	<!-- JQVMap -->
	<link rel="stylesheet" href="{{ asset('/plugins/jqvmap/jqvmap.min.css') }}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{ asset('/dist/css/adminlte.min.css') }}">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="{{ asset('/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="{{ asset('/plugins/daterangepicker/daterangepicker.css') }}">
	<!-- summernote -->
	<link rel="stylesheet" href="{{ asset('/plugins/summernote/summernote-bs4.css') }}">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	
	<!--<link rel="stylesheet" href="{{ asset('/plugins/fselect/fselect.css') }}">-->
	<link rel="stylesheet" href="{{ asset('/plugins/select2/css/select2.min.css') }}">
	
	@yield('stylesheets')
	
	<!-- jQuery -->
	<script src="{{ asset('/plugins/jquery/jquery1.11.3.min.js') }}"></script>
	<!-- jQuery UI 1.11.4 -->
	<script src="{{ asset('/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	
	<!-- Bootstrap 4 -->
	<script src="{{ asset('/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	
	
	@yield('scripts')
	
	<!-- Tempusdominus Bootstrap 4 -->
	<script src="{{ asset('/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
	
	<script src="{{ asset('/plugins/ckeditor/ckeditor/ckeditor.js') }}"></script> 
	
	<!-- AdminLTE App -->
	<script src="{{ asset('/dist/js/adminlte.js') }}"></script>
	
	<!--<script src="{{ asset('/plugins/fselect/fselect.js') }}"></script>-->
	<script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>
	
	
		{{--
	<script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('ckeditor/ckeditor/ckeditor.js') }}"></script> 
    <script src="{{ asset('wptheme/scripts/admin.js') }}"></script>
    --}}
	
</head>
<body class="hold-transition sidebar-mini layout-fixed">
	<div class="wrapper">
		{{-- loading header here --}}
		@include($theme.'.layouts.partials.header')

		{{-- loading sidebar here --}}
		@include($theme.'.layouts.partials.sidebar')
		
		<div class="content-wrapper">
			<section class="content-header">
				<div class="container-fluid">
					@yield('breadcamp')
				</div>
			</section>
			<section class="content">
				<div class="container-fluid">
					@yield('content')
				</div>
			</section>
		</div>

		{{-- loading footer here --}}
		@include($theme.'.layouts.partials.footer')

		
	</div>
	
	<script type="text/javascript">
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
	</script>
</body>
</html>
