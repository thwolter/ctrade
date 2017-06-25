<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="{{ config('app.locale') }}" class="no-js"> <!--<![endif]-->
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

    <!-- CSS files -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('css.header')

    <!-- Scripts -->
    <script> window.Laravel = {!! json_encode(['csrfToken' => csrf_token(), ]) !!} </script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
        @yield('content')
        @include('partials.footer')

        <!--back to top-->
        <a href="#" class="scrollToTop"><i class="ion-android-arrow-dropup-circle"></i></a>
        <!--back to top end-->
    </div>

    <!-- jQuery plugins. -->
    <script src="{{ asset('js/app.js') }}"></script>

    @yield('scripts.footer')
    
</body>
</html>

