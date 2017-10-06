<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Title -->
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Thomas Wolter">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico">

    <!-- Google Fonts -->
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans%3A400%2C300%2C500%2C600%2C700">

    <!-- CSS Global Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/icon-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/icon-line/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/icon-etlinefont/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/icon-line-pro/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/icon-hs/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/dzsparallaxer/dzsparallaxer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/dzsparallaxer/dzsscroller/scroller.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/dzsparallaxer/advancedscroller/plugin.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/hamburgers/hamburgers.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/hs-megamenu/src/hs.megamenu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/slick-carousel/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fancybox/jquery.fancybox.css') }}">
    <!-- CSS Global Compulsory -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/bootstrap.min.css') }}">

    <!-- CSS Unify -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

    <!-- Google Analytics -->
    {!! Analytics::render() !!}
</head>

<body>

<main>

    @include('layouts.navigation.appbar')


    <!-- Promo Block -->
    <section class="dzsparallaxer auto-init height-is-based-on-content use-loading mode-scroll loaded dzsprx-readyall " data-options='{direction: "reverse", settings_mode_oneelement_max_offset: "150"}'>
        <div class="divimage dzsparallaxer--target w-100 g-bg-pos-bottom-center" style="height: 120%; background-image: url({{ asset('assets/img-temp/1920x1080/img25.jpg') }});"></div>

        <div class="container g-py-200 ">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="g-color-black g-font-weight-300 g-font-size-40 g-line-height-1_2 mb-4">Have an easy
                        <br>
                        website with Unify
                    </h3>
                    <span class="d-block g-color-black-opacity-0_8 g-font-size-16 mb-5">Build, share, sell and enjoy.</span>
                    <a class="js-fancybox u-link-v5 g-color-black" href="https://vimeo.com/167434033" title="Single Image">
              <span class="align-middle u-icon-v3 u-block-hover--scale g-bg-white g-color-black g-color-primary--hover g-rounded-50x g-cursor-pointer mr-2">
            <i class="g-font-size-18 g-pos-rel g-left-2 fa fa-play"></i>
          </span>
                        1:41 minutes
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- End Promo Block -->


    <!-- About -->
    <section id="about-section" class="g-pt-100 g-pb-100">
        <div class="container">
            <!-- Image, Text Block -->
            <div class="row d-flex align-items-lg-center flex-wrap g-mb-60 g-mb-0--lg">
                <div class="col-md-6 col-lg-8">
                    <img class="img-fluid rounded" src="{{ asset('assets/img-temp/900x600/img1.jpg') }}" alt="Image Description">
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="g-mt-minus-30 g-mt-0--md g-ml-minus-100--lg">
                        <div class="g-mb-20">
                            <h2 class="g-color-black g-font-weight-600 g-font-size-25 g-font-size-35--lg g-line-height-1_2 mb-4">Finding the
                                <br>
                                Perfect Product
                            </h2>
                            <p class="g-font-size-16">This is where we sit down, grab a cup of coffee and dial in the details. Understanding the task at hand and ironing out the wrinkles is key.</p>
                        </div>

                        <a class="btn u-btn-primary g-brd-2 g-brd-white g-font-size-13 g-rounded-50 g-pl-20 g-pr-15 g-py-9" href="#">
                            More products
                            <span class="align-middle u-icon-v3 g-width-16 g-height-16 g-color-black g-bg-white g-font-size-11 rounded-circle ml-3">
              <i class="fa fa-angle-right"></i>
            </span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- End Image, Text Block -->
        </div>

        <div class="container">
            <!-- Image, Text Block -->
            <div class="row d-flex justify-content-between align-items-lg-center flex-wrap g-mt-minus-50--lg">
                <div class="col-md-6 flex-md-unordered">
                    <div class="g-brd-around--md g-brd-10 g-brd-white rounded">
                        <img class="img-fluid w-100 rounded" src="{{ asset('assets/img-temp/600x450/img1.jpg" alt="Image Description') }}">
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 ml-auto flex-md-first">
                    <div class="g-mt-minus-30 g-mt-0--md g-ml-minus-100--lg">
                        <div class="g-mb-20">
                            <h2 class="g-color-black g-font-weight-600 g-font-size-25 g-font-size-35--lg g-line-height-1_2 mb-4">More than
                                <br>
                                a Stunning Look
                            </h2>
                            <p class="g-font-size-16">This is where we sit down, grab a cup of coffee and dial in the details. Understanding the task at hand and ironing out the wrinkles is key.</p>
                        </div>

                        <a class="btn u-btn-primary g-brd-2 g-brd-white g-font-size-13 g-rounded-50 g-pl-20 g-pr-15 g-py-9" href="#">
                            Read more
                            <span class="align-middle u-icon-v3 g-width-16 g-height-16 g-color-black g-bg-white g-font-size-11 rounded-circle ml-3">
              <i class="fa fa-angle-right"></i>
            </span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- End Image, Text Block -->
        </div>
    </section>
    <!-- End About -->


    <!-- Icon Blocks -->
    <section id="offers-section" class="g-bg-secondary">
        <div class="container g-pt-100 g-pb-130">
            <!-- Icon Blocks -->
            <div class="row no-gutters">
                <div class="col-sm-6 col-lg-3">
                    <div class="g-pr-40 g-mt-20">
                        <div class="g-mb-30">
                            <h2 class="h2 g-color-black g-font-weight-600 g-line-height-1_2 mb-4">What can
                                <br>
                                we provide?
                            </h2>
                            <p class="g-font-weight-300 g-font-size-16">The time has come to bring those ideas and plans to life. This is where we really begin to visualize your napkin sketches and make them into beautiful pixels.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div id="we-provide" class="js-carousel" data-infinite="true" data-slides-show="3" data-slides-scroll="3" data-center-mode="true" data-center-padding="1px" data-pagi-classes="u-carousel-indicators-v1 g-absolute-centered--x g-bottom-minus-30">
                        <div class="js-slide">
                            <!-- Icon Blocks -->
                            <div class="u-shadow-v21--hover g-brd-around g-brd-gray-light-v3 g-brd-left-none g-brd-transparent--hover g-bg-white--hover g-transition-0_3 g-cursor-pointer g-px-30 g-pt-30 g-pb-50 g-ml-minus-1">
                                <div class="mb-4">
                                    <span class="d-block g-color-gray-dark-v4 g-font-weight-700 text-right mb-3">01</span>
                                    <span class="u-icon-v3 u-shadow-v19 g-bg-white g-color-primary rounded-circle mb-4">
                  <i class="icon-education-087 u-line-icon-pro"></i>
                </span>
                                    <h3 class="h5 g-color-black g-font-weight-600 mb-3">Creative</h3>
                                    <p>This is where we sit down, grab a cup of coffee and dial in the details.</p>
                                </div>
                                <a class="g-brd-bottom g-brd-gray-dark-v5 g-brd-primary--hover g-color-gray-dark-v5 g-color-primary--hover g-font-weight-600 g-font-size-12 text-uppercase g-text-underline--none--hover" href="#">Read more</a>
                            </div>
                            <!-- End Icon Blocks -->
                        </div>

                        <div class="js-slide">
                            <!-- Icon Blocks -->
                            <div class="u-shadow-v21--hover g-brd-around g-brd-gray-light-v3 g-brd-left-none g-brd-transparent--hover g-bg-white--hover g-transition-0_3 g-cursor-pointer g-px-30 g-pt-30 g-pb-50 g-ml-minus-1">
                                <div class="mb-4">
                                    <span class="d-block g-color-gray-dark-v4 g-font-weight-700 text-right mb-3">02</span>
                                    <span class="u-icon-v3 u-shadow-v19 g-bg-white g-color-primary rounded-circle mb-4">
                  <i class="icon-education-035 u-line-icon-pro"></i>
                </span>
                                    <h3 class="h5 g-color-black g-font-weight-600 mb-3">Features</h3>
                                    <p>This is where we sit down, grab a cup of coffee and dial in the details.</p>
                                </div>
                                <a class="g-brd-bottom g-brd-gray-dark-v5 g-brd-primary--hover g-color-gray-dark-v5 g-color-primary--hover g-font-weight-600 g-font-size-12 text-uppercase g-text-underline--none--hover" href="#">Read more</a>
                            </div>
                            <!-- End Icon Blocks -->
                        </div>

                        <div class="js-slide">
                            <!-- Icon Blocks -->
                            <div class="u-shadow-v21--hover g-brd-around g-brd-gray-light-v3 g-brd-left-none g-brd-transparent--hover g-bg-white--hover g-transition-0_3 g-cursor-pointer g-px-30 g-pt-30 g-pb-50 g-ml-minus-1">
                                <div class="mb-4">
                                    <span class="d-block g-color-gray-dark-v4 g-font-weight-700 text-right mb-3">03</span>
                                    <span class="u-icon-v3 u-shadow-v19 g-bg-white g-color-primary rounded-circle mb-4">
                  <i class="icon-education-141 u-line-icon-pro"></i>
                </span>
                                    <h3 class="h5 g-color-black g-font-weight-600 mb-3">Responsive</h3>
                                    <p>This is where we sit down, grab a cup of coffee and dial in the details.</p>
                                </div>
                                <a class="g-brd-bottom g-brd-gray-dark-v5 g-brd-primary--hover g-color-gray-dark-v5 g-color-primary--hover g-font-weight-600 g-font-size-12 text-uppercase g-text-underline--none--hover" href="#">Read more</a>
                            </div>
                            <!-- End Icon Blocks -->
                        </div>

                        <div class="js-slide">
                            <!-- Icon Blocks -->
                            <div class="u-shadow-v21--hover g-brd-around g-brd-gray-light-v3 g-brd-left-none g-brd-transparent--hover g-bg-white--hover g-transition-0_3 g-cursor-pointer g-px-30 g-pt-30 g-pb-50 g-ml-minus-1">
                                <div class="mb-4">
                                    <span class="d-block g-color-gray-dark-v4 g-font-weight-700 text-right mb-3">04</span>
                                    <span class="u-icon-v3 u-shadow-v19 g-bg-white g-color-primary rounded-circle mb-4">
                  <i class="icon-finance-256 u-line-icon-pro"></i>
                </span>
                                    <h3 class="h5 g-color-black g-font-weight-600 mb-3">Code</h3>
                                    <p>This is where we sit down, grab a cup of coffee and dial in the details.</p>
                                </div>
                                <a class="g-brd-bottom g-brd-gray-dark-v5 g-brd-primary--hover g-color-gray-dark-v5 g-color-primary--hover g-font-weight-600 g-font-size-12 text-uppercase g-text-underline--none--hover" href="#">Read more</a>
                            </div>
                            <!-- End Icon Blocks -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Icon Blocks -->
        </div>
    </section>
    <!-- End Icon Blocks -->


    <!-- Mockup Block -->
    <section class="container g-py-100">
        <div class="text-center g-mb-50">
            <h2 class="h1 g-color-black g-font-weight-600">Multifanctional Magic</h2>
            <p class="lead">This is where we begin to visualize your napkin sketches and make them into pixels.</p>
        </div>

        <div class="row">
            <div class="col-md-3 g-mb-30">
          <span class="u-icon-v3 g-color-cyan g-bg-cyan-opacity-0_1 rounded-circle g-mb-25">
        <i class="icon-education-089 u-line-icon-pro"></i>
      </span>

                <div class="d-inline-block g-width-70 g-height-2 g-bg-cyan g-pos-rel g-top-5 g-right-minus-25 g-mr-minus-20"></div>

                <h2 class="h5 g-color-black g-font-weight-600 mb-3">Design is Functional</h2>
                <p>Now that we've aligned the details, it's time to get things mapped out and organized.</p>
            </div>

            <div class="col-md-6 g-mb-30">
                <img class="img-fluid" src="{{ asset('assets/img-temp/899x631/img1.png') }}" alt="Image Description">
            </div>

            <div class="col-md-3 mt-auto g-mb-30">
                <div class="d-inline-block g-width-70 g-height-2 g-bg-red g-pos-rel g-top-5 g-left-minus-25 g-mr-minus-20"></div>

                <span class="u-icon-v3 g-color-red g-bg-red-opacity-0_1 rounded-circle g-mb-25">
        <i class="icon-education-088 u-line-icon-pro"></i>
      </span>
                <h2 class="h5 g-color-black g-font-weight-600 mb-3">More than 200+ features</h2>
                <p>We aim high at being focused on building relationships with our clients and community.</p>
            </div>
        </div>
    </section>
    <!-- End Mockup Block -->


    <!-- Blog Grid Blocks -->
    <div id="news-section" class="g-bg-secondary">
        <div class="container g-pt-100 g-pb-70">
            <div class="text-center g-mb-50">
                <h2 class="h1 g-color-black g-font-weight-600">Daily News</h2>
                <p class="lead">Follow the latest news, blogs and articles.</p>
            </div>

            <div class="masonry-grid row">
                <div class="masonry-grid-sizer col-sm-1"></div>

                <div class="masonry-grid-item col-sm-12 col-lg-8 g-mb-30">
                    <!-- Blog Grid Modern Blocks -->
                    <article class="row align-items-stretch no-gutters u-shadow-v21 u-shadow-v21--hover g-transition-0_3">
                        <div class="col-md-6 g-bg-white g-rounded-left-5">
                            <div class="g-pa-60">
                                <ul class="list-inline g-color-gray-dark-v4 g-font-weight-600 g-font-size-12">
                                    <li class="list-inline-item mr-0">Alex Teseira</li>
                                    <li class="list-inline-item mx-2">&#183;</li>
                                    <li class="list-inline-item">5 June 2017</li>
                                </ul>

                                <h2 class="h5 g-color-black g-font-weight-600 mb-4">
                                    <a class="u-link-v5 g-color-black g-color-primary--hover g-cursor-pointer" href="#">Announcing a free plan for small teams</a>
                                </h2>
                                <p class="g-color-gray-dark-v4 g-line-height-1_8 mb-4">At Wake, our mission has always been focused on bringing openness and transparency to the design process.</p>

                                <ul class="list-inline g-font-size-12 mb-0">
                                    <li class="list-inline-item g-mb-10">
                                        <a class="u-tags-v1 g-color-lightred g-bg-lightred-opacity-0_1 g-bg-lightred--hover g-color-white--hover g-rounded-50 g-py-4 g-px-15" href="#">Start-Up</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-6 g-bg-size-cover g-bg-pos-center g-min-height-300 g-rounded-right-5" data-bg-img-src="{{ asset('assets/img-temp/400x500/img1.jpg') }}"></div>
                    </article>
                    <!-- End Blog Grid Modern Blocks -->
                </div>

                <div class="masonry-grid-item col-sm-6 col-lg-4 g-mb-30">
                    <!-- Blog Grid Modern Blocks -->
                    <article class="u-shadow-v21 u-shadow-v21--hover g-transition-0_3">
                        <img class="img-fluid w-100 g-rounded-top-5" src="{{ asset('assets/img-temp/400x270/img1.jpg') }}" alt="Image Description">

                        <div class="g-bg-white g-pa-30 g-rounded-bottom-5">
                            <ul class="list-inline g-color-gray-dark-v4 g-font-weight-600 g-font-size-12">
                                <li class="list-inline-item mr-0">Alex Teseira</li>
                                <li class="list-inline-item mx-2">&#183;</li>
                                <li class="list-inline-item">7 June 2017</li>
                            </ul>

                            <h2 class="h5 g-color-black g-font-weight-600 mb-4">
                                <a class="u-link-v5 g-color-black g-color-primary--hover g-cursor-pointer" href="#">Exclusive interview with InVision's CEO</a>
                            </h2>

                            <ul class="list-inline g-font-size-12 mb-0">
                                <li class="list-inline-item g-mb-10">
                                    <a class="u-tags-v1 g-color-teal g-bg-teal-opacity-0_1 g-bg-teal--hover g-color-white--hover g-rounded-50 g-py-4 g-px-15" href="#">Art</a>
                                </li>
                                <li class="list-inline-item g-mb-10">
                                    <a class="u-tags-v1 g-color-yellow g-bg-yellow-opacity-0_1 g-bg-yellow--hover g-color-white--hover g-rounded-50 g-py-4 g-px-15" href="#">Design</a>
                                </li>
                            </ul>
                        </div>
                    </article>
                    <!-- End Blog Grid Modern Blocks -->
                </div>

                <div class="masonry-grid-item col-sm-6 col-lg-4 g-mb-30">
                    <!-- Blog Grid Modern Blocks -->
                    <article class="u-shadow-v21 u-shadow-v21--hover g-transition-0_3">
                        <img class="img-fluid w-100 g-rounded-top-5" src="{{ asset('assets/img-temp/400x270/img2.jpg') }}" alt="Image Description">

                        <div class="g-bg-white g-pa-30 g-rounded-bottom-5">
                            <ul class="list-inline g-color-gray-dark-v4 g-font-weight-600 g-font-size-12">
                                <li class="list-inline-item mr-0">Alex Teseira</li>
                                <li class="list-inline-item mx-2">&#183;</li>
                                <li class="list-inline-item">4 June 2017</li>
                            </ul>

                            <h2 class="h5 g-color-black g-font-weight-600 mb-4">
                                <a class="u-link-v5 g-color-black g-color-primary--hover g-cursor-pointer" href="#">Accessibility - Apple</a>
                            </h2>

                            <ul class="list-inline g-font-size-12 mb-0">
                                <li class="list-inline-item g-mb-10">
                                    <a class="u-tags-v1 g-color-bluegray g-bg-bluegray-opacity-0_1 g-bg-bluegray--hover g-color-white--hover g-rounded-50 g-py-4 g-px-15" href="#">Apple</a>
                                </li>
                            </ul>
                        </div>
                    </article>
                    <!-- End Blog Grid Modern Blocks -->
                </div>

                <div class="masonry-grid-item col-sm-6 col-lg-4 g-mb-30">
                    <!-- Blog Grid Modern Blocks -->
                    <article class="u-shadow-v21 u-shadow-v21--hover g-transition-0_3 g-bg-primary text-center g-rounded-5 g-pa-30 g-py-100">
                        <span class="g-color-white-opacity-0_8 g-font-size-60 g-line-height-0">&#8220;</span>
                        <h2 class="h3 g-color-white g-font-weight-600 mb-4">In the future, design principles won’t be about design</h2>
                        <h3 class="g-color-white-opacity-0_8 g-font-size-13 text-uppercase">Alex Teseira</h3>
                        <a class="g-link-overlay g-z-index-2" href="#"></a>
                    </article>
                    <!-- End Blog Grid Modern Blocks -->
                </div>

                <div class="masonry-grid-item col-sm-6 col-lg-4 g-mb-30">
                    <!-- Blog Grid Modern Blocks -->
                    <article class="u-shadow-v21 u-shadow-v21--hover g-transition-0_3">
                        <img class="img-fluid w-100 g-rounded-top-5" src="{{ asset('assets/img-temp/400x270/img3.jpg') }}" alt="Image Description">

                        <div class="g-bg-white g-pa-30 g-rounded-bottom-5">
                            <ul class="list-inline g-color-gray-dark-v4 g-font-weight-600 g-font-size-12">
                                <li class="list-inline-item mr-0">Alex Teseira</li>
                                <li class="list-inline-item mx-2">&#183;</li>
                                <li class="list-inline-item">29 May 2017</li>
                            </ul>

                            <h2 class="h5 g-color-black g-font-weight-600 mb-4">
                                <a class="u-link-v5 g-color-black g-color-primary--hover g-cursor-pointer" href="#">Basic Patterns of Mobile Navigation</a>
                            </h2>

                            <ul class="list-inline g-font-size-12 mb-0">
                                <li class="list-inline-item g-mb-10">
                                    <a class="u-tags-v1 g-color-deeporange g-bg-deeporange-opacity-0_1 g-bg-deeporange--hover g-color-white--hover g-rounded-50 g-py-4 g-px-15" href="#">Mobile</a>
                                </li>
                                <li class="list-inline-item g-mb-10">
                                    <a class="u-tags-v1 g-color-teal g-bg-teal-opacity-0_1 g-bg-teal--hover g-color-white--hover g-rounded-50 g-py-4 g-px-15" href="#">Pattern</a>
                                </li>
                            </ul>
                        </div>
                    </article>
                    <!-- End Blog Grid Modern Blocks -->
                </div>

                <div class="masonry-grid-item col-sm-6 col-lg-4 g-mb-30">
                    <!-- Blog Grid Modern Blocks -->
                    <article class="u-shadow-v21 u-shadow-v21--hover g-transition-0_3">
                        <img class="img-fluid w-100 g-rounded-top-5" src="{{ asset('assets/img-temp/400x270/img7.jpg') }}" alt="Image Description">

                        <div class="g-bg-white g-pa-30 g-rounded-bottom-5">
                            <ul class="list-inline g-color-gray-dark-v4 g-font-weight-600 g-font-size-12">
                                <li class="list-inline-item mr-0">Alex Teseira</li>
                                <li class="list-inline-item mx-2">&#183;</li>
                                <li class="list-inline-item">1 June 2017</li>
                            </ul>

                            <h2 class="h5 g-color-black g-font-weight-600 mb-4">
                                <a class="u-link-v5 g-color-black g-color-primary--hover g-cursor-pointer" href="#">#pillow is the color</a>
                            </h2>

                            <ul class="list-inline g-font-size-12 mb-0">
                                <li class="list-inline-item g-mb-10">
                                    <a class="u-tags-v1 g-color-primary g-bg-primary-opacity-0_1 g-bg-primary--hover g-color-white--hover g-rounded-50 g-py-4 g-px-15" href="#">HTML</a>
                                </li>
                            </ul>
                        </div>
                    </article>
                    <!-- End Blog Grid Modern Blocks -->
                </div>

                <div class="masonry-grid-item col-sm-6 col-lg-4 g-mb-30">
                    <!-- Blog Grid Modern Blocks -->
                    <article class="u-shadow-v21 u-shadow-v21--hover g-transition-0_3">
                        <img class="img-fluid w-100 g-rounded-top-5" src="{{ asset('assets/img-temp/400x270/img4.jpg') }}" alt="Image Description">

                        <div class="g-bg-white g-pa-30 g-rounded-bottom-5">
                            <ul class="list-inline g-color-gray-dark-v4 g-font-weight-600 g-font-size-12">
                                <li class="list-inline-item mr-0">Alex Teseira</li>
                                <li class="list-inline-item mx-2">&#183;</li>
                                <li class="list-inline-item">1 June 2017</li>
                            </ul>

                            <h2 class="h5 g-color-black g-font-weight-600 mb-4">
                                <a class="u-link-v5 g-color-black g-color-primary--hover g-cursor-pointer" href="#">A chair for $100</a>
                            </h2>

                            <ul class="list-inline g-font-size-12 mb-0">
                                <li class="list-inline-item g-mb-10">
                                    <a class="u-tags-v1 g-color-teal g-bg-teal-opacity-0_1 g-bg-teal--hover g-color-white--hover g-rounded-50 g-py-4 g-px-15" href="#">Design</a>
                                </li>
                                <li class="list-inline-item g-mb-10">
                                    <a class="u-tags-v1 g-color-yellow g-bg-yellow-opacity-0_1 g-bg-yellow--hover g-color-white--hover g-rounded-50 g-py-4 g-px-15" href="#">Interior</a>
                                </li>
                            </ul>
                        </div>
                    </article>
                    <!-- End Blog Grid Modern Blocks -->
                </div>

                <div class="masonry-grid-item col-sm-6 col-lg-4 g-mb-30">
                    <!-- Blog Grid Modern Blocks -->
                    <article class="u-shadow-v21 u-shadow-v21--hover g-transition-0_3">
                        <img class="img-fluid w-100 g-rounded-top-5" src="{{ asset('assets/img-temp/400x270/img6.jpg') }}" alt="Image Description">

                        <div class="g-bg-white g-pa-30 g-rounded-bottom-5">
                            <ul class="list-inline g-color-gray-dark-v4 g-font-weight-600 g-font-size-12">
                                <li class="list-inline-item mr-0">Alex Teseira</li>
                                <li class="list-inline-item mx-2">&#183;</li>
                                <li class="list-inline-item">1 June 2017</li>
                            </ul>

                            <h2 class="h5 g-color-black g-font-weight-600 mb-4">
                                <a class="u-link-v5 g-color-black g-color-primary--hover g-cursor-pointer" href="#">Stylish office in Manhattan</a>
                            </h2>

                            <ul class="list-inline g-font-size-12 mb-0">
                                <li class="list-inline-item g-mb-10">
                                    <a class="u-tags-v1 g-color-black g-bg-black-opacity-0_1 g-bg-black--hover g-color-white--hover g-rounded-50 g-py-4 g-px-15" href="#">Office</a>
                                </li>
                                <li class="list-inline-item g-mb-10">
                                    <a class="u-tags-v1 g-color-cyan g-bg-cyan-opacity-0_1 g-bg-cyan--hover g-color-white--hover g-rounded-50 g-py-4 g-px-15" href="#">Interior</a>
                                </li>
                            </ul>
                        </div>
                    </article>
                    <!-- End Blog Grid Modern Blocks -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Blog Grid Blocks -->


    <!-- Projects -->
    <section id="projects-section" class="container g-py-100">
        <div class="text-center g-mb-50">
            <h2 class="h1 g-color-black g-font-weight-600">Branding Projects</h2>
            <p class="lead">This is where we begin to visualize your napkin sketches and make them into pixels.</p>
        </div>

        <div class="row no-gutters g-mx-minus-10">
            <div class="col-sm-6 col-lg-4 g-px-10 g-mb-20">
                <!-- Projects -->
                <div class="u-block-hover g-brd-around g-brd-gray-light-v4 g-color-black g-color-white--hover g-bg-purple--hover text-center rounded g-transition-0_3 g-px-30 g-py-50">
                    <img class="img-fluid u-block-hover__main--zoom-v1 mb-5" src="{{ asset('assets/img-temp/425x250/img1.png') }}" alt="Image Description">
                    <span class="g-font-weight-600 g-font-size-12 text-uppercase">Mockups</span>
                    <h3 class="h4 g-font-weight-600 mb-0">Kitchen Tools</h3>
                    <a class="u-link-v2" href="#"></a>
                </div>
                <!-- End Projects -->
            </div>

            <div class="col-sm-6 col-lg-4 g-px-10 g-mb-20">
                <!-- Projects -->
                <div class="u-block-hover g-brd-around g-brd-gray-light-v4 g-color-black g-color-white--hover g-bg-cyan--hover text-center rounded g-transition-0_3 g-px-30 g-py-50">
                    <img class="img-fluid u-block-hover__main--zoom-v1 mb-5" src="{{ asset('assets/img-temp/425x250/img2.png') }}" alt="Image Description">
                    <span class="g-font-weight-600 g-font-size-12 text-uppercase">Others</span>
                    <h3 class="h4 g-font-weight-600 mb-0">Brochure</h3>
                    <a class="u-link-v2" href="#"></a>
                </div>
                <!-- End Projects -->
            </div>

            <div class="col-sm-6 col-lg-4 g-px-10 g-mb-20">
                <!-- Projects -->
                <div class="u-block-hover g-brd-around g-brd-gray-light-v4 g-color-black g-color-white--hover g-bg-teal--hover text-center rounded g-transition-0_3 g-px-30 g-py-50">
                    <img class="img-fluid u-block-hover__main--zoom-v1 mb-5" src="{{ asset('assets/img-temp/425x250/img3.png') }}" alt="Image Description">
                    <span class="g-font-weight-600 g-font-size-12 text-uppercase">Hi-Tech</span>
                    <h3 class="h4 g-font-weight-600 mb-0">MacBook Pro</h3>
                    <a class="u-link-v2" href="#"></a>
                </div>
                <!-- End Projects -->
            </div>

            <div class="col-sm-6 col-lg-4 g-px-10 g-mb-20">
                <!-- Projects -->
                <div class="u-block-hover g-brd-around g-brd-gray-light-v4 g-color-black g-color-white--hover g-bg-lightred--hover text-center rounded g-transition-0_3 g-px-30 g-py-50">
                    <img class="img-fluid u-block-hover__main--zoom-v1 mb-5" src="{{ asset('assets/img-temp/425x250/img4.png') }}" alt="Image Description">
                    <span class="g-font-weight-600 g-font-size-12 text-uppercase">Hi-tech</span>
                    <h3 class="h4 g-font-weight-600 mb-0">Latest VR product</h3>
                    <a class="u-link-v2" href="#"></a>
                </div>
                <!-- End Projects -->
            </div>

            <div class="col-sm-6 col-lg-4 g-px-10 g-mb-20">
                <!-- Projects -->
                <div class="u-block-hover g-brd-around g-brd-gray-light-v4 g-color-black g-color-white--hover g-bg-primary--hover text-center rounded g-transition-0_3 g-px-30 g-py-50">
                    <img class="img-fluid u-block-hover__main--zoom-v1 mb-5" src="{{ asset('assets/img-temp/425x250/img5.png') }}" alt="Image Description">
                    <span class="g-font-weight-600 g-font-size-12 text-uppercase">Others</span>
                    <h3 class="h4 g-font-weight-600 mb-0">Brochure</h3>
                    <a class="u-link-v2" href="#"></a>
                </div>
                <!-- End Projects -->
            </div>

            <div class="col-sm-6 col-lg-4 g-px-10 g-mb-20">
                <!-- Projects -->
                <div class="u-block-hover g-brd-around g-brd-gray-light-v4 g-color-black g-color-white--hover g-bg-pink--hover text-center rounded g-transition-0_3 g-px-30 g-py-50">
                    <img class="img-fluid u-block-hover__main--zoom-v1 mb-5" src="{{ asset('assets/img-temp/425x250/img6.png') }}" alt="Image Description">
                    <span class="g-font-weight-600 g-font-size-12 text-uppercase">Cosmetics</span>
                    <h3 class="h4 g-font-weight-600 mb-0">Spa Cosmetics</h3>
                    <a class="u-link-v2" href="#"></a>
                </div>
                <!-- End Projects -->
            </div>
        </div>
    </section>
    <!-- End Projects -->


    <!-- Call To Action -->
    <section class="g-bg-primary g-color-white g-pa-30" style="background-image: url({{ asset('assets/img/bg/pattern5.png') }});">
        <div class="d-md-flex justify-content-md-center text-center">
            <div class="align-self-md-center">
                <p class="lead g-font-weight-400 g-mr-20--md g-mb-15 g-mb-0--md">We offer best in class service for your needs</p>
            </div>
            <div class="align-self-md-center">
                <a class="btn btn-lg u-btn-white text-uppercase g-font-weight-600 g-font-size-12" target="_blank" href="https://wrapbootstrap.com/theme/unify-responsive-website-template-WB0412697?ref=htmlstream">Purchase Now</a>
            </div>
        </div>
    </section>
    <!-- End Call To Action -->

    <!-- Footer -->
    <div id="contacts-section" class="g-bg-black-opacity-0_9 g-color-white-opacity-0_8 g-py-60">
        <div class="container">
            <div class="row">
                <!-- Footer Content -->
                <div class="col-lg-3 col-md-6 g-mb-40 g-mb-0--lg">
                    <div class="u-heading-v2-3--bottom g-brd-white-opacity-0_8 g-mb-20">
                        <h2 class="u-heading-v2__title h6 text-uppercase mb-0">About Us</h2>
                    </div>

                    <p>About Unify dolor sit amet, consectetur adipiscing elit. Maecenas eget nisl id libero tincidunt sodales.</p>
                </div>
                <!-- End Footer Content -->

                <!-- Footer Content -->
                <div class="col-lg-3 col-md-6 g-mb-40 g-mb-0--lg">
                    <div class="u-heading-v2-3--bottom g-brd-white-opacity-0_8 g-mb-20">
                        <h2 class="u-heading-v2__title h6 text-uppercase mb-0">Latest Posts</h2>
                    </div>

                    <article>
                        <h3 class="h6 g-mb-2">
                            <a class="g-color-white-opacity-0_8 g-color-white--hover" href="#">Incredible template</a>
                        </h3>
                        <div class="small g-color-white-opacity-0_6">May 8, 2017</div>
                    </article>

                    <hr class="g-brd-white-opacity-0_1 g-my-10">

                    <article>
                        <h3 class="h6 g-mb-2">
                            <a class="g-color-white-opacity-0_8 g-color-white--hover" href="#">New features</a>
                        </h3>
                        <div class="small g-color-white-opacity-0_6">June 23, 2017</div>
                    </article>

                    <hr class="g-brd-white-opacity-0_1 g-my-10">

                    <article>
                        <h3 class="h6 g-mb-2">
                            <a class="g-color-white-opacity-0_8 g-color-white--hover" href="#">New terms and conditions</a>
                        </h3>
                        <div class="small g-color-white-opacity-0_6">September 15, 2017</div>
                    </article>
                </div>
                <!-- End Footer Content -->

                <!-- Footer Content -->
                <div class="col-lg-3 col-md-6 g-mb-40 g-mb-0--lg">
                    <div class="u-heading-v2-3--bottom g-brd-white-opacity-0_8 g-mb-20">
                        <h2 class="u-heading-v2__title h6 text-uppercase mb-0">Useful Links</h2>
                    </div>

                    <nav class="text-uppercase1">
                        <ul class="list-unstyled g-mt-minus-10 mb-0">
                            <li class="g-pos-rel g-brd-bottom g-brd-white-opacity-0_1 g-py-10">
                                <h4 class="h6 g-pr-20 mb-0">
                                    <a class="g-color-white-opacity-0_8 g-color-white--hover" href="#">About Us</a>
                                    <i class="fa fa-angle-right g-absolute-centered--y g-right-0"></i>
                                </h4>
                            </li>
                            <li class="g-pos-rel g-brd-bottom g-brd-white-opacity-0_1 g-py-10">
                                <h4 class="h6 g-pr-20 mb-0">
                                    <a class="g-color-white-opacity-0_8 g-color-white--hover" href="#">Portfolio</a>
                                    <i class="fa fa-angle-right g-absolute-centered--y g-right-0"></i>
                                </h4>
                            </li>
                            <li class="g-pos-rel g-brd-bottom g-brd-white-opacity-0_1 g-py-10">
                                <h4 class="h6 g-pr-20 mb-0">
                                    <a class="g-color-white-opacity-0_8 g-color-white--hover" href="#">Our Services</a>
                                    <i class="fa fa-angle-right g-absolute-centered--y g-right-0"></i>
                                </h4>
                            </li>
                            <li class="g-pos-rel g-brd-bottom g-brd-white-opacity-0_1 g-py-10">
                                <h4 class="h6 g-pr-20 mb-0">
                                    <a class="g-color-white-opacity-0_8 g-color-white--hover" href="#">Latest Jobs</a>
                                    <i class="fa fa-angle-right g-absolute-centered--y g-right-0"></i>
                                </h4>
                            </li>
                            <li class="g-pos-rel g-py-10">
                                <h4 class="h6 g-pr-20 mb-0">
                                    <a class="g-color-white-opacity-0_8 g-color-white--hover" href="#">Contact Us</a>
                                    <i class="fa fa-angle-right g-absolute-centered--y g-right-0"></i>
                                </h4>
                            </li>
                        </ul>
                    </nav>
                </div>
                <!-- End Footer Content -->

                <!-- Footer Content -->
                <div class="col-lg-3 col-md-6">
                    <div class="u-heading-v2-3--bottom g-brd-white-opacity-0_8 g-mb-20">
                        <h2 class="u-heading-v2__title h6 text-uppercase mb-0">Our Contacts</h2>
                    </div>

                    <address class="g-bg-no-repeat g-font-size-12 mb-0" style="background-image: url({{ asset('assets/img/maps/map2.png') }});">
                        <!-- Location -->
                        <div class="d-flex g-mb-20">
                            <div class="g-mr-10">
              <span class="u-icon-v3 u-icon-size--xs g-bg-white-opacity-0_1 g-color-white-opacity-0_6">
                <i class="fa fa-map-marker"></i>
              </span>
                            </div>
                            <p class="mb-0">795 Folsom Ave, Suite 600, <br> San Francisco, CA 94107 795</p>
                        </div>
                        <!-- End Location -->

                        <!-- Phone -->
                        <div class="d-flex g-mb-20">
                            <div class="g-mr-10">
              <span class="u-icon-v3 u-icon-size--xs g-bg-white-opacity-0_1 g-color-white-opacity-0_6">
                <i class="fa fa-phone"></i>
              </span>
                            </div>
                            <p class="mb-0">(+123) 456 7890 <br> (+123) 456 7891</p>
                        </div>
                        <!-- End Phone -->

                        <!-- Email and Website -->
                        <div class="d-flex g-mb-20">
                            <div class="g-mr-10">
              <span class="u-icon-v3 u-icon-size--xs g-bg-white-opacity-0_1 g-color-white-opacity-0_6">
                <i class="fa fa-globe"></i>
              </span>
                            </div>
                            <p class="mb-0">
                                <a class="g-color-white-opacity-0_8 g-color-white--hover" href="mailto:info@htmlstream.com">info@htmlstream.com</a>
                                <br>
                                <a class="g-color-white-opacity-0_8 g-color-white--hover" href="#">www.htmlstream.com</a>
                            </p>
                        </div>
                        <!-- End Email and Website -->
                    </address>
                </div>
                <!-- End Footer Content -->
            </div>
        </div>
    </div>
    <!-- End Footer -->

    <!-- Copyright Footer -->
    <footer class="g-bg-gray-dark-v1 g-color-white-opacity-0_8 g-py-20">
        <div class="container">
            <div class="row">
                <div class="col-md-8 text-center text-md-left g-mb-10 g-mb-0--md">
                    <div class="d-lg-flex">
                        <small class="d-block g-font-size-default g-mr-10 g-mb-10 g-mb-0--md">2017 © All Rights Reserved.</small>
                        <ul class="u-list-inline">
                            <li class="list-inline-item">
                                <a class="g-color-white-opacity-0_8 g-color-white--hover" href="#">Privacy Policy</a>
                            </li>
                            <li class="list-inline-item">
                                <span>|</span>
                            </li>
                            <li class="list-inline-item">
                                <a class="g-color-white-opacity-0_8 g-color-white--hover" href="#">Terms of Use</a>
                            </li>
                            <li class="list-inline-item">
                                <span>|</span>
                            </li>
                            <li class="list-inline-item">
                                <a class="g-color-white-opacity-0_8 g-color-white--hover" href="#">License</a>
                            </li>
                            <li class="list-inline-item">
                                <span>|</span>
                            </li>
                            <li class="list-inline-item">
                                <a class="g-color-white-opacity-0_8 g-color-white--hover" href="#">Support</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-4 align-self-center">
                    <ul class="list-inline text-center text-md-right mb-0">
                        <li class="list-inline-item g-mx-10" data-toggle="tooltip" data-placement="top" title="Facebook">
                            <a href="#" class="g-color-white-opacity-0_5 g-color-white--hover">
                                <i class="fa fa-facebook"></i>
                            </a>
                        </li>
                        <li class="list-inline-item g-mx-10" data-toggle="tooltip" data-placement="top" title="Skype">
                            <a href="#" class="g-color-white-opacity-0_5 g-color-white--hover">
                                <i class="fa fa-skype"></i>
                            </a>
                        </li>
                        <li class="list-inline-item g-mx-10" data-toggle="tooltip" data-placement="top" title="Linkedin">
                            <a href="#" class="g-color-white-opacity-0_5 g-color-white--hover">
                                <i class="fa fa-linkedin"></i>
                            </a>
                        </li>
                        <li class="list-inline-item g-mx-10" data-toggle="tooltip" data-placement="top" title="Pinterest">
                            <a href="#" class="g-color-white-opacity-0_5 g-color-white--hover">
                                <i class="fa fa-pinterest"></i>
                            </a>
                        </li>
                        <li class="list-inline-item g-mx-10" data-toggle="tooltip" data-placement="top" title="Twitter">
                            <a href="#" class="g-color-white-opacity-0_5 g-color-white--hover">
                                <i class="fa fa-twitter"></i>
                            </a>
                        </li>
                        <li class="list-inline-item g-mx-10" data-toggle="tooltip" data-placement="top" title="Dribbble">
                            <a href="#" class="g-color-white-opacity-0_5 g-color-white--hover">
                                <i class="fa fa-dribbble"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!-- End Copyright Footer -->
    <a class="js-go-to u-go-to-v1" href="#" data-type="fixed" data-position='{
     "bottom": 15,
     "right": 15
   }' data-offset-top="400" data-compensation="#js-header" data-show-effect="zoomIn">
        <i class="hs-icon hs-icon-arrow-top"></i>
    </a>
