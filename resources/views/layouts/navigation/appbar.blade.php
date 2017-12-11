<div class="js-mega-menu navbar navbar-expand-lg g-brd-y g-brd-2 g-brd-primary-dark-v1 g-bg-primary g-pa-0 g-z-index-4">
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