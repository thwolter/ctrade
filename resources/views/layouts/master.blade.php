<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- CSS files -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/mystyles.css') }}" rel="stylesheet">

    @yield('css.header')

    <!-- Scripts -->
    <script> window.Laravel = {!! json_encode(['csrfToken' => csrf_token(), ]) !!} </script>
    

</head>

<body>

    <div id="app">
        @include('partials.appbar')

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

