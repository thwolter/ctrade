<header id="js-header" class="u-header u-header--static u-shadow-v19">
    <!-- Top Bar -->
    <div class="u-header__section g-brd-bottom g-brd-gray-light-v4 g-transition-0_3">
        <div class="container">
            <div class="row justify-content-between align-items-center g-mx-0--lg">

                <div class="col-sm-auto g-hidden-sm-down"></div>

                <div class="col-sm-auto g-pr-15 g-pr-0--sm g-my-5">
                    <!-- List -->
                    <ul class="list-inline g-overflow-hidden g-pt-1 g-mx-minus-4 mb-0">

                        <!-- Account -->
                        @includeWhen(Auth::check(), 'layouts.header.appbar-auth')
                        @includeWhen(Auth::guest(), 'layouts.header.appbar-guest')
                        <!-- End Account -->
                    </ul>
                    <!-- End List -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Top Bar -->

    <div class="u-header__section u-header__section--light g-bg-lightblue-radialgradient-circle g-transition-0_3 g-py-10">
        <nav class="js-mega-menu navbar navbar-expand-lg">
            <div class="container">
                <!-- Responsive Toggle Button -->
                <button class="navbar-toggler navbar-toggler-right btn g-line-height-1 g-brd-none g-pa-0 g-pos-abs g-top-3 g-right-0"
                        type="button"
                        aria-label="Toggle navigation"
                        aria-expanded="false"
                        aria-controls="navBar"
                        data-toggle="collapse"
                        data-target="#navBar">
                <span class="hamburger hamburger--slider g-pr-0">
                  <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                  </span>
                </span>
                </button>
                <!-- End Responsive Toggle Button -->

                <!-- Logo -->
                <a class="navbar-brand" href="home-page-1.html">
                    <img src="assets/img/logo/logo-1.png" alt="Image Description">
                </a>
                <!-- End Logo -->

                <!-- Navigation -->
                <div id="navBar" class="collapse navbar-collapse align-items-center flex-sm-row g-pt-15 g-pt-0--lg">
                    <ul class="navbar-nav g-ml-60">
                        <li class="nav-item g-my-8 {{ active_class(if_route('home.contact')) }}">
                            <a href="{{ route('home.contact') }}"
                               class="nav-link g-bg-primary-dark-v1--hover g-font-weight-600 g-font-size-default g-px-17 g-px-23--xl">
                                Kontakt
                            </a>
                        </li>

                        <li class="nav-item g-my-8 {{ active_class(if_route('home.about')) }}">
                            <a href="{{ route('home.about') }}"
                               class="nav-link g-bg-primary-dark-v1--hover g-font-weight-600 g-font-size-default g-px-17 g-px-23--xl">
                                Über uns
                            </a>
                        </li>

                        <li class="nav-item g-my-8 {{ active_class(if_route('faq.index')) }}">
                            <a href="{{ route('faq.index') }}"
                               class="nav-link g-bg-primary-dark-v1--hover g-font-weight-600 g-font-size-default g-px-17 g-px-23--xl">
                                FAQ
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- End Navigation -->
            </div>
        </nav>
    </div>

</header>