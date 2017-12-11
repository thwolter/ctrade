<header id="js-header" class="u-header u-header--toggle-section u-header--change-appearance"
        data-header-fix-moment="600"
        data-header-fix-effect="slide">
    <div class="u-header__section g-transition-0_3"
         data-header-fix-moment-exclude="g-mt-0"
         data-header-fix-moment-classes="g-mt-minus-61 g-mt-minus-66--md">

       @include('layouts.navigation.navbar')
    </div>

    @isset($portfolio)
        @include('layouts.navigation.appbar')
    @endisset

</header>