<!-- Header -->
<header id="js-header" class="u-header u-header--static--lg u-header--show-hide--lg u-header--change-appearance--lg"
        data-header-fix-moment="500" data-header-fix-effect="slide">
    <div class="u-header__section u-header__section--light g-bg-white g-transition-0_3 g-py-10"
         data-header-fix-moment-exclude="g-bg-white g-py-10"
         data-header-fix-moment-classes="g-bg-white-opacity-0_7 u-shadow-v18 g-py-0">
        <nav class="navbar navbar-expand-lg u-navbar u-navbar--inline-submenu--lg">
            <div class="container">
                <!-- Responsive Toggle Button -->
                <button class="navbar-toggler navbar-toggler-right btn g-line-height-1 g-brd-none g-pa-0 g-pos-abs g-top-3 g-right-0"
                        type="button" aria-label="Toggle navigation" aria-expanded="false" aria-controls="navBar"
                        data-toggle="collapse" data-target="#navBar">
              <span class="hamburger hamburger--slider">
            <span class="hamburger-box">
              <span class="hamburger-inner"></span>
              </span>
              </span>
                </button>
                <!-- End Responsive Toggle Button -->
                <!-- Logo -->
                <a href="#" class="navbar-brand">
                    <img src="{{ asset('assets/img/logo/logo-1.png') }}" alt="Image Description') }}">
                </a>
                <!-- End Logo -->

                <!-- Navigation -->
                <div class="collapse navbar-collapse align-items-center flex-sm-row g-pt-10 g-pt-5--lg" id="navBar">
                    <ul class="navbar-nav text-uppercase g-font-weight-600 ml-auto">
                        <li class="nav-item g-mx-20--lg">
                            <a href="#" class="nav-link px-0">Home

                            </a>
                        </li>

                        <li class="nav-item g-mx-20--lg {{ active_class(if_route_pattern(['blog'])) }}">
                            <a href="{{ route('home.blog') }}" class="nav-link px-0">Blog
                            </a>
                        </li>

                        <li class="nav-item g-mx-20--lg {{ active_class(if_route_pattern(['contact'])) }}">
                            <a href="{{ route('home.contact') }}" class="nav-link px-0">Kontakt
                            </a>
                        </li>

                        <li class="nav-item g-mx-20--lg">
                            <a href="{{ route('home.about') }}" class="nav-link px-0">Über uns
                            </a>
                        </li>

                        <li class="nav-item g-mx-20--lg {{ active_class(if_route_pattern(['faq'])) }}">
                            <a href="{{ route('faq.index') }}" class="nav-link px-0">FAQ</a>
                        </li>

                        @if (Auth::guest())
                            <li class="nav-item g-mx-20--lg {{ active_class(if_route_pattern(['login'])) }}">
                                <a href="{{ route('login') }}" class="nav-link px-0">Login</a>
                            </li>
                        @else

                            @include('layouts.navigation.partials.portfolio')

                            @include('layouts.navigation.partials.account')

                            @include('layouts.navigation.partials.admin')

                        @endif


                    </ul>
                </div>
                <!-- End Navigation -->
            </div>
        </nav>
    </div>
</header>
<!-- End Header -->


{{--<notifications--}}
{{--:user_id="{{ Auth::user()->id }}"--}}
{{--:unread="{{ json_encode(Auth::user()->unreadNotifications) }}"--}}
{{--show_url="{{ route('notifications.index') }}"--}}
{{--icon="fa-envelope">--}}
{{--</notifications>--}}
