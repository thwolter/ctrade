<li class="nav-item hs-has-sub-menu">
    <a id="nav-link--listing" class="nav-link g-color-white g-brd-right--lg g-brd-primary-dark-v1 g-bg-primary-dark-v1--hover g-font-weight-600 g-font-size-default g-px-17 g-px-23--xl g-py-15" href="#"
       aria-haspopup="true"
       aria-expanded="false"
       aria-controls="nav-submenu--listing">
        {{ $title }}
    </a>

    <!-- Submenu -->
    <ul id="nav-submenu--listing" class="hs-sub-menu list-unstyled u-shadow-v11 g-min-width-220 g-mt-2"
        aria-labelledby="nav-link--listing">

        {{ $slot }}

    </ul>
    <!-- End Submenu -->
</li>
