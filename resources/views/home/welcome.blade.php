@extends('layouts.master')

@section('content')

    <div class="clearfix"></div>
    <header class="header-hero">
        <div class="container">
            <div class="text-xs-center">
                <h1>Erfolgreicher investieren.</h1>
                <h2>Portfolio professionell steuern</h2>
                <p class="button-group">
                    <a href="{{ route('register') }}" class="btn theme-btn-color btn-lg btn-radius">Entdecken</a>
                    <a href="#infos" class="btn btn-outline-secondary btn-lg btn-radius">Mehr Infos</a>
                </p>
            </div>
        </div>
    </header>

    <section id="bck-img1" class="wrapper wrapper-dark wrapper-half-left">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-6">
                    <h4>Lorem ipsum dolor sit amet, consetetur</h4>
                    <p>
                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="bck-img2" class="wrapper wrapper-primary wrapper-half-right">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-right">
                    <h4>Lorem ipsum dolor sit amet, consetetur</h4>
                    <p>
                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="bck-img3" class="wrapper wrapper-dark wrapper-half-left">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-6">
                    <h4>Lorem ipsum dolor sit amet, consetetur</h4>
                    <p>
                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <div class="clearfix"></div>



@endsection



@section('scripts.footer')
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



