<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <div id="app">
        <!-- top navigation -->
       @include('layouts.mainnav')

        <!-- content with sidebar -->
        <div class="container">
            <div class="row">

                @if (Auth::check())
                    <!-- sidebar navigation -->
                    <div class="col-sm-3">
                        @include('layouts.sidebar')
                    </div> <!-- end sidebar navigation -->
                @endif

                <!-- main content -->
                <div class="col-sm-9">
                    @yield('content')

                </div> <!-- end main content -->
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>

