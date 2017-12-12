@auth
    <li class="nav-item g-my-8">
        <a href="{{ route('portfolios.index') }}"
           class="nav-link g-bg-primary-dark-v1--hover g-font-weight-600 g-font-size-default g-px-17 g-px-23--xl">
            Portfolios
        </a>
    </li>
@endauth

@guest
    <li class="nav-item g-my-8">
        <a href="{{ route('home') }}"
           class="nav-link g-bg-primary-dark-v1--hover g-font-weight-600 g-font-size-default g-px-17 g-px-23--xl">
            Home
        </a>
    </li>
@endguest