</main>

<!-- JS Global Compulsory -->
<script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery-migrate/jquery-migrate.min.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery.easing/js/jquery.easing.js') }}"></script>
<script src="{{ asset('assets/vendor/popper.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/offcanvas.js') }}"></script>

<!-- JS Implementing Plugins -->
<script src="{{ asset('assets/vendor/dzsparallaxer/dzsparallaxer.js') }}"></script>
<script src="{{ asset('assets/vendor/dzsparallaxer/dzsscroller/scroller.js') }}"></script>
<script src="{{ asset('assets/vendor/dzsparallaxer/advancedscroller/plugin.js') }}"></script>
<script src="{{ asset('assets/vendor/masonry/dist/masonry.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/vendor/slick-carousel/slick/slick.js') }}"></script>
<script src="{{ asset('assets/vendor/fancybox/jquery.fancybox.min.js') }}"></script>

<!-- JS Unify -->
<script src="{{ asset('assets/js/hs.core.js') }}"></script>

<script src="{{ asset('assets/js/components/hs.header.js') }}"></script>
<script src="{{ asset('assets/js/helpers/hs.hamburgers.js') }}"></script>

<script src="{{ asset('assets/js/components/hs.popup.js') }}"></script>
<script src="{{ asset('assets/js/components/hs.carousel.js') }}"></script>

