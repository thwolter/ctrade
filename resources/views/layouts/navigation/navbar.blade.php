<!-- NavBar -->
<nav class="navbar navbar-expand-lg g-bg-white">
    <div class="container-fluid justify-content-between">
        <!-- Responsive Toggle Button -->
        <button class="navbar-toggler navbar-toggler-right btn g-line-height-1 g-brd-none g-pa-0" type="button"
                aria-label="Toggle navigation"
                aria-expanded="false"
                aria-controls="navBar"
                data-toggle="collapse"
                data-target="#navBar">
              <span class="hamburger hamburger--elastic g-px-15">
                <span class="hamburger-box">
                  <span class="hamburger-inner"></span>
                </span>
              </span>
        </button>
        <!-- End Responsive Toggle Button -->

        <!-- Logo -->
        @include('layouts.navigation.partials.logo')


        <!-- Navigation -->
        <div id="navBar"
             class="collapse navbar-collapse align-items-center justify-content-end order-lg-last g-brd-top g-brd-none--lg g-brd-primary-dark-v1">
            <ul class="navbar-nav g-py-30 g-py-0--lg">

                @include('layouts.navigation.partials.home')
                @include('layouts.navigation.partials.main')

            </ul>
        </div>

    </div>
</nav>