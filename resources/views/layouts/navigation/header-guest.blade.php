<header id="js-header" class="u-header u-header--sticky-top u-header--change-logo u-header--change-appearance"
        data-header-fix-moment="100">
    <div class="u-header__section u-header__section--dark g-bg-black-opacity-0_7 g-transition-0_3 g-py-10"
         data-header-fix-moment-exclude="u-header__section--dark g-bg-black-opacity-0_7 g-py-10"
         data-header-fix-moment-classes="u-header__section--light g-bg-white u-shadow-v18">
        <nav class="navbar navbar-expand-lg">
            <div class="container justify-content-between">

                <!-- Responsive Toggle Button -->
                <button class="navbar-toggler navbar-toggler-right btn g-line-height-1 g-brd-none g-pa-0"
                        type="button"
                        aria-label="Toggle navigation"
                        aria-expanded="false"
                        aria-controls="navBar"
                        data-toggle="collapse"
                        data-target="#navBar">
                    <span class="hamburger hamburger--elastic g-px-0">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </span>
                </button>
                <!-- End Responsive Toggle Button -->

                @include('layouts.navigation.partials.top-logo')

                @include('layouts.navigation.partials.top-nav')

            </div>
        </nav>

    </div>
</header>

