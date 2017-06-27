@extends('layouts.landing')

@section('content')

    <header class="navbar" role="banner">
        <div class="container">
            <div class="navbar-header">
                <a href="./index.html" class="navbar-brand navbar-brand-img">
                    <img src="{{ asset('vendor/mvp-theme/templates/landing/img/logo.png') }}" alt="MVP Ready">
                </a>

                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <i class="fa fa-bars"></i>
                </button>
            </div> <!-- /.navbar-header -->
            <nav class="collapse navbar-collapse" role="navigation">

                <ul class="nav navbar-nav navbar-right mainnav-menu">
                    <li class="active">
                        <a href="/">Home</a>
                    </li>

                    <li>
                        <a href="#">Blog</a>
                    </li>

                    <li>
                        <a href="#">Kontakt</a>
                    </li>

                    <li>
                        <a href="#">Über uns</a>
                    </li>

                    <li>
                        <a href="{{ route('login') }}">Login</a>
                    </li>

                </ul>

            </nav>
        </div> <!-- /.container -->
    </header>



    <div class="masthead">

        <!-- starts carousel -->

        <div id="masthead-carousel" class="carousel slide carousel-fade masthead-carousel">
            <div class="carousel-inner">

                <div class="item active" style="background-color: #354b5e;">

                    <br class="xs-30 sm-60">

                    <div class="container">

                        <div class="row">

                            <div class="col-md-6 masthead-text animated fadeInDownBig">
                                <h4 class="masthead-title">Don't feel limited to color schemes provided.</h4>

                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Nisi ut aliquip ex ea commodo consequat.
                                </p>

                                <br>

                                <div class="masthead-actions">
                                    <a href="./page-tour.html" class="btn btn-transparent btn-jumbo">
                                        Learn More
                                    </a>

                                    <a href="./account-signup.html" class="btn btn-primary btn-jumbo">
                                        Create an Account
                                    </a>

                                </div> <!-- /.masthead-actions -->

                            </div> <!-- /.masthead-text -->

                            <br class="xs-30 md-0">

                            <div class="col-md-6 masthead-img animated fadeInUpBig">
                                <img src="{{ asset('vendor/mvp-theme/template/landing/img/masthead/mobile.png') }}" alt="slide2" class="img-responsive" />
                            </div> <!-- /.masthead-img -->

                        </div> <!-- /.row -->

                    </div> <!-- /.container -->

                </div> <!-- /.item -->

                <div class="item" style="height: 775px; background-color: #354b5e; background-image: url({{ asset('vendor/mvp-theme/global/img/bg/shattered.png') }});">

                    <br class="xs-30 sm-60">

                    <div class="container">

                        <div class="row">

                            <div class="col-md-10 col-md-offset-1 masthead-text text-center animated fadeIn">
                                <h2 class="masthead-title">Create an Awesome, Engaging Landing Page for Your Next Project!</h2>

                                <div class="masthead-actions">
                                    <a href="./page-tour.html" class="btn btn-transparent btn-jumbo">
                                        Take a Tour
                                    </a>

                                    <a href="./account-signup.html" class="btn btn-primary btn-jumbo">
                                        Get Started Today
                                    </a>

                                </div> <!-- /.masthead-actions -->


                                <br class="xs-50">

                            </div> <!-- /.masthead-text -->

                            <div class="col-md-12 masthead-img animated fadeInUpBig">
                                <img src="{{ asset('vendor/mvp-theme/template/landing/img/masthead/browser.png') }}" alt="slide2" class="img-responsive" />
                            </div> <!-- /.masthead-img -->

                        </div> <!-- /.row -->

                    </div> <!-- /.container -->

                </div> <!-- /.item -->

                <div class="item  " style="background-color: #B74444; background-image: url({{ asset('vendor/mvp-theme/global/img/bg/bright-squares.png') }});">

                    <br class="xs-30 sm-60">

                    <div class="container">

                        <div class="row">

                            <div class="col-md-6 masthead-text animated fadeInLeftBig">
                                <h4 class="masthead-title">Don't feel limited to color schemes provided.</h4>

                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Nisi ut aliquip ex ea commodo consequat.
                                </p>

                                <br>

                                <div class="masthead-actions">
                                    <a href="./page-tour.html" class="btn btn-transparent btn-jumbo">
                                        Learn More
                                    </a>
                                </div> <!-- /.masthead-actions -->
                            </div> <!-- /.masthead-text -->

                            <br class="xs-30 md-0">

                            <div class="col-md-6 masthead-img animated fadeInRightBig">
                                <form class="form masthead-form well">

                                    <h3 class="text-center">Start Your Free Trial!</h3>

                                    <p class="text-center">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus, earum.</p>

                                    <br>

                                    <div class="form-group">
                                        <!-- <label class="" for="full_name">Full Name</label> -->
                                        <input type="text" id="full_name" placeholder="Your Name" class="form-control">
                                    </div> <!-- /.form-group -->

                                    <div class="form-group">
                                        <!-- <label class="" for="email_address">Email Address</label> -->
                                        <input type="text" id="email_address" placeholder="Your Email" class="form-control">
                                    </div> <!-- /.form-group -->

                                    <div class="form-group">
                                        <!-- <label class="" for="organization">Organization</label> -->
                                        <input type="text" id="organization" placeholder="Organization Name" class="form-control">
                                    </div> <!-- /.form-group -->

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-secondary btn-jumbo btn-block">Get Started Today!</button>
                                    </div> <!-- /.form-group -->

                                </form>

                                <br class="xs-80">
                            </div> <!-- /.masthead-img -->

                        </div> <!-- /.row -->

                    </div> <!-- /.container -->

                </div> <!-- /.item -->

            </div>  <!-- /.carousel-inner -->
            <!-- Carousel nav -->


            <div class="container">
                <div class="carousel-controls">
                    <a class="carousel-control left" href="#masthead-carousel" data-slide="prev">&lsaquo;</a>
                    <a class="carousel-control right" href="#masthead-carousel" data-slide="next">&rsaquo;</a>
                </div>
            </div>

        </div> <!-- /.masthead-carousel -->

    </div> <!-- /.masthead -->



    <div class="content">

        <section id="section-features" class="home-section">

            <br class="sm-30">

            <div class="container">

                <div class="heading-block heading-minimal heading-center">
                    <h1>
                        Why Choose MVP Ready?
                    </h1>
                </div> <!-- /.heading-block -->


                <div class="feature-lg">

                    <div class="row">

                        <div class="col-sm-6">
                            <figure class="feature-figure"><img src="./img/homepage-features/feature-1.png" class="img-responsive figure-shadow center-block"  style="width: 90%;" alt=""></figure>
                        </div><!-- /.col -->

                        <div class="col-sm-6">

                            <br class="xs-30 sm-0">

                            <div class="feature-content">
                                <h3>Measure everything with a few clicks</h3>
                                <p class="lead">Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis.</p>     <ul class="icons-list">
                                    <li>
                                        <i class="icon-li fa fa-check text-primary"></i>
                                        Voloratati andigen daepeditem quiate
                                    </li>
                                    <li>
                                        <i class="icon-li fa fa-check text-primary"></i>
                                        Laceaque quiae sitiorem
                                    </li>
                                    <li>
                                        <i class="icon-li fa fa-check text-primary"></i>
                                        Tumquam core posae
                                    </li>
                                </ul>
                                <a href="./page-tour.html" class="btn btn-default">Learn More</a>
                            </div> <!-- /.feature-content -->
                        </div><!-- /.col -->

                    </div> <!-- /.row -->

                </div> <!-- /.feature-lg -->


                <br class="xs-50 sm-100">


                <div class="feature-lg figure-right">

                    <div class="row">

                        <div class="col-sm-6 col-sm-push-6">
                            <figure class="feature-figure"><img src="{{ asset('vendor/mvp-theme/template/landing/img/homepage-features/feature-4.png') }}" class="img-responsive figure-shadow center-block"  style="width: 90%;" alt=""></figure>
                        </div><!-- /.col -->

                        <div class="col-sm-6 col-sm-pull-6">

                            <br class="xs-30 sm-0">

                            <div class="feature-content">
                                <h3>Phasellus fermentum in dolor tesque facilisi</h3>

                                <p class="lead">Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis.</p>
                                <ul class="icons-list">
                                    <li>
                                        <i class="icon-li fa fa-check text-primary"></i>
                                        Tumquam core posae volor remped modis volor
                                    </li>
                                    <li>
                                        <i class="icon-li fa fa-check text-primary"></i>
                                        Non restibusaes dem tumquam
                                    </li>
                                    <li>
                                        <i class="icon-li fa fa-check text-primary"></i>
                                        Modipsae que lib voloratati andigen daepeditem
                                    </li>
                                </ul>
                                <a href="./page-tour.html" class="btn btn-default">Learn More</a>
                            </div> <!-- /.feature-content -->
                        </div><!-- /.col -->

                    </div> <!-- /.row -->

                </div> <!-- /.feature-lg -->


                <br class="xs-50 sm-100">


                <div class="feature-lg">

                    <div class="row">

                        <div class="col-sm-6">
                            <figure class="feature-figure"><img src="{{ asset('vendor/mvp-theme/template/landing/img/homepage-features/feature-2.png') }}" class="img-responsive figure-shadow center-block"  style="width: 90%;" alt=""></figure>
                        </div><!-- /.col -->

                        <div class="col-sm-6">
                            <br class="xs-30 sm-0">

                            <div class="feature-content">
                                <h3>Phasellus fermentum in dolor tesque facilisi</h3>

                                <p class="lead">Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis.</p>
                                <ul class="icons-list">
                                    <li>
                                        <i class="icon-li fa fa-check text-primary"></i>
                                        Tumquam core posae volor remped modis volor
                                    </li>
                                    <li>
                                        <i class="icon-li fa fa-check text-primary"></i>
                                        Non restibusaes dem tumquam
                                    </li>
                                    <li>
                                        <i class="icon-li fa fa-check text-primary"></i>
                                        Modipsae que lib voloratati andigen daepeditem
                                    </li>
                                </ul>
                                <a href="./page-tour.html" class="btn btn-default">Learn More</a>
                            </div> <!-- /.feature-content -->
                        </div><!-- /.col -->

                    </div> <!-- /.row -->

                </div> <!-- /.feature-lg -->

            </div> <!-- /.container -->

        </section>




        <section id="section-benefits" class="home-section" style="background-color: #f3f3f3;">

            <div class="container">

                <div class="heading-block heading-minimal heading-center">
                    <h1>
                        Great Features & Benefits
                    </h1>
                </div> <!-- /.heading-block -->


                <div class="row">

                    <div class="col-sm-4">
                        <div class="feature-sm">
                            <i class="fa fa-anchor feature-sm-icon text-secondary"></i>

                            <h3 class="feature-sm-label">Consectetur adipisicing</h3>

                            <p class="feature-sm-content">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                quis nostrud exercitation.
                            </p>
                        </div> <!-- /.feature-sm -->
                    </div> <!-- /.col -->

                    <div class="col-sm-4">
                        <div class="feature-sm">
                            <i class="fa fa-ils feature-sm-icon text-secondary"></i>

                            <h3 class="feature-sm-label">Dolore magna aliqua</h3>

                            <p class="feature-sm-content">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                quis nostrud exercitation.
                            </p>
                        </div> <!-- /.feature-sm -->
                    </div> <!-- /.col -->

                    <div class="col-sm-4">
                        <div class="feature-sm">
                            <i class="fa fa-gift feature-sm-icon text-secondary"></i>

                            <h3 class="feature-sm-label">Minim veniam</h3>

                            <p class="feature-sm-content">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                quis nostrud exercitation.
                            </p>
                        </div> <!-- /.feature-sm -->
                    </div> <!-- /.col -->

                </div> <!-- /.row -->



                <div class="row">

                    <div class="col-sm-4">
                        <div class="feature-sm">
                            <i class="fa fa-code feature-sm-icon text-secondary"></i>

                            <h3 class="feature-sm-label">Nostrud exercitation</h3>

                            <p class="feature-sm-content">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                quis nostrud exercitation.
                            </p>
                        </div> <!-- /.feature-sm -->
                    </div> <!-- /.col -->

                    <div class="col-sm-4">
                        <div class="feature-sm">
                            <i class="fa fa-comments-o feature-sm-icon text-secondary"></i>

                            <h3 class="feature-sm-label">Sed do eiusmod</h3>

                            <p class="feature-sm-content">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                quis nostrud exercitation.
                            </p>
                        </div> <!-- /.feature-sm -->
                    </div> <!-- /.col -->

                    <div class="col-sm-4">
                        <div class="feature-sm">
                            <i class="fa fa-cloud-download feature-sm-icon text-secondary"></i>

                            <h3 class="feature-sm-label">Adipisicing elit</h3>

                            <p class="feature-sm-content">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                quis nostrud exercitation.
                            </p>
                        </div> <!-- /.feature-sm -->
                    </div> <!-- /.col -->

                </div> <!-- /.row -->



                <div class="row">

                    <div class="col-sm-4">
                        <div class="feature-sm">
                            <i class="fa fa-crosshairs feature-sm-icon text-secondary"></i>

                            <h3 class="feature-sm-label">Quis nostrud exercitation</h3>

                            <p class="feature-sm-content">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                quis nostrud exercitation.
                            </p>
                        </div> <!-- /.feature-sm -->
                    </div> <!-- /.col -->

                    <div class="col-sm-4">
                        <div class="feature-sm">
                            <i class="fa fa-rocket feature-sm-icon text-secondary"></i>

                            <h3 class="feature-sm-label">Incididunt ut labore</h3>

                            <p class="feature-sm-content">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                quis nostrud exercitation.
                            </p>
                        </div> <!-- /.feature-sm -->
                    </div> <!-- /.col -->

                    <div class="col-sm-4">
                        <div class="feature-sm">
                            <i class="fa fa-star feature-sm-icon text-secondary"></i>

                            <h3 class="feature-sm-label">Enim ad minim</h3>

                            <p class="feature-sm-content">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                quis nostrud exercitation.
                            </p>
                        </div> <!-- /.feature-sm -->
                    </div> <!-- /.col -->

                </div> <!-- /.row -->

            </div> <!-- /.container -->

        </section>



        <section id="section-testimonials" class="home-section">

            <div class="container">

                <div class="heading-block heading-minimal heading-center">
                    <h1>
                        Trusted by Thousands
                    </h1>
                </div> <!-- /.heading-block -->

                <ul class="clients-list">
                    <li>
                        <img src="{{ asset('vendor/mvp-theme/global/img/clients/logo1-grayscale.png') }}" class="img-responsive" alt="Client Logo">
                    </li>
                    <li>
                        <img src="{{ asset('vendor/mvp-theme/global/img/clients/logo2-grayscale.png') }}" class="img-responsive" alt="Client Logo">
                    </li>
                    <li>
                        <img src="{{ asset('vendor/mvp-theme/global/img/clients/logo3-grayscale.png') }}" class="img-responsive" alt="Client Logo">
                    </li>
                    <li>
                        <img src="{{ asset('vendor/mvp-theme/global/img/clients/logo4-grayscale.png') }}" class="img-responsive" alt="Client Logo">
                    </li>
                </ul>

                <br class="xs-60">


                <div class="row">

                    <div class="col-sm-4">

                        <div class="testimonial">

                            <div class="testimonial-icon bg-secondary">
                                <i class="fa fa-quote-left"></i>
                            </div> <!-- /.testimonial-icon -->

                            <div class="testimonial-content">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                consequat. Duis aute irure dolor in reprehenderit.
                            </div> <!-- /.testimonial-content -->

                            <div class="testimonial-author">
                                <div class="testimonial-image"><img alt="" src="../../global/img/avatars/avatar-3-md.jpg"></div>

                                <div class="testimonial-author-info">
                                    <h5><a href="#">Adelle Charles</a></h5> @adellecharles
                                </div>
                            </div> <!-- /.testimonial-author -->

                        </div> <!-- /.testimonial -->

                        <br class="xs-30">

                    </div> <!-- /.col -->

                    <div class="col-sm-4">

                        <div class="testimonial">

                            <div class="testimonial-icon bg-secondary">
                                <i class="fa fa-quote-left"></i>
                            </div> <!-- /.testimonial-icon -->

                            <div class="testimonial-content">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                consequat. Duis aute irure dolor in reprehenderit.
                            </div> <!-- /.testimonial-content -->

                            <div class="testimonial-author">
                                <div class="testimonial-image"><img alt="" src="{{ asset('vendor/mvp-theme/global/img/avatars/avatar-4-md.jpg') }}"></div>

                                <div class="testimonial-author-info">
                                    <h5><a href="#">Peter Landt</a></h5> @peterlandt
                                </div>
                            </div> <!-- /.testimonial-author -->

                        </div> <!-- /.testimonial -->

                        <br class="xs-30">

                    </div> <!-- /.col -->

                    <div class="col-sm-4">

                        <div class="testimonial">

                            <div class="testimonial-icon bg-secondary">
                                <i class="fa fa-quote-left"></i>
                            </div> <!-- /.testimonial-icon -->

                            <div class="testimonial-content">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                consequat. Duis aute irure dolor in reprehenderit.
                            </div> <!-- /.testimonial-content -->

                            <div class="testimonial-author">
                                <div class="testimonial-image"><img alt="" src="{{ asset('vendor/mvp-theme/global/img/avatars/avatar-5-md.jpg') }}"></div>

                                <div class="testimonial-author-info">
                                    <h5><a href="#">Enda Nasution</a></h5> @enda
                                </div>
                            </div> <!-- /.testimonial-author -->

                        </div> <!-- /.testimonial -->

                    </div> <!-- /.col -->

                </div> <!-- /.row -->

            </div> <!-- /.container -->

        </section>






        <section id="section-contact" class="home-section" style="background-color: #f3f3f3; padding-top: 35px; padding-bottom: 35px;">

            <div class="container">

                <div class="row">
                    <div class="col-sm-8">
                        <h2>Try out 30-days trial</h2>
                        <p class="lead">Dolor sit amet, consectetur adipiscing elit. Aliquam ornare egestas eros, et scelerisque tortor venenatis condimentum. Nunc mattis feugiat justo vel faucibus. </p>
                    </div>

                    <div class="col-sm-4 text-center">
                        <br class="xs-30">

                        Fully compatible:
                        &nbsp;&nbsp;
                        <i class="fa fa-mobile fa-2x"></i>
                        &nbsp;&nbsp;
                        <i class="fa fa-tablet fa-2x"></i>
                        &nbsp;&nbsp;
                        <i class="fa fa-desktop fa-2x"></i>

                        <br class="xs-20">

                        <a href="./page-pricing-plans.html" class="btn btn-primary btn-lg">&nbsp;&nbsp;&nbsp;&nbsp;Signup Today!&nbsp;&nbsp;&nbsp;&nbsp;</a>
                    </div>
                </div>

            </div> <!-- /.container -->

        </section>

    </div> <!-- /.content -->


