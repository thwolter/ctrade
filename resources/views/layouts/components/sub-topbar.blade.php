<li class="list-inline-item g-pos-rel g-mx-2">
    <a id="{{ $title }}-dropdown-invoker"
       class="u-link-v5 g-color-gray-dark-v5 g-color-primary--hover g-font-weight-500 g-font-size-12 g-pa-10"
       href="#"
       aria-controls="{{ $title }}-dropdown"
       aria-haspopup="true"
       aria-expanded="false"
       data-dropdown-event="hover"
       data-dropdown-target="#{{ $title }}-dropdown"
       data-dropdown-type="css-animation"
       data-dropdown-duration="0"
       data-dropdown-hide-on-scroll="true"
       data-dropdown-animation-in="fadeIn"
       data-dropdown-animation-out="fadeOut">
        {{ $title }}
        <i class="ml-2 fa fa-angle-down"></i>
    </a>

    <ul id="{{ $title }}-dropdown"
        class="list-unstyled u-shadow-v11 g-min-width-220 g-bg-white g-pos-abs g-left-0 g-z-index-99 g-mt-28"
        aria-labelledby="{{ $title }}-dropdown-invoker">

       {{ $slot }}
    </ul>
</li>
