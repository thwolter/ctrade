@component('layouts.errors')

    @slot('page')
        403
    @endslot

    @slot('title')
        @lang('errorpages.403.title')
    @endslot

    @slot('message')
        @lang('errorpages.403.message')
    @endslot

@endcomponent