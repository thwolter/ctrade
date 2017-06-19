<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>Starter Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('vendor/stkr/css/theme.css') }}" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body id="skrollr-body" data-spy="scroll" data-target=".navbar">
<div class="wrapper wrapper-super">



    <!-- ********************************************************** -->
    <!-- ********************* NAVBAR WRAPPER ********************* -->
    <!-- Wrapper with top-fixed Navbar and navbar-brand for your website name/logo etc -->

    <section class="wrapper wrapper-navbar">
        <nav class="navbar navbar-fixed-top" data-0="background-color:rgba(34,34,34,0);" data-100="background-color:rgba(34,34,34,1);" >
            <div class="container" data-0="padding-top:20px;padding-bottom:20px;" data-100="padding-top:0px;padding-bottom:0px;">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <a class="navbar-brand" href="#skrollr-body" data-0="font-size:1.5em;" data-100="font-size:1em;">STKR</a>
                </div>
                <div id="navbar" class="collapse navbar-collapse pull-right">
                    <ul class="nav navbar-nav">
                        <li><a href="#bck-img1">Portfolio</a></li>
                        <li><a href="#main-content">Content</a></li>
                        <li><a href="#testimonial">Testimonial</a></li>
                        <li><a href="#background-image">Background</a></li>
                        <li><a href="#article">Article</a></li>
                        <li><a href="#pricing">Pricing</a></li>
                        <li><a href="#video">Video</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </section>
    <!-- ********************* NAVBAR WRAPPER END ********************* -->
    <!-- ************************************************************** -->


    <!-- ******************************************************** -->
    <!-- ********************* HERO WRAPPER ********************* -->
    <!-- A large Wrapper with background image and the extra wrapper-hero class. Use this class to add unique "hero-only" styles. The background image uses the skrollr script for parallax effect -->

    <div class="owl-carousel">
        <section class="wrapper wrapper-hero wrapper-lg wrapper-bck-image-full" style="background-image: url(img/hero7.jpg);" data-start="background-position:0% 100%;" data-end="background-position:0% 0%;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h2>Welcome to the Stoker demo site!</h2>
                        <p>
                            Stoker is a lightweight, easy-to-use and friendly HTML 5 template. Based on Bootstrap 3. Comes with Bower and Gulp source files. Use it as starting point for your next landingpag or one pager website project.
                        </p>
                        <div class="col-md-6 col-md-offset-3 col-sm-12">
                            <a href="#" class="btn btn-primary btn-lg btn-block" role="button">Buy now</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="wrapper wrapper-hero wrapper-lg wrapper-bck-image-full" style="background-image: url(img/hero9.jpg);" data-start="background-position:0% 0%;" data-end="background-position:0% 100%;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h2>Welcome to the Stoker demo site!</h2>
                        <p>
                            Stoker is a lightweight, easy-to-use and friendly HTML 5 template. Based on Bootstrap 3. Comes with Bower and Gulp source files. Use it as starting point for your next landingpag or one pager website project.
                        </p>
                        <div class="col-md-6 col-md-offset-3 col-sm-12">
                            <a href="#" class="btn btn-primary btn-lg btn-block" role="button">Buy now</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="wrapper wrapper-hero wrapper-lg wrapper-bck-image-full" style="background-image: url(img/hero10.jpg);" data-start="background-position:0% 0%;" data-end="background-position:0% 100%;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h2>Welcome to the Stoker demo site!</h2>
                        <p>
                            Stoker is a lightweight, easy-to-use and friendly HTML 5 template. Based on Bootstrap 3. Comes with Bower and Gulp source files. Use it as starting point for your next landingpag or one pager website project.
                        </p>
                        <div class="col-md-6 col-md-offset-3 col-sm-12">
                            <a href="#" class="btn btn-primary btn-lg btn-block" role="button">Buy now</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
    <!-- ********************* HERO WRAPPER END ********************* -->
    <!-- ************************************************************ -->


    <!-- ******************************************************** -->
    <!-- ********************* DARK WRAPPER ********************* -->
    <!-- Half colored wrapper with background image on the left - Check the SCSS/CSS file for the section id to change the background image path -->

    <section id="bck-img1" class="wrapper wrapper-dark wrapper-half-left">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-6">
                    <h4>Lorem ipsum dolor sit amet, consetetur</h4>
                    <p>
                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- ********************* DARK WRAPPER END ********************* -->
    <!-- ************************************************************ -->


    <!-- ******************************************************** -->
    <!-- ********************* DARK WRAPPER ********************* -->
    <!-- Half colored wrapper with background image on the right - Check the SCSS/CSS file for the section id to change the background image path -->

    <section id="bck-img2" class="wrapper wrapper-primary wrapper-half-right">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 text-right">
                    <h4>Lorem ipsum dolor sit amet, consetetur</h4>
                    <p>
                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- ********************* DARK WRAPPER END ********************* -->
    <!-- ************************************************************ -->


    <!-- ******************************************************** -->
    <!-- ********************* DARK WRAPPER ********************* -->
    <!-- Half colored wrapper with background image on the left - Check the SCSS/CSS file for the section id to change the background image path -->

    <section id="bck-img3" class="wrapper wrapper-dark wrapper-half-left">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-6">
                    <h4>Lorem ipsum dolor sit amet, consetetur</h4>
                    <p>
                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- ********************* DARK WRAPPER END ************************ -->
    <!-- *************************************************************** -->


    <!-- ******************************************************************* -->
    <!-- ********************* CONTRAST WRAPPER BEGINN ********************* -->
    <!-- Fully colored wrapper with brand-primary background color -->

    <section class="wrapper wrapper-contrast">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="lead">
                        Lorem ipsum dolor sit amet, consetetur sadipscing <a href="#">elitr sed diam nonumy eirmod</a> tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.
                    </p>
                </div>
                <div class="col-md-6">
                    <p class="lead">
                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et <a href="#">dolore magna aliquyam erat</a>, sed diam voluptua.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- ********************* CONTRAST WRAPPER END ********************* -->
    <!-- **************************************************************** -->


    <!-- ****************************************************************** -->
    <!-- ********************* PRIMARY WRAPPER BEGINN ********************* -->
    <!-- A primary wrapper with a typical text based content layout - a main area on the left and a sidebar on the right -->

    <section id="main-content" class="wrapper wrapper-primary">
        <div class="container">
            <div class="row">
                <div class="col-md-7 main-col">
                    <h2>Main Content</h2>
                    <p class="lead">
                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.
                    </p>
                    <p>
                        At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy <a href="#">eirmod tempor</a> invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
                    </p>
                    <p>
                        At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
                    </p>
                    <blockquote>
                        <p>"Sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua."</p>
                    </blockquote>
                </div>
                <div class="col-md-5 sidebar-col ">
                    <h3>The Sidebar</h3>
                    <p>
                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
                    </p>
                    <hr/>
                    <h5>Sub Navigation </h5>
                    <ul class="nav subnav">
                        <li role="presentation" class="active"><a href="#">Home</a></li>
                        <li role="presentation"><a href="#">Profile</a></li>
                        <li role="presentation"><a href="#">Messages</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- ********************* PRIMARY WRAPPER BEGINN ********************* -->
    <!-- ****************************************************************** -->


    <!-- ******************************************************************* -->
    <!-- ********************* CONTRAST WRAPPER BEGINN ********************* -->
    <!-- Another sample contrast wrapper -->

    <section class="wrapper wrapper-contrast">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4>Lorem ipsum dolor sit amet</h4>
                    <p>
                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
                    </p>

                </div>
                <div class="col-md-6">
                    <h4>Lorem ipsum dolor sit amet</h4>
                    <p>
                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- ********************* CONTRAST WRAPPER BEGINN ********************* -->
    <!-- ******************************************************************* -->

    <!-- ******************************************************************* -->
    <!-- ********************* CONTRAST WRAPPER BEGINN ********************* -->
    <!-- Another contrast wrapper but this time it is a small (.wrapper-sm) one -->

    <section class="wrapper wrapper-dark wrapper-sm">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4">
                    <h4>Bootstrap 3</h4>
                    <p>
                        Lorem ipsum dolor sit amet, consetetur <a href="#">sadipscing</a> elitr, sed diam nonumy eirmod tempor invidunt.
                    </p>
                </div>
                <div class="col-md-4">
                    <h4>Gulp and Bower</h4>
                    <p>
                        Lorem ipsum dolor sit amet, <a href="#">consetetur</a> sadipscing elitr, sed diam nonumy eirmod tempor invidunt.
                    </p>
                </div>
                <div class="col-md-4">
                    <h4>HTML5 and CSS3</h4>
                    <p>
                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam <a href="#">nonumy eirmod</a> tempor invidunt .
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- ********************* CONTRAST WRAPPER BEGINN ***************** -->
    <!-- *************************************************************** -->


    <!-- *********************************************************** -->
    <!-- ********************* PRIMARY WRAPPER ********************* -->
    <!-- A primary wrapper with a testimonial sample content -->

    <section id="testimonial" class="wrapper wrapper-primary">
        <div class="container">
            <div class="row">
                <div class="col-md-2 col-md-offset-5 col-xs-6 col-xs-offset-3">
                    <img src="img/testimonial.jpg" class="img-responsive img-circle text-center"/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <blockquote>
                        <p>
                            "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua."
                        </p>
                        <footer>
                            Jane Doe, <cite title="Source Title">Google, Inc</cite>
                        </footer>
                    </blockquote>
                </div>
            </div>
        </div>
    </section>
    <!-- ********************* PRIMARY WRAPPER END ********************* -->
    <!-- *************************************************************** -->


    <!-- ************************************************************************************ -->
    <!-- ********************* SECONDARY WRAPPER  WITH BACKGROUND IMAGE ********************* -->
    <!-- Again an wrapper with full size parallax background image -->
    <section id="background-image" class="wrapper wrapper-secondary wrapper-bck-image-full" style="background-image: url(img/hero9.jpg); background-size:cover;"  data-start="background-position:0% -50%;" data-end="background-position:0% 100%;">
        <div class="container text-center">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <h3>Sample Widget</h3>
                    <p class="lead">
                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.
                    </p>
                    <a href="#" class="btn btn-default btn-lg" role="button">Learn more</a>
                </div>
            </div>
        </div>
    </section>
    <!-- ********************* SECONDARY WRAPPER END ******************* -->
    <!-- *************************************************************** -->


    <!-- *********************************************************** -->
    <!-- ********************* PRIMARY WRAPPER ********************* -->
    <!-- A sample article content wrapper sample centered and used just 50% of the provided space -->

    <section id="article" class="wrapper wrapper-primary">
        <div class="container text-center">
            <div class="row">
                <div class="col-md-6 col-md-offset-3 ">
                    <article>
                        <small>October 2nd, 2015</small>
                        <h2>Sample Article</h2>
                        <hr/>
                        <p>
                            <small>- By Barney Stinson -</small>
                        </p>
                        <p class="lead">
                            Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea.
                        </p>
                        <p>
                            Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
                        </p>
                    </article>
                </div>
            </div>
        </div>
    </section>
    <!-- ********************* PRIMARY WRAPPER END ********************* -->
    <!-- *************************************************************** -->


    <!-- ************************************************************ -->
    <!-- ********************* CONTRAST WRAPPER ********************* -->
    <!-- A half-half colored contrast wrapper with some sort of pricing sample content -->

    <section id="pricing" class="wrapper wrapper-contrast wrapper-sm wrapper-half-left">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 secondary-text-color text-right">
                    <h1>$ 19</h1>
                    <p class="lead">Basic Version</p>
                    <p>
                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
                    </p>
                    <a href="#" class="btn btn-default" role="button">Buy now</a>
                </div>
                <div class="col-xs-6">
                    <h1>$ 64</h1>
                    <p class="lead">Professional Version</p>
                    <p>
                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
                    </p>
                    <a href="#" class="btn btn-default" role="button">Buy now</a>
                </div>
            </div>
        </div>
    </section>
    <!-- ********************* CONTRAST WRAPPER END********************* -->
    <!-- *************************************************************** -->


    <!-- ********************************************************* -->
    <!-- ********************* VIDEO WRAPPER ********************* -->
    <!-- A wrapper with an HTML5 video background -->

    <section id="video" class="wrapper wrapper-vid-bck">
        <div class="video" >
            <video id="self1" class="html5-video player" width="100%"  loop autoplay muted >
                <source src="{{ asset('vendor/stkr/vid/video2.mp4') }}" width="100%" type="video/mp4">
                <source src="{{ asset('vendor/stkr/vid/video2.ogg') }}" width="100%" type="video/ogg">
                Your browser does not support the video tag.
            </video>
        </div>
        <div class="overlay overlay-dark">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 text-center secondary-text-color">
                        <h2>Video background</h2>
                        <p class="lead">
                            At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est.
                        </p>
                        <p>
                            Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ********************* SECONDARY WRAPPER END ******************* -->
    <!-- *************************************************************** -->


    <!-- *********************************************************** -->
    <!-- ********************* PRIMARY WRAPPER ********************* -->
    <!-- Sample content wrapper using some Font Awesome icons -->

    <section class="wrapper wrapper-primary">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h4><i class="fa fa-rebel"></i>  Sample Widget</h4>
                    <p>
                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
                    </p>
                </div>
                <div class="col-md-4">
                    <h4><i class="fa fa-github"></i> Sample Widget</h4>
                    <p>
                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
                    </p>
                </div>
                <div class="col-md-4">
                    <h4><i class="fa fa-wordpress"></i> Sample Widget</h4>
                    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- ********************* PRIMARY WRAPPER END ********************* -->
    <!-- *************************************************************** -->


    <!-- ************************************************************* -->
    <!-- ********************* SECONDARY WRAPPER ********************* -->
    <!-- A full width and small secondary wrapper with centered text -->

    <section class="wrapper wrapper-secondary text-center">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <h3>This is</h3>
                    <p>
                        Lorem ipsum dolor sit amet, consetetur <a href="#">sadipscing elitr, sed</a> diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
                    </p>
                    <a class="btn btn-default" href="#" role="button">Read more</a>
                </div>
                <div class="col-md-3">
                    <h3>a full width</h3>
                    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. </p>
                    <a class="btn btn-default" href="#" role="button">Read more</a>
                </div>
                <div class="col-md-3">
                    <h3>and fluid</h3>
                    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. </p>
                    <a class="btn btn-default" href="#" role="button">Read more</a>
                </div>
                <div class="col-md-3">
                    <h3>content container</h3>
                    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. </p>
                    <a class="btn btn-default" href="#" role="button">Read more</a>
                </div>
            </div>
        </div>
    </section>
    <!-- ********************* SECONDARY WRAPPER END ********************* -->
    <!-- ***************************************************************** -->


    <!-- *********************************************************-->
    <!-- ********************* DARK WRAPPER ********************* -->
    <!-- A small and dark content wrapper for some kind of footer content -->

    <section class="wrapper wrapper-dark wrapper-sm">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h5>Sample Widget</h5>
                    <p>
                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
                    </p>
                </div>
                <div class="col-md-3">
                    <h5>Sample Widget</h5>
                    <p>
                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
                    </p>
                </div>
                <div class="col-md-6">
                    <h5>Contact us</h5>

                    <!-- The contact form -->
                    <form action="php/contact.php" method="post" role="form" data-toggle="validator">

                        <div class="form-group">
                            <label for="inputName" class="control-label">Name</label>
                            <input type="text" name="name" class="form-control"  required ><br>
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group">
                            <label for="inputLastName" class="control-label">Email</label>
                            <input type="email" name="email" class="form-control"  required ><br>
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group">
                            <label for="inputLastName" class="control-label">Your Message</label>
                            <textarea rows="5" name="message" cols="30" class="form-control"  required ></textarea><br>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" value="Submit" class="btn btn-default">
                        </div>
                </div>
                </form>
                <!-- Contact form end -->
            </div>
        </div>
    </section>
    <!-- ********************* DARK WRAPPER END ********************* -->
    <!-- ************************************************************ -->



