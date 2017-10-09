<!-- Portfolios -->
<li class="hs-has-sub-menu d-block d-md-inline-block g-pos-rel g-mx-4">
    <a href="#" id="dropdown-invoker-3"
       class="g-color-white g-color-primary--hover g-text-underline--none--hover"
       aria-haspopup="true" aria-expanded="false" aria-controls="dropdown-3">Portfolio
    </a>
    <ul id="dropdown-3" class="hs-sub-menu list-unstyled g-bg-gray-dark-v1 g-py-10 g-px-20 g-mt-13"
        aria-labelledby="dropdown-invoker-3">

        <!-- overview -->
        <li class="g-py-10">
            <a class="d-block g-text-underline--none--hover g-color-white g-color-primary--hoverr"
               href="{{ route('portfolios.index') }}">
                @lang('portfolio.menu.overview')
            </a>
        </li>

        <!-- new portfolio -->
        <li class="g-py-10">
            <a class="d-block g-text-underline--none--hover g-color-white g-color-primary--hover"
               href="{{ route('portfolios.create') }}">
                @lang('portfolio.menu.create')
            </a>
        </li>

        @foreach (Auth::user()->portfolios as $userPortfolio)
            <li class="g-py-10">
                <a class="d-block g-text-underline--none--hover g-color-white g-color-primary--hover"
                   href="{{ route('portfolios.show', $userPortfolio) }}">
                    {{ $userPortfolio->name }}
                </a>
            </li>
        @endforeach

    </ul>
    <!-- End Submenu (Bootstrap) -->
</li>