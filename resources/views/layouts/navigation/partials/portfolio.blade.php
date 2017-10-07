<!-- Portfolios -->
<li class="nav-item dropdown g-mx-20--lg">
    <a href="#" class="nav-link dropdown-toggle g-px-0" id="nav-link-2" aria-haspopup="true"
       aria-expanded="false" aria-controls="section-home-submenu" data-toggle="dropdown"
       data-appear-speed="200" data-appear-easing="linear">Portfolios
    </a>
    <!-- Submenu (Bootstrap) -->
    <ul class="dropdown-menu font-weight-normal rounded-0 g-text-transform-none g-brd-none g-brd-top g-brd-primary g-brd-top-1 g-mt-20 g-mt-10--lg--scrolling"
        id="nav-submenu-2" aria-labelledby="nav-link-1">

        <!-- overview -->
        <li class="g-mx-5--lg">
            <a class="nav-link g-color-primary--hover"
               href="{{ route('portfolios.index') }}">
                @lang('portfolio.menu.overview')
            </a>
        </li>

        <!-- new portfolio -->
        <li class="g-mx-5--lg">
            <a class="nav-link g-color-primary--hover"
               href="{{ route('portfolios.create') }}">
                @lang('portfolio.menu.create')
            </a>
        </li>

        @foreach (Auth::user()->portfolios as $userPortfolio)
            <li class="g-mx-5--lg">
                <a class="nav-link g-color-primary--hover"
                   href="{{ route('portfolios.show', $userPortfolio) }}">
                    {{ $userPortfolio->name }}
                </a>
            </li>
        @endforeach

    </ul>
    <!-- End Submenu (Bootstrap) -->
</li>