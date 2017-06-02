@extends('layouts.master')

@section('content')

    <div class="clearfix"></div>
    <header class="home-header-box">
        <div class="title-box">
            <h1><span class="highlight">ERFOLREICHER INVESTIEREN.</span> <br>
                Portfolio professionell steuern</h1>
            <div id="header-buttons" class="button-group">
                <a href="{{ route('register') }}" class="btn theme-btn-color btn-lg btn-radius" style="margin-right: 10px">Entdecken</a>
                <a href="#infos" class="btn btn-outline-secondary btn-lg btn-radius">Mehr Infos</a>
            </div>
        </div>
    </header>

    <div id="infos" class="space-50"></div>

    <div class="container">
        <div class="row intro-row">
                <div class="col-md-12 text-center wow animated fadeInUp">
                    <h2>Bizwrap built for Minimal business Projects</h2>
                    <h3 class="subtitle">With Clean and Modern Design</h3>
                </div>
                <div class="space-70"></div>
                <div class=" col-md-4 wow animated bounceIn">
                    <div class="services-box">
                        <i class="ion-laptop"></i>
                        <h1>Responsive design</h1>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque nisl risus, porta sit amet dui eget...
                        </p>
                    </div>
                </div><!--services box-->
                <div class=" col-md-4 wow animated bounceIn" data-wow-delay=".2s">
                    <div class="services-box">
                        <i class="ion-ios-color-wand-outline"></i>
                        <h1>Creative ideas</h1>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque nisl risus, porta sit amet dui eget...
                        </p>
                    </div>
                </div><!--services box-->
                <div class="col-md-4 wow animated bounceIn" data-wow-delay=".3s">
                    <div class="services-box">
                        <i class="ion-social-twitter-outline"></i>
                        <h1>Bootstrap4</h1>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque nisl risus, porta sit amet dui eget...
                        </p>
                    </div>
                </div><!--services box-->
            </div><!--row end-->
        </div><!--intro with services end-->
        <div class="space-70"></div><div class="space-30"></div>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="heading-sec">Recent work</h3>
                </div>
            </div><!--row-->
            <div class="row">
                <div class="col-md-4 col-sm-6 margin-btm-40">
                    <div class="portfolio-sec">
                        <div class="portfolio-thumnail">
                            <a href="portfolio-single.html">
                                <img src="{{ asset('img/work/work-1.jpg') }}" class="img-fluid" alt="">
                            </a>
                        </div>
                        <div class="portfolio-desc text-center">
                            <h4 class="portfolio-post-title">portfolio item title here</h4>
                            <span class="portfolio-post-cat">Branding</span>
                            <h4><a href="portfolio-single.html" class="btn theme-btn-default btn-lg">More detail</a></h4>
                        </div>
                    </div>
                </div><!--portfolio item -->
                <div class="col-md-4 col-sm-6 margin-btm-40">
                    <div class="portfolio-sec">
                        <div class="portfolio-thumnail">
                            <a href="portfolio-single.html">
                                <img src="{{ asset('img/work/work-2.jpg') }}" class="img-fluid" alt="">
                            </a>
                        </div>
                        <div class="portfolio-desc text-center">
                            <h4 class="portfolio-post-title">portfolio item title here</h4>
                            <span class="portfolio-post-cat">Branding</span>
                            <h4><a href="portfolio-single.html" class="btn theme-btn-default btn-lg">More detail</a></h4>
                        </div>
                    </div>
                </div><!--portfolio item -->
                <div class="col-md-4 col-sm-6 margin-btm-40">
                    <div class="portfolio-sec">
                        <div class="portfolio-thumnail">
                            <a href="portfolio-single.html">
                                <img src="{{ asset('img/work/work-3.jpg') }}" class="img-fluid" alt="">
                            </a>
                        </div>
                        <div class="portfolio-desc text-center">
                            <h4 class="portfolio-post-title">portfolio item title here</h4>
                            <span class="portfolio-post-cat">Branding</span>
                            <h4><a href="portfolio-single.html" class="btn theme-btn-default btn-lg">More detail</a></h4>
                        </div>
                    </div>
                </div><!--portfolio item -->


                <div class="col-md-4 col-sm-6 margin-btm-40">
                    <div class="portfolio-sec">
                        <div class="portfolio-thumnail">
                            <a href="portfolio-single.html">
                                <img src="{{ asset('img/work/work-4.jpg') }}" class="img-fluid" alt="">
                            </a>
                        </div>
                        <div class="portfolio-desc text-center">
                            <h4 class="portfolio-post-title">portfolio item title here</h4>
                            <span class="portfolio-post-cat">Branding</span>
                            <h4><a href="portfolio-single.html" class="btn theme-btn-default btn-lg">More detail</a></h4>
                        </div>
                    </div>
                </div><!--portfolio item -->
                <div class="col-md-4 col-sm-6 margin-btm-40">
                    <div class="portfolio-sec">
                        <div class="portfolio-thumnail">
                            <a href="portfolio-single.html">
                                <img src="{{ asset('img/work/work-5.jpg') }}" class="img-fluid" alt="">
                            </a>
                        </div>
                        <div class="portfolio-desc text-center">
                            <h4 class="portfolio-post-title">portfolio item title here</h4>
                            <span class="portfolio-post-cat">Branding</span>
                            <h4><a href="portfolio-single.html" class="btn theme-btn-default btn-lg">More detail</a></h4>
                        </div>
                    </div>
                </div><!--portfolio item -->
                <div class="col-md-4 col-sm-6 margin-btm-40">
                    <div class="portfolio-sec">
                        <div class="portfolio-thumnail">
                            <a href="portfolio-single.html">
                                <img src="{{ asset('/img/work/work-6.jpg') }}" class="img-fluid" alt="">
                            </a>
                        </div>
                        <div class="portfolio-desc text-center">
                            <h4 class="portfolio-post-title">portfolio item title here</h4>
                            <span class="portfolio-post-cat">Branding</span>
                            <h4><a href="portfolio-single.html" class="btn theme-btn-default btn-lg">More detail</a></h4>
                        </div>
                    </div>
                </div><!--portfolio item -->
            </div><!--row portfolio item-->
        </div><!--recent work container end-->
        <div class="space-70"></div>
        <section id="content-region-1" class="padding-40 overflow-hidden">
            <div class="container">
                <div class="row center-align-items">
                    <div class="col-md-7 features">
                        <h3>Our services</h3>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ut ipsum mauris. Fusce condimentum mollis eros vitae facilisis. Praesent gravida dignissim felis, id sagittis mauris rutrum non. Nullam pretium id sem ut hendrerit.
                        </p>
                        <div class="space-30"></div>
                        <div class="row">
                            <div class="col-md-3 services-icon">
                                <i class="ion-laptop"></i>
                            </div>
                            <div class="col-md-9 services-text">
                                <h4 class="heading-mini">100% Responsive layout</h4>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ut ipsum mauris. Fusce condimentum mollis eros vitae facilisis. 
                                </p>
                            </div>
                        </div><!--services list-->
                        <div class="space-30"></div>
                        <div class="row">
                            <div class="col-md-3 services-icon">
                                <i class="ion-ios-barcode-outline"></i>
                            </div>
                            <div class="col-md-9 services-text">
                                <h4 class="heading-mini">Clean code</h4>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ut ipsum mauris. Fusce condimentum mollis eros vitae facilisis. 
                                </p>
                            </div>
                        </div><!--services list-->
                        <div class="space-30"></div>
                        <div class="row">
                            <div class="col-md-3 services-icon">
                                <i class="ion-compose"></i>
                            </div>
                            <div class="col-md-9 services-text">
                                <h4 class="heading-mini">Easy customization</h4>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ut ipsum mauris. Fusce condimentum mollis eros vitae facilisis. 
                                </p>
                            </div>
                        </div><!--services list-->


                    </div>
                    <div class="col-md-5 wow animated fadeInRight">
                        <img src="{{ asset('img/ipad.png') }}" class="img-fluid" alt="">
                    </div>
                </div>

            </div><!--container-->
        </section><!--features end-->
        <section id="content-region-2" class="padding-40 parallax-1 wow animated fadeIn">

            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="testimonials">
                            <ul class="slides">
                                <li>
                                    <p class="testi-text">"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent faucibus massa in mauris rhoncus aliquam. Suspendisse nec velit vestibulum, euismod quam id, pellentesque elit. Ut a interdum metus, vel dictum nibh."<p>
                                        <span class="testi-person">John Doe - company inc  </span>
                                </li>
                                <li>
                                    <p class="testi-text">"Sed fringilla sem sed massa ullamcorper, vitae rutrum justo sodales. Cras sed iaculis enim. Sed aliquet viverra nisl a tristique. Curabitur vitae mauris sem. Pellentesque iaculis nibh leo, mattis aliquet arcu tincidunt at."<p>
                                        <span class="testi-person">John terry - company inc  </span>
                                </li>
                                <li>
                                    <p class="testi-text">"Cras adipiscing odio nunc, non laoreet urna suscipit ac. Pellentesque congue egestas risus viverra pharetra. Morbi pretium orci magna, vitae mattis nisl viverra eleifend. Vestibulum euismod erat non ligula hendrerit tincidunt."<p>
                                        <span class="testi-person">victoria - company inc </span>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </section> <!--testimonials section end here-->
        <div class="space-70"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="heading-sec">Latest news</h3>
                </div>
            </div><!--row-->
            <div class="row wow animated fadeInUp" data-wow-delay="0.3s">
                <div class="col-md-4 margin-btm-20">
                    <div class="news-sec">
                        <div class="news-thumnail">
                            <a href="blog-post.html">
                                <img src="{{ asset('img/blog/blog-1.jpg') }}" class="img-fluid" alt="">
                            </a>
                        </div>
                        <div class="news-desc">
                            <h3 class="blog-post-title"><a href="blog-post.html" class="hover-color">Lorem ipsum dollor sit amet</a></h3>
                            <span class="news-post-cat">On 26 may 2014 | sports</span>
                            <p>
                                aliqua.adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna..
                            </p>
                        </div>
                    </div>
                </div><!--latest news items-->
                <div class="col-md-4 margin-btm-20">
                    <div class="news-sec">
                        <div class="news-thumnail">
                            <a href="blog-post.html">
                                <img src="{{ asset('img/blog/blog-2.jpg') }}" class="img-fluid" alt="">
                            </a>
                        </div>
                        <div class="news-desc">
                            <h3 class="blog-post-title"><a href="blog-post.html" class="hover-color">Lorem ipsum dollor sit amet</a></h3>
                            <span class="news-post-cat">On 26 may 2014 | sports</span>
                            <p>
                                aliqua.adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna..
                            </p>
                        </div>
                    </div>
                </div><!--latest news items-->
                <div class="col-md-4 margin-btm-20">
                    <div class="news-sec">
                        <div class="news-thumnail">
                            <a href="blog-post.html">
                                <img src="{{ asset('/img/blog/blog-4.jpg') }}" class="img-fluid" alt="">
                            </a>
                        </div>
                        <div class="news-desc">
                            <h3 class="blog-post-title"><a href="blog-post.html" class="hover-color">Lorem ipsum dollor sit amet</a></h3>
                            <span class="news-post-cat">On 26 may 2014 | sports</span>
                            <p>
                                aliqua.adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna..
                            </p>
                        </div>
                    </div>
                </div><!--latest news items-->
            </div><!--row end-->
        </div><!--container recent news end-->
        <div class="space-50"></div>
        <div class="newsletter-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <h3>Get latest news from us</h3>
                        <p>
                            Subscribe to our newsletter
                        </p>
                    </div>
                </div><!--row-->

                <div class="row">
                    <div class="col-md-4 offset-md-4 text-center">
                        <form method="post" action="#" class="form-subscribe">
                            <input type="text" name="email" placeholder="Email Id..." class="form-control">
                            <button type="submit" name="submit" class="btn theme-btn-color btn-block">Subscribe Now</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="cta-bg wow animated fadeIn">
            <div class="container text-center">
                <h3>Simple and Minimal Design
                    <a href="#" class="btn btn-lg btn-white btn-radius">Purchase Now</a>
                </h3>
            </div>
        </div>

    <script>
        $(document).ready(function(){
            // Add scrollspy to <body>
            $('body').scrollspy({target: "header", offset: 50});

            // Add smooth scrolling on all links inside the navbar
            $("#header-buttons a").on('click', function(event) {
                // Make sure this.hash has a value before overriding default behavior
                if (this.hash !== "") {
                    // Prevent default anchor click behavior
                    event.preventDefault();

                    // Store hash
                    var hash = this.hash;

                    // Using jQuery's animate() method to add smooth page scroll
                    // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
                    $('html, body').animate({
                        scrollTop: $(hash).offset().top
                    }, 800, function(){

                        // Add hash (#) to URL when done scrolling (default click behavior)
                        window.location.hash = hash;
                    });
                }  // End if
            });
        });
    </script>




@endsection