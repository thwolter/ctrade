@extends('layouts.master')

@section('content')

    <section id="content-region-3" class="padding-40 page-tree-bg">
        <div class="container">
            <h3 class="page-tree-text">
                Portfolio anlegen
            </h3>
        </div>
    </section><!--page-tree end here-->
    <div class="space-70"></div>

    @if (count($portfolios) == 0)

        <!-- welcome-box -->
        <div class="container">
            <div id="welcome" class=" welcome-box">
                <h1>Willkommen</h1>
                <p class="lead">Vielen Dank, dass du dich registiert hast.</p>
                <hr class="my-4">
                <p>Lege dir ein Portfolio an und bestücke es mit beliebigen Positionen.<br>
                    Alternative kannst du dir unsere Beispiele anschauen, die von uns gewählte Positionen beinhalten.
                </p>
                <div class="lead">
                    <a class="btn theme-btn-color btn-lg" href="{{ route('portfolios.create') }}" role="button">Erstellen</a>
                    <a class="btn btn theme-btn-color-outline btn-lg" href="#examples" role="button">Beispiele</a>
                </div>
            </div>
        </div><!-- /welccome-box -->

        <div id="examples" class="space-70"></div>

        <!-- example masonry -->
        <div class="blog-masonary-wrapper">
            <div class="container">
                <div class="row mas-boxes" id="mas-boxes">
                    @foreach ($examples as $portfolio)
                        @php($bounceIn = '0.3s')
                        @include('portfolios.partials.masonry')
                    @endforeach
                </div>
            </div>
        </div>


    @endif

    @if (count($portfolios) > 0)

        <!-- show list of portfolios -->
        @foreach($portfolios as $portfolio)

            <div id="portfolios" class="space-70"></div>

            <!-- portfolio masonry -->
            <div class="blog-masonary-wrapper">
                <div class="container">
                    <div class="row mas-boxes" id="mas-boxes">
                        @foreach ($portfolios as $portfolio)
                            @php($bounceIn = '0.3s')
                            @include('portfolios.partials.masonry')
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <script src="{{ asset('cubeportfolio/js/jquery.cubeportfolio.min.js') }}"></script>
    <script>
        (function ($, window, document, undefined) {
            'use strict';

            // init cubeportfolio
            $('#js-grid-slider-thumbnail').cubeportfolio({
                layoutMode: 'slider',
                drag: true,
                auto: false,
                autoTimeout: 5000,
                autoPauseOnHover: true,
                showNavigation: false,
                showPagination: false,
                rewindNav: true,
                scrollByPage: true,
                gridAdjustment: 'responsive',
                mediaQueries: [{
                    width: 0,
                    cols: 1
                }],
                gapHorizontal: 0,
                gapVertical: 0,
                caption: '',
                displayType: 'fadeIn',
                displayTypeSpeed: 400,
                plugins: {
                    slider: {
                        pagination: '#js-pagination-slider',
                        paginationClass: 'cbp-pagination-active'
                    }
                }
            });
        })(jQuery, window, document);
    </script>
    <script>
        $(document).ready(function(){
            // Add scrollspy to <body>
            $('body').scrollspy({target: "welcome", offset: 50});

            // Add smooth scrolling on all links inside the navbar
            $("#welcome a").on('click', function(event) {
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


