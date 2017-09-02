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
    <meta name="author" content="Thomas Wolter">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    {!! Analytics::render() !!}
</head>

<body class="layout-fixed">

<div id="wrapper">

   @if (Auth::check())
        @include('layouts.navigation.appbar')
        @include('layouts.navigation.mainnav')
    @endif

       <div class="content">
           <div class="container">

               @include('partials.message')
               @yield('content')

           </div>
       </div>

</div> <!-- /#wrapper -->

@if (Auth::check())
    @include('layouts.partials.footer')
@endif



<!-- App JS -->

<script src="{{ asset('js/manifest.js') }}"></script>
<script src="{{ asset('js/vendor.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>

@yield('scripts.footer')

</body>
</html>