<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- facicon -->
    <link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.min.css') }}">

    <!--plugins-->
    <link href="{{ asset('css/plugins/plugins.css') }}" rel="stylesheet">

    <!--Custom css-->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/mystyles.css') }}" rel="stylesheet">

    @yield('css.header')

    <!-- Scripts -->
    <script> window.Laravel = {!! json_encode(['csrfToken' => csrf_token(), ]) !!} </script>
    

</head>

<body>
    <div id="preloader">
        <div id="preloader-inner"></div>
    </div><!--/preloader-->

    <div id="app">
        @include('partials.appbar')

        @yield('content')

        @include('partials.footer')

        <!--back to top-->
        <a href="#" class="scrollToTop"><i class="ion-android-arrow-dropup-circle"></i></a>
        <!--back to top end-->
    </div>

    <!-- jQuery plugins. -->
    <script src="{{ asset('vendor/bizwrap/js/plugins/plugins.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    
    <!-- enable Vue -->
    <script src="https://unpkg.com/vue"></script>

    @yield('scripts.footer')
    
</body>
</html>

