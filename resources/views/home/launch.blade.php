<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html lang="en" class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Launch - {{ config('app.name', 'CapMyRisk.com') }}</title>

    <!-- Google Font: Open Sans -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,800,800italic">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald:400,300,700">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/mvp-theme/bower_components/fontawesome/css/font-awesome.min.css') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/mvp-theme/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('vendor/mvp-theme/bower_components/vegas/dist/jquery.vegas.min.css') }}">

    <link rel="stylesheet" href="{{ asset('vendor/mvp-theme/templates/launch/css/mvpready-launch.css') }}">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="shortcut icon" href="favicon.ico">
</head>

<body class="">


<div class="countdown-wrapper">

    <header style="color: white;">CapMyRisk.com</header>

    <main>

        <div class="content">

            <div class="intro">
                <h2>
                    Unsere Webseite ist fast fertig!
                </h2>

                <h4 class="">Bitte vergiss nicht, dich zu registrieren.</h4>
            </div>

            <div class="counter">

                <h3 class="text-primary">Hey, nur noch ein paar Tage</h3>

                <ul class="countdown list-inline">
                    <li>
                        <span class="days">00</span>
                        <span class="days_ref">Tage</span>
                    </li>
                    <li>
                        <span class="hours">00</span>
                        <span class="hours_ref">Stunden</span>
                    </li>
                    <li>
                        <span class="minutes">00</span>
                        <span class="minutes_ref">Minuten</span>
                    </li>
                    <li>
                        <span class="seconds">00</span>
                        <span class="seconds_ref">Sekunden</span>
                    </li>
                </ul>

            </div> <!-- /.counter -->

        </div> <!-- /.content -->

        <form role="form" class="newsletter" method="post" action="{{ route('taker.subscribe') }}">

            {{ csrf_field() }}

            <h3 class="">Wir lassen dich wissen, wenn's los geht!</h3>

            <div class="input-group">
                <input type="text" class="form-control" placeholder="Email-Addresse" required="" value=""
                       name="email" id="email">
                <span class="input-group-btn">
            <button type="submit" class="btn btn-primary" value="Subscribe" name="subscribe">Registrieren</button>
        </span>
            </div>
        </form> <!-- /.newsletter-form -->

    </main>

    <footer>
       <div></div>
    </footer>

</div> <!-- /.wrapper -->

<!-- Core JS -->
<script src="{{ asset('vendor/mvp-theme/bower_components/jquery/dist/jquery.js') }}"></script>
<script src="{{ asset('vendor/mvp-theme/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<script src="{{ asset('vendor/mvp-theme/bower_components/vegas/dist/jquery.vegas.min.js') }}"></script>
<script src="{{ asset('vendor/mvp-theme/bower_components/downcount/jquery.downCount.js') }}"></script>

<script src="{{ asset('vendor/mvp-theme/global/js/mvpready-core.js') }}"></script>
<script src="{{ asset('vendor/mvp-theme/global/js/mvpready-helpers.js') }}"></script>
<script src="{{ asset('pages/launch/js/mvpready-launch.js') }}"></script>

</body>
</html>