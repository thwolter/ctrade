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



