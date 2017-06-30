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
    <link rel="stylesheet" href="{{ asset('vendor/mvp-theme/templates/admin-1/css/mvpready-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">


    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>



<div id="wrapper" class="container">
    
    @php( $array = ['1' => 'EUR', '2' => 'USD'] )
   
    <form-wrapper parm="{{ $array }}">
        <input v-model="currency">
        <p>@{{ currency }}</p>
    </form-wrapper>
    
  <tabs>
      
        <tab name="about us">
            <h2>This is the content for about us tab</h2>
        </tab>
      
        <tab name="about our company">
            <h2>This is the content for about our company tab</h2>
        </tab>
  
  </tabs>
  
</div>>




<script src="{{ asset('js/app.js') }}"></script>



<script>

  


</script>


</body>
</html>