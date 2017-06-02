@extends('layouts.master')

@section('content')



      
      
        <div class="clearfix"></div>
        <div class="slider-master">
            <!-- Master Slider -->
            <div class="master-slider ms-skin-default" id="masterslider"> 

                <!-- slide 1 -->
                <div class="ms-slide slide-1" data-delay="14"> 

                    <!-- slide background --> 
                    <img src="{{ secure_asset('masterslider/style/blank.gif') }}" data-src="{{ secure_asset('img/m-slide1.jpg') }}" alt="Slide1 background"/>

                    <h3 class="ms-layer title_main"
                        style="left:150px;top: 230px;"
                        data-type="text"
                        data-delay="1500"
                        data-duration="2500"
                        data-ease="easeOutExpo"
                        data-effect="rotate3dtop(-100,0,0,40,t)">Clean minimal business</h3>
                    <h5 class="ms-layer sub-title"
                        style="left:150px; top: 320px;"
                        data-type="text"
                        data-effect="bottom(45)"
                        data-duration="3000"
                        data-delay="2000"
                        data-ease="easeOutExpo">Perfect for any minimal business startup</h5>
                    <a class="ms-layer btn1 slide-btn uppercase" href="#"
                       style="left: 150px; top:340px;"
                       data-type="text"
                       data-delay="3000"
                       data-ease="easeOutExpo"
                       data-duration="2500"
                       data-effect="scale(1.5,1.6)"> Learn More <i class="fa fa-angle-right"></i> </a> 
                    <a class="ms-layer btn2 slide-btn uppercase" href="#"
                       style="left:300px; top:340px;"
                       data-type="text"
                       data-delay="3200"
                       data-ease="easeOutExpo"
                       data-duration="2800"
                       data-effect="scale(1.5,1.6)"> Purchase Now! <i class="fa fa-angle-right"></i></a> </div>
                <!-- end of slide --> 

                <!-- slide 2 -->
                <div class="ms-slide slide-2" data-delay="14"> 

                    <!-- slide background --> 
                    <img src="{{ secure_asset('masterslider/style/blank.gif') }}" data-src="{{ secure_asset('img/m-slide2.jpg') }}" alt="Slide1 background"/>

                    <h3 class="ms-layer title_main full-wid text-center"
                        style="left:0;top: 230px;"
                        data-type="text"
                        data-delay="1500"
                        data-duration="2500"
                        data-ease="easeOutExpo"
                        data-effect="rotate3dtop(-100,0,0,40,t)">Beautiful hand crafted</h3>
                    <h5 class="ms-layer sub-title full-wid text-center"
                        style="left:0; top: 320px;"
                        data-type="text"
                        data-effect="bottom(45)"
                        data-duration="3000"
                        data-delay="2000"
                        data-ease="easeOutExpo">Simple and elegant design for your next project</h5>
                    <a class="ms-layer btn1 slide-btn uppercase" href="#"
                       style="left: 550px; top:340px;"
                       data-type="text"
                       data-delay="3000"
                       data-ease="easeOutExpo"
                       data-duration="2500"
                       data-effect="scale(1.5,1.6)"> Learn More <i class="fa fa-angle-right"></i> </a> 
                    <a class="ms-layer btn2 slide-btn uppercase" href="#"
                       style="left:700px; top:340px;"
                       data-type="text"
                       data-delay="3200"
                       data-ease="easeOutExpo"
                       data-duration="2800"
                       data-effect="scale(1.5,1.6)"> Purchase Now! <i class="fa fa-angle-right"></i></a> </div>
                <!-- end of slide --> 

                <!-- slide 2 -->
                <div class="ms-slide slide-3" data-delay="14"> 

                    <!-- slide background --> 
                    <img src="{{ secure_asset('masterslider/style/blank.gif') }}" data-src="{{ secure_asset('img/m-slide3.jpg') }}" alt="Slide1 background"/>

                    <h3 class="ms-layer title_main full-wid text-center"
                        style="left:0;top: 230px;"
                        data-type="text"
                        data-delay="1500"
                        data-duration="2500"
                        data-ease="easeOutExpo"
                        data-effect="rotate3dtop(-100,0,0,40,t)">You are in good company</h3>
                    <h5 class="ms-layer sub-title full-wid text-center"
                        style="left:0; top: 320px;"
                        data-type="text"
                        data-effect="bottom(45)"
                        data-duration="3000"
                        data-delay="2000"
                        data-ease="easeOutExpo">Most popular minimal business theme ever</h5>
                    <a class="ms-layer btn1 slide-btn uppercase" href="#"
                       style="left: 550px; top:340px;"
                       data-type="text"
                       data-delay="3000"
                       data-ease="easeOutExpo"
                       data-duration="2500"
                       data-effect="scale(1.5,1.6)"> Learn More <i class="fa fa-angle-right"></i> </a> 
                    <a class="ms-layer btn2 slide-btn uppercase" href="#"
                       style="left:700px; top:340px;"
                       data-type="text"
                       data-delay="3200"
                       data-ease="easeOutExpo"
                       data-duration="2800"
                       data-effect="scale(1.5,1.6)"> Purchase Now! <i class="fa fa-angle-right"></i></a> </div>
                <!-- end of slide --> 
            </div>
            <!-- end Master Slider -->
        </div>
        <div class="space-50"></div>
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
                                <img src="{{ secure_asset('img/work/work-1.jpg') }}" class="img-fluid" alt="">
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
                                <img src="{{ secure_asset('img/work/work-2.jpg') }}" class="img-fluid" alt="">
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
                                <img src="{{ secure_asset('img/work/work-3.jpg') }}" class="img-fluid" alt="">
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
                                <img src="{{ secure_asset('img/work/work-4.jpg') }}" class="img-fluid" alt="">
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
                                <img src="{{ secure_asset('img/work/work-5.jpg') }}" class="img-fluid" alt="">
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
                                <img src="{{ secure_asset('/img/work/work-6.jpg') }}" class="img-fluid" alt="">
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
                        <img src="{{ secure_asset('img/ipad.png') }}" class="img-fluid" alt="">
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
                                <img src="{{ secure_asset('img/blog/blog-1.jpg') }}" class="img-fluid" alt="">
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
                                <img src="{{ secure_asset('img/blog/blog-2.jpg') }}" class="img-fluid" alt="">
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
                                <img src="{{ secure_asset('/img/blog/blog-4.jpg') }}" class="img-fluid" alt="">
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
        <!--footer-->
        <div id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 margin-btm-20">
                        <div class="footer-col">
                            <h3>Bizwrap</h3>
                            <p>
                                aliqua.adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna. aliqua.adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna.
                            </p>
                        </div>
                        <div class="space-20"></div>
                        <div class="footer-col">
                            <h3>contact info</h3>
                            <p><i class="ion-home"></i> pearl tower,3rd floor,jaipur,302012</p>
                            <p><i class="ion-iphone"></i> +91 9887568614</p>
                            <p><i class="ion-email"></i> mail@domain.com</p>
                        </div>
                        <div class="space-20"></div>
                        <div class="footer-col">
                            <h3>Follow us</h3>
                            <ul class=" list-inline social-btn">
                                <li class="list-inline-item"><a href="#"><i class="ion-social-facebook" data-toggle="tooltip" data-placement="top" title="" data-original-title="Like On Facebook"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="ion-social-twitter" data-toggle="tooltip" data-placement="top" title="" data-original-title="Follow On twitter"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="ion-social-googleplus" data-toggle="tooltip" data-placement="top" title="" data-original-title="Follow On googleplus"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="ion-social-pinterest" data-toggle="tooltip" data-placement="top" title="" data-original-title="pinterest"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="ion-social-skype" data-toggle="tooltip" data-placement="top" title="" data-original-title="skype"></i></a></li>
                            </ul>
                        </div><!--footer social col-->
                    </div><!--col-4 end-->
                    <div class="col-md-3 margin-btm-20">
                        <div class="footer-col">
                            <h3>Latest post</h3>
                            <ul class="post-list list-unstyled">
                                <li><a href="#" class="hover-color">Blog post with image</a></li>
                                <li><a href="#" class="hover-color">lorem ipsum dollor sit amet</a></li>
                                <li><a href="#" class="hover-color">Blog post with audio</a></li>
                                <li><a href="#" class="hover-color">lorem ipsum dollor sit amet</a></li>
                                <li><a href="#" class="hover-color">Blog post with quote</a></li>
                            </ul>
                        </div>
                    </div><!--latest post col end-->
                    <div class="col-md-5">
                        <div class="footer-col">
                            <h3>Get in touch</h3>
                            <form>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Name...">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="email" class="form-control" placeholder="Email...">
                                    </div>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" placeholder="Subject...">
                                    </div>
                                    <div class="col-md-12">
                                        <textarea class="form-control" placeholder="Massage..." rows="7"></textarea>
                                    </div>
                                    <div class="col-md-12 text-right">
                                        <button type="submit" class="btn btn-lg btn-white">Send massege</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!--get in touch col end-->
                </div><!--footer main row end-->  
                <div class="space-70"></div>
                <div class="row">
                    <div class="col-md-12 text-center footer-bottom">
                        <a href="index.html"> <img src="{{ secure_asset('/img/logo-white.png') }}" alt=""></a>
                        <div class="space-20"></div>
                        <span>&copy;2017. All right resrved. Design by design_mylife</span>
                    </div>
                </div><!--footer copyright row end-->
            </div><!--container-->
        </div><!--footer main end-->
        <a href="#" class="scrollToTop"><i class="ion-android-arrow-dropup-circle"></i></a>
        <!--back to top end-->

       
        <!--page template scripts-->
        <script src="{{ secure_asset('masterslider/masterslider.min.js') }}"></script> 
        <script src="{{ secure_asset('js/masterslider-custom.js') }}" type="text/javascript"></script>


@endsection