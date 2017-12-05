@component('layouts.components.sub-topbar')
    @slot('title')
        Portfolio
    @endslot

    <!-- overview -->
    <li class="dropdown-item g-px-5">
        <a class="nav-link g-color-text g-font-weight-600"
           href="{{ route('portfolios.index') }}">
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

@endcomponent