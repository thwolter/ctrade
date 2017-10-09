<div class="u-header__section u-header__section--hidden u-header__section--dark g-bg-black g-py-13">
    <div class="container">
        <div class="row flex-column flex-md-row align-items-center justify-content-between text-uppercase g-color-white g-font-size-11 g-mx-minus-15">
            <!-- Responsive Toggle Button -->
            <button class="g-hidden-md-up d-block btn btn-xs u-btn-primary g-brd-none g-line-height-1 mx-auto"
                    type="button" aria-controls="dropdown-megamenu" aria-expanded="false" aria-label="Toggle navigation"
                    data-toggle="collapse" data-target="#dropdown-megamenu">
              <span class="hamburger hamburger--slider">
            <span class="hamburger-box">
              <span class="hamburger-inner g-bg-white"></span>
              </span>
              </span>
            </button>
            <!-- End Responsive Toggle Button -->

            <div class="col-auto g-px-15 w-100 g-width-auto--md">
                <ul id="dropdown-megamenu" class="d-md-block collapse list-inline g-line-height-1 g-mx-minus-4 mb-0">

                    @auth

                        @include('layouts.navigation.partials.portfolio')

                        <li class="d-block g-hidden-md-down d-md-inline-block g-mx-4">|</li>

                        <li class="d-block d-md-inline-block g-mx-4">
                            <a href="{{ route('faq.index') }}"
                               class="g-color-white g-color-primary--hover g-text-underline--none--hover">FAQ</a>
                        </li>

                        <li class="d-block g-hidden-md-down d-md-inline-block g-mx-4">|</li>

                        <li class="d-block d-md-inline-block g-mx-4">
                            <a href="#"
                               class="g-color-white g-color-primary--hover g-text-underline--none--hover">Forums</a>
                        </li>

                    @endauth

                </ul>
            </div>

            <div class="col-auto g-px-15">

                <ul id="dropdown-account" class="list-inline g-line-height-1 g-mt-minus-10 g-mx-minus-4 mb-0">

                    @auth

                        @include('layouts.navigation.partials.admin')

                        <li class="d-block g-hidden-md-down d-md-inline-block g-mx-4">|</li>

                        @include('layouts.navigation.partials.account')

                    @endauth

                    @guest
                        <li class="list-inline-item g-mx-4 g-mt-10">
                            <a href="{{ route('login') }}"
                               class="g-color-white g-color-primary--hover g-text-underline--none--hover">Login</a>
                        </li>

                        <li class="list-inline-item g-mx-4 g-mt-10">|</li>
                        <li class="list-inline-item g-mx-4 g-mt-10">
                            <a href="{{ route('register') }}"
                               class="g-color-white g-color-primary--hover g-text-underline--none--hover">Register</a>
                        </li>

                      {{--@include('layouts.navigation.partials.search')--}}
                    @endguest
                </ul>
            </div>
        </div>
    </div>
</div>
    