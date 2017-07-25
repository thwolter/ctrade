<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
    <title>{{ config('app.name', 'Laravel') }}</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,800,800italic">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald:400,300,700">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/mvp-theme/bower_components/fontawesome/css/font-awesome.min.css') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/mvp-theme/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">

    <!-- App CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/mvp-theme/templates/landing/css/mvpready-landing.css') }}">
    <link href="{{ asset('vendor/mvp-theme/bower_components/animate.css/animate.min.css') }}" rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="shortcut icon" href="favicon.ico">
</head>

<body class="layout-fixed  ">

<div id="wrapper">

    @yield('content')

</div> <!-- /#wrapper -->


@yield ('footer')


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Core JS -->
<script src="{{ asset('vendor/mvp-theme/bower_components/jquery/dist/jquery.js') }}"></script>
<script src="{{ asset('vendor/mvp-theme/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script src="http://preview.oklerthemes.com/porto/4.1.0/vendor/jquery.gmap/jquery.gmap.js"></script>


<!-- App JS -->
<script src="{{ asset('vendor/mvp-theme/global/js/mvpready-core.js') }}"></script>
<script src="{{ asset('vendor/mvp-theme/global/js/mvpready-helpers.js') }}"></script>
<script src="{{ asset('vendor/mvp-theme/templates/landing/js/mvpready-landing.js') }}"></script>


</body>
</html>