</div> <!-- /#wrapper -->

@endsection


@section('footer')

    <footer class="footer">

        <div class="container">

            <div class="row">

                <div class="col-sm-3">

                    <div class="heading-block">
                        <h4>MVP Ready</h4>
                    </div> <!-- /.heading-block -->

                    <p>Aliquam fringilla, sapien egetferas scelerisque placerat, lorem libero cursus lorem, sed sodales lorem libero eu sapien. Nunc mattis feugiat justo vel faucibus. Nulla consequat feugiat malesuada.</p>

                    <p>Placerat, lorem libero cursus lorem, sed sodales lorem libero eu sapien</p>
                </div> <!-- /.col -->


                <div class="col-sm-3">

                    <div class="heading-block">
                        <h4>Keep In Touch</h4>
                    </div> <!-- /.heading-block -->

                    <ul class="icons-list">
                        <li>
                            <i class="icon-li fa fa-home"></i>
                            123 Northwest Way <br>
                            Las Vegas, NV 89183
                        </li>

                        <li>
                            <i class="icon-li fa fa-phone"></i>
                            +1 702 123 4567
                        </li>

                        <li>
                            <i class="icon-li fa fa-envelope"></i>
                            <a href="mailto:info@mvpready.com">info@mvpready.com</a>
                        </li>
                        <li>
                            <i class="icon-li fa fa-map-marker"></i>
                            <a href="javascript:;">View Map</a>
                        </li>
                    </ul>
                </div> <!-- /.col -->


                <div class="col-sm-3">

                    <div class="heading-block">
                        <h4>Connect With Us</h4>
                    </div> <!-- /.heading-block -->

                    <ul class="icons-list">

                        <li>
                            <i class="icon-li fa fa-facebook"></i>
                            <a href="javascript:;">Facebook</a>
                        </li>

                        <li>
                            <i class="icon-li fa fa-twitter"></i>
                            <a href="javascript:;">Twitter</a>
                        </li>

                        <li>
                            <i class="icon-li fa fa-soundcloud"></i>
                            <a href="javascipt:;">Sound Cloud</a>
                        </li>

                        <li>
                            <i class="icon-li fa fa-google-plus"></i>
                            <a href="javascript:;">Google Plus</a>
                        </li>
                    </ul>

                </div> <!-- /.col -->


                <div class="col-sm-3">

                    <div class="heading-block">
                        <h4>Stay Updated</h4>
                    </div> <!-- /.heading-block -->

                    <p>Get emails about new theme launches &amp;  future updates.</p>

                    <form action="/" class="form">

                        <div class="form-group">
                            <!-- <label>Email: <span class="required">*</span></label> -->
                            <input class="form-control" id="newsletter_email" name="newsletter_email" type="text" value="" required="" placeholder="Email Address">
                        </div> <!-- /.form-group -->

                        <div class="form-group">
                            <button class="btn btn-transparent">Subscribe Me</button>
                        </div> <!-- /.form-group -->

                    </form>

                </div> <!-- /.col -->

            </div> <!-- /.row -->

        </div> <!-- /.container -->

    </footer>
    <footer class="copyright">
        <div class="container">

            <div class="row">

                <div class="col-sm-12">
                    <p>Copyright &copy; 2013-15 <a href="javascript:;">Jumpstart Themes</a>.</p>
                </div> <!-- /.col -->

            </div> <!-- /.row -->

        </div>
    </footer>

@endsection