<script src="{{ asset('assets/js/components/hs.go-to.js') }}"></script>


<!-- JS Custom -->
<script src="{{ asset('assets/js/manifest.js') }}"></script>
<script src="{{ asset('assets/js/vendor.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>

<!-- JS Plugins Init. -->
<script>
    $(document).on('ready', function () {
        // initialization of go to
        $.HSCore.components.HSGoTo.init('.js-go-to');

        // initialization of carousel
        $.HSCore.components.HSCarousel.init('.js-carousel');

        $('#we-provide').slick('setOption', 'responsive', [{
            breakpoint: 992,
            settings: {
                slidesToShow: 2
            }
        }, {
            breakpoint: 576,
            settings: {
                slidesToShow: 1
            }
        }], true);

        // initialization of masonry
        $('.masonry-grid').imagesLoaded().then(function () {
            $('.masonry-grid').masonry({
                columnWidth: '.masonry-grid-sizer',
                itemSelector: '.masonry-grid-item',
                percentPosition: true
            });
        });

        // initialization of popups
        $.HSCore.components.HSPopup.init('.js-fancybox');
    });

    $(window).on('load', function () {
        // initialization of header
        $.HSCore.components.HSHeader.init($('#js-header'));
        $.HSCore.helpers.HSHamburgers.init('.hamburger');
    });
</script>

</body>
</html>
