{{--
Provide a wrapper for sections with a collapsible card body and a dropdown menu.

@slot String $title
@slot String $subtitle
@slot Html $menu
@slot Slot
@param Boolean $collapse

--}}

@php
    if (isset($title)) {
        $id = kebab_case(html_entity_decode($title));
    } else {
        $title = "Please provide a slot named 'title'";
        $id = html_entity_decode($title);
    }

    $doCollapse = !(isset($collapse) && $collapse === false);
@endphp

<div id="transaction" class="card border-0 rounded-0 g-mb-40" role="tablist" aria-multiselectable="true">

    <!-- Header -->
    <div id="{{ $id }}-heading" role="tab"
         class="card-header d-flex align-items-center justify-content-between g-bg-gray-light-v5 border-0 g-mb-15">
        <h3 class="h6 g-pa-5">

            @if ($doCollapse)
                <a class="g-color-gray-dark-v3 g-text-underline--none--hover" href="#{{ $id }}-body"
                   data-toggle="collapse" data-parent="#{{ $id }}" aria-expanded="false"
                   aria-controls="{{ $id }}-body-01">
                    {{ $title }}
                    <span class="ml-3 fa fa-angle-down"></span>
                </a>
            @else
                {{ $title }}
            @endif
        </h3>

        @isset($subtitle)
            <div class="g-font-size-14 align-self-center">
                <span>{{ $subtitle }}</span>
            </div>
        @endisset

        @isset($menu)
            <div class="dropdown g-mb-10 g-mb-0--md">
            <span class="d-block g-color-primary--hover g-cursor-pointer g-mr-minus-5 g-pa-5"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-options-vertical g-pos-rel g-top-1"></i>
            </span>
                <div class="dropdown-menu dropdown-menu-right rounded-0 g-mt-10">
                    {{ $menu }}
                </div>
            </div>
        @endisset
    </div>

    <!-- Body -->
    <div id="{{ $id }}-body" class="{{ $doCollapse ? 'collapse' : '' }} g-mt-20" role="tabpanel"
         aria-labelledby="{{ $id }}-heading">

        {{ $slot }}

    </div>
</div>
