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
                <a href="../../../index.html" class="navbar-brand">
                    <img src="{{ asset('assets/img/logo/logo-1.png" alt="Image Description') }}">
                </a>
                <!-- End Logo -->

                <!-- Navigation -->
                <div class="collapse navbar-collapse align-items-center flex-sm-row g-pt-10 g-pt-5--lg" id="navBar">
                    <ul class="navbar-nav text-uppercase g-font-weight-600 ml-auto">
                        <li class="nav-item g-mx-20--lg">
                            <a href="#" class="nav-link px-0">Home

                            </a>
                        </li>

                        <li class="nav-item g-mx-20--lg">
                            <a href="{{ route('home.blog') }}" class="nav-link px-0">Blog

                            </a>
                        </li>

                        <li class="nav-item g-mx-20--lg active">
                            <a href="{{ route('home.contact') }}" class="nav-link px-0">Kontakt
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>

                        <li class="nav-item g-mx-20--lg active">
                            <a href="{{ route('home.about') }}" class="nav-link px-0">Über uns
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>

                        <li class="nav-item g-mx-20--lg active">
                            <a href="{{ route('faq.index') }}" class="nav-link px-0">FAQ
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>

                        @if (Auth::guest())
                            <li><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        @else
                            <li class="nav-item dropdown g-mx-20--lg">
                                <a href="#" class="nav-link dropdown-toggle g-px-0" id="nav-link-1" aria-haspopup="true"
                                   aria-expanded="false" aria-controls="section-home-submenu" data-toggle="dropdown"
                                   data-appear-speed="200" data-appear-easing="linear">Account

                                </a>
                                <!-- Submenu (Bootstrap) -->
                                <ul class="dropdown-menu font-weight-normal rounded-0 g-text-transform-none g-brd-none g-brd-top g-brd-primary g-brd-top-1 g-mt-20 g-mt-10--lg--scrolling"
                                    id="nav-submenu-1" aria-labelledby="nav-link-1">
                                    <li class="active g-mx-5--lg">
                                        <a class="nav-link g-color-primary--hover"
                                           href="{{ route('users.edit', ['tab' => 'profile']) }}">
                                            Mein Profil
                                        </a>
                                    </li>
                                    <li class="g-mx-5--lg">
                                        <a class="nav-link g-color-primary--hover"
                                           href="{{ route('users.edit', ['tab' => 'password']) }}">
                                            Passwort
                                        </a>
                                    </li>
                                    <li class="g-mx-5--lg">
                                        <a class="nav-link g-color-primary--hover"
                                           href="{{ route('users.edit', ['tab' => 'messaging']) }}">
                                            Emails
                                        </a>
                                    </li>
                                    <li class="g-mx-5--lg">
                                        <a class="nav-link g-color-primary--hover" href="{{ route('logout') }} onclick="
                                           event.preventDefault(); document.getElementById('logout-form').submit();"">
                                        Logout
                                        </a>
                                    </li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </ul>
                                <!-- End Submenu (Bootstrap) -->
                            </li>
                        @endif

                        @role('admin')
                        <ul class="dropdown-menu font-weight-normal rounded-0 g-text-transform-none g-brd-none g-brd-top g-brd-primary g-brd-top-1 g-mt-20 g-mt-10--lg--scrolling"
                            id="nav-submenu-1" aria-labelledby="nav-link-1">
                            <li class="active g-mx-5--lg">
                                <a class="nav-link g-color-primary--hover" href="/admin/dashboard">
                                    Backpack
                                </a>
                            </li>
                            <li class="g-mx-5--lg">
                                <a class="nav-link g-color-primary--hover" href="/horizon">
                                    Horizon
                                </a>
                            </li>
                            <li class="g-mx-5--lg">
                                <a class="nav-link g-color-primary--hover"
                                   href="{{ route('users.edit', ['tab' => 'messaging']) }}">
                                    Emails
                                </a>
                            </li>
                        </ul>
                        @endrole

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
