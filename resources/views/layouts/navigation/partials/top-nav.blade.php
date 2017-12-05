<!-- Navigation -->
<div id="navBar"
     class="collapse navbar-collapse align-items-center justify-content-end order-lg-last g-brd-top g-brd-none--lg g-brd-primary-dark-v1">
    <ul class="navbar-nav g-py-30 g-py-0--lg">

        <li class="nav-item">
            <a href="#"
               class="nav-link g-bg-primary-dark-v1--hover g-font-weight-600 g-font-size-default g-px-17 g-px-23--xl g-py-15">
                Home
            </a>
        </li>

        <li class="nav-item {{ active_class(if_route_pattern(['blog'])) }}">
            <a href="{{ route('home.blog') }}"
               class="nav-link g-bg-primary-dark-v1--hover g-font-weight-600 g-font-size-default g-px-17 g-px-23--xl g-py-15">
                Blog
            </a>
        </li>

        <li class="nav-item {{ active_class(if_route('home.contact')) }}">
            <a href="{{ route('home.contact') }}"
               class="nav-link g-bg-primary-dark-v1--hover g-font-weight-600 g-font-size-default g-px-17 g-px-23--xl g-py-15">
                Kontakt
            </a>
        </li>

        <li class="nav-item {{ active_class(if_route('home.about')) }}">
            <a href="{{ route('home.about') }}"
               class="nav-link g-bg-primary-dark-v1--hover g-font-weight-600 g-font-size-default g-px-17 g-px-23--xl g-py-15">
                Über uns
            </a>
        </li>

       @include('top-auth')

    </ul>
</div>