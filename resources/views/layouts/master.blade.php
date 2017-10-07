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

<main id="wrapper">

    <!-- App bar -->
    @include('layouts.navigation.appbar')

    <!-- Content -->
    @yield('content')

    <!-- Call To Action -->
    @include('layouts.partials.call_to_action')

    <!-- Footer -->
    @include('layouts.partials.footer')

    <!-- Copyright Footer -->
    @include('layouts.partials.copyright')

    <!-- Arrow up -->
    <a class="js-go-to u-go-to-v1" href="#" data-type="fixed" data-position='{"bottom": 15, "right": 15}'
       data-offset-top="400" data-compensation="#js-header" data-show-effect="zoomIn">
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
