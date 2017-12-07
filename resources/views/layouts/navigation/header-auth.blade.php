<header id="js-header" class="u-header u-header--sticky-top u-header--toggle-section u-header--change-appearance"
        data-header-fix-moment="600"
        data-header-fix-effect="slide">
    <div class="u-header__section g-transition-0_5"
         data-header-fix-moment-exclude="g-mt-0"
         data-header-fix-moment-classes="g-mt-minus-73 g-mt-minus-76--md">

        <!-- Topbar -->
        <div class="g-bg-white nav navbar-expand-lg">
            <div class="container-fluid g-py-11">
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

                <div class="row align-items-lg-center align-items-sm-start float-lg-none float-right">
                    <div class="col-2 col-md-4 col-lg-2">
                        @include('layouts.navigation.partials.top-logo')
                    </div>

                    <div class="col-10 col-md-8 col-lg-6 ml-auto">

                        @include('layouts.navigation.partials.top-nav')

                        {{-- <li class="list-inline-item g-hidden-xs-down g-mx-2">
                                 <a href="{{ route('faq.index') }}"
                                    class="u-link-v5 g-color-gray-dark-v5 g-color-primary--hover g-font-weight-500 g-font-size-12 g-pa-10">
                                     <i class="align-middle g-font-size-11 mr-1 icon-communication-033 u-line-icon-pro"></i>
                                     FAQ
                                 </a>
                             </li>--}}
                    </div>
                </div>
            </div>
        </div>


        <!-- Appbar -->
        <div class="js-mega-menu navbar navbar-expand-lg g-brd-y g-brd-2 g-brd-primary-dark-v1 g-bg-primary g-pa-0">
            <div class="container-fluid">

                <!-- Portfolio -->
                <li class="list-inline-item mr-0">
                    <a id="portfolio-dropdown-invoker"
                       class="nav-link g-color-white g-brd-right--lg g-brd-primary-dark-v1 g-bg-primary-dark-v1--hover g-font-weight-600 g-font-size-default g-px-17 g-px-23--xl g-py-15"
                       href="#"
                       aria-controls="portfolio-dropdown"
                       aria-haspopup="true"
                       aria-expanded="false"
                       data-dropdown-event="hover"
                       data-dropdown-target="#portfolio-dropdown"
                       data-dropdown-type="css-animation"
                       data-dropdown-duration="0"
                       data-dropdown-hide-on-scroll="true"
                       data-dropdown-animation-in="fadeIn"
                       data-dropdown-animation-out="fadeOut">
                        Meine Portfolios
                        <i class="ml-2 fa fa-angle-down"></i>
                    </a>

                    <ul id="portfolio-dropdown"
                        class="list-unstyled u-shadow-v11 g-min-width-220 g-bg-white g-pos-abs g-left-0 g-z-index-99 g-mt-4"
                        aria-labelledby="account-dropdown-invoker">

                        <li class="dropdown-item g-px-5">
                            <a class="nav-link g-color-text g-font-weight-600"
                               href="{{ route('portfolios.index') }}">
                                <i class="align-middle g-font-size-11 mr-1 icon-communication-033 u-line-icon-pro"></i>
                                @lang('portfolio.menu.overview')
                            </a>
                        </li>

                        <!-- new portfolio -->
                        <li class="dropdown-item g-px-5">
                            <a class="nav-link g-color-text g-font-weight-600"
                               href="{{ route('portfolios.create') }}">
                                @lang('portfolio.menu.create')
                            </a>
                        </li>

                        @foreach (Auth::user()->portfolios as $userPortfolio)
                            <li class="dropdown-item g-px-5">
                                <a class="nav-link g-color-text g-font-weight-600"
                                   href="{{ route('portfolios.show', $userPortfolio) }}">
                                    {{ $userPortfolio->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                <!-- Portfolio Name -->
                <div class="col-auto order-lg-1">
                    @isset ($portfolio)
                        <div class="list-inline-item g-color-white g-font-weight-600 mr-0">
                            {{ $portfolio->name }}
                        </div>
                    @endisset
                </div>
            </div>
        </div>

    </div>

</header>