</div> <!-- super-wrapper ends here - excludes the wrapper-trans below so that the body background color shines through -->



<!-- ********************************************************* -->
<!-- ********************* TRANS WRAPPER ********************* -->
<!-- A small and transparent wrapper (backgound shines through) - for some kind of footer menus/infos -->

<section id="footer" class="wrapper wrapper-trans wrapper-sm">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-xs-6">
                <h5>Menu</h5>
                <ul class="nav subnav">
                    <li role="presentation" class="active"><a href="#">News</a></li>
                    <li role="presentation"><a href="#">Mobile</a></li>
                    <li role="presentation"><a href="#">Blog</a></li>
                </ul>
            </div>
            <div class="col-md-2 col-xs-6">
                <h5>Menu</h5>
                <ul class="nav subnav">
                    <li role="presentation" class="active"><a href="#">Imprint</a></li>
                    <li role="presentation"><a href="#">Twitter</a></li>
                    <li role="presentation"><a href="#">Facebook</a></li>
                    <li role="presentation"><a href="#">Google +</a></li>
                    <li role="presentation"><a href="#">Jobs</a></li>
                    <li role="presentation"><a href="#">Company</a></li>
                </ul>
            </div>
            <div class="col-md-6 col-md-offset-2">
                <h5>Sample Widget</h5>

                <p>
                    Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.  <br/>
                    Designed and developed by <a href="http://www.templatedeck.com" target="_blank">TemplateDeck</a>
                </p>
                <p>
                    <i class="fa fa-github fa-2x"></i> <i class="fa fa-twitter  fa-2x col-md-offset-1"></i> <i class="fa fa-facebook  fa-2x col-md-offset-1"></i> <i class="fa fa-apple  fa-2x col-md-offset-1"></i>
                </p>
            </div>
        </div>
    </div>
