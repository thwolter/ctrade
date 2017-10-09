@extends('layouts.master')

@section('content')

    <!-- Promo Block -->
    <section class="u-bg-overlay g-bg-img-hero g-bg-bluegray-opacity-0_3--after"
             style="background-image: url({{ asset('assets/img-temp/1920x800/img1.jpg') }});">
        <div class="container u-bg-overlay__inner text-center g-pt-150 g-pb-70">
            <div class="g-mb-100">
                <span class="d-block g-color-white g-font-size-20 text-uppercase g-letter-spacing-5 mb-4">
                    The Exhibition of
                </span>
                <h1 class="g-color-white g-font-weight-700 g-font-size-20 g-font-size-50--md text-uppercase g-line-height-1_2 g-letter-spacing-10 mb-4">Creative Portfolios</h1>
                <span class="d-block lead g-color-white g-letter-spacing-2">
                    Examples of Our Branding Projects
                </span>
            </div>

            <div class="g-pos-abs g-left-0 g-right-0 g-z-index-2 g-bottom-30">
                <a class="js-go-to btn u-btn-outline-white g-color-white g-bg-white-opacity-0_1 g-color-black--hover g-bg-white--hover g-font-weight-600 text-uppercase g-rounded-50 g-px-30 g-py-11"
                   href="#" data-target="#content">
                    <i class="fa fa-angle-down"></i>
                </a>
            </div>
        </div>
    </section>
    <!-- End Promo Block -->

    <!-- Testimonials -->
    <section id="content" class="g-bg-secondary">
        <div class="container g-py-100">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="text-center">
              <span class="g-color-gray-dark-v2 g-font-size-90 g-pos-abs g-top-minus-40">
                  &#8220;
                </span>
                    </div>

                    <div class="js-carousel text-center g-pt-60" data-infinite="true" data-autoplay="true" data-fade="true" data-speed="5000">
                        <div class="js-slide">
                            <blockquote class="lead g-color-black g-font-size-22 g-line-height-2 mb-4">Dear Htmlstream team, I just bought the Unify template some weeks ago. The template is really nice and offers quite a large set of options.</blockquote>
                            <span class="d-block g-color-black g-font-size-17 mb-4">Katarina Ramirez, Designer</span>
                            <img class="d-inline-block g-width-60 g-height-60 g-brd-around g-brd-3 g-brd-white rounded-circle" src="../../assets/img-temp/100x100/img4.jpg" alt="Image Description">
                        </div>

                        <div class="js-slide">
                            <blockquote class="lead g-color-black g-font-size-22 g-line-height-2 mb-4">Hi there purchased a couple of days ago and the site looks great, big thanks to the htmlstream guys, they gave me some great help with some fiddly setup issues.</blockquote>
                            <span class="d-block g-color-black g-font-size-17 mb-4">Sara Anderson, Developer</span>
                            <img class="d-inline-block g-width-60 g-height-60 g-brd-around g-brd-3 g-brd-white rounded-circle" src="../../assets/img-temp/100x100/img5.jpg" alt="Image Description">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonials -->

    <!-- About -->
    <section id="go-to-content" class="g-pt-100 g-pb-100">
        <div class="container">
            <!-- Image, Text Block -->
            <div class="row d-flex align-items-lg-center flex-wrap g-mb-60 g-mb-0--lg">
                <div class="col-md-6 col-lg-8">
                    <img class="img-fluid rounded" src="../../../assets/img-temp/900x600/img1.jpg" alt="Image Description">
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="g-mt-minus-30 g-mt-0--md g-ml-minus-100--lg">
                        <div class="g-mb-20">
                            <h2 class="g-color-black g-font-weight-600 g-font-size-25 g-font-size-35--lg g-line-height-1_2 mb-4">Finding the<br>Perfect Product
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
                <div class="col-md-6 order-md-2">
                    <div class="g-brd-around--md g-brd-10 g-brd-white rounded">
                        <img class="img-fluid w-100 rounded" src="../../../assets/img-temp/600x450/img1.jpg" alt="Image Description">
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 ml-auto order-md-1">
                    <div class="g-mt-minus-30 g-mt-0--md g-ml-minus-100--lg">
                        <div class="g-mb-20">
                            <h2 class="g-color-black g-font-weight-600 g-font-size-25 g-font-size-35--lg g-line-height-1_2 mb-4">More than<br>a Stunning Look
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
@endsection