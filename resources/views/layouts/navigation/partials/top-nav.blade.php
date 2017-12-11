<!-- Navigation -->
<div id="navBar"
     class="collapse navbar-collapse align-items-center justify-content-end order-lg-last g-brd-top g-brd-none--lg g-brd-primary-dark-v1">
    <ul class="navbar-nav g-py-30 g-py-0--lg">

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

        <li class="nav-item g-my-8 {{ active_class(if_route_pattern(['blog'])) }}">
            <a href="{{ route('blog.index') }}"
               class="nav-link g-bg-primary-dark-v1--hover g-font-weight-600 g-font-size-default g-px-17 g-px-23--xl">
                Blog
            </a>
        </li>

        <li class="nav-item g-my-8 {{ active_class(if_route('home.contact')) }}">
            <a href="{{ route('home.contact') }}"
               class="nav-link g-bg-primary-dark-v1--hover g-font-weight-600 g-font-size-default g-px-17 g-px-23--xl">
                Kontakt
            </a>
        </li>

        <li class="nav-item g-my-8 {{ active_class(if_route('home.about')) }}">
            <a href="{{ route('home.about') }}"
               class="nav-link g-bg-primary-dark-v1--hover g-font-weight-600 g-font-size-default g-px-17 g-px-23--xl">
                Über uns
            </a>
        </li>

        <li class="nav-item g-my-8 {{ active_class(if_route('faq.index')) }}">
            <a href="{{ route('faq.index') }}"
               class="nav-link g-bg-primary-dark-v1--hover g-font-weight-600 g-font-size-default g-px-17 g-px-23--xl">
                FAQ
            </a>
        </li>

       @include('layouts.navigation.partials.top-auth')

    </ul>
</div>