</section>
<!-- ********************* TRANS WRAPPER END ********************* -->



<!-- All core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="{{ asset('vendor/stkr/js/jquery.min.js') }}" type="text/javascript"></script> <!-- A must-have - dont remove it! -->
<script src="{{ asset('vendor/stkr/js/bootstrap.min.js') }}" type="text/javascript"></script> <!-- A must-have - dont remove it! -->
<script src="{{ asset('vendor/stkr/js/owl.carousel.min.js') }}" type="text/javascript"></script> <!-- The slider script - remove if you don´t use it -->
<script src="{{ asset('vendor/stkr/js/smoothscroll.min.js') }}" type="text/javascript"></script> <!-- smoothscrolling script - remove if you don´t use it -->
<script src="{{ asset('vendor/stkr/js/skrollr.min.js') }}" type="text/javascript"></script> <!-- The scolling script for parallax effects - remove if you don´t use it -->
<script src="{{ asset('vendor/stkr/js/jquery.particleground.min.js') }}" type="text/javascript"></script> <!-- The script for particle effects - remove if you don´t use it -->
<script src="{{ asset('vendor/stkr/js/validator.min.js') }}" type="text/javascript"></script> <!-- The script for particle effects - remove if you don´t use it -->


<!-- Init the Owl Carousel slider script - remove this code if it is not in use -->
<script type="text/javascript">
    $('.owl-carousel').owlCarousel({
        animateOut: 'fadeOut',
        autoHeight:true,
        items:1,
        loop: true,
        autoplay: true,
        autoplaySpeed: 1500,
        margin:0,
        stagePadding:0,
        smartSpeed:0
    });
</script>

<!-- Init the parallax script - if you don´t load it above remove it here too -->
<script type="text/javascript">
    var s = skrollr.init();
</script>
<script type="text/javascript">
    $('#particle').particleground({
        dotColor: 'rgba(255,255,255,0.15)',
        lineColor: 'rgba(255,255,255,0.15)',
        maxSpeedX: 0.2,
        maxSpeedY: 0.2,
        minSpeedX: 0.005,
        minSpeedY: 0.005
    });
</script>

<!-- Form validation script - use it if contact form is embedded -->

</body>
</html>