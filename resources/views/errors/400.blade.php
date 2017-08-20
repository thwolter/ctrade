@component('layouts.errors')

    @slot('page')
        400
    @endslot

    @slot('title')
        @lang('errorpages.400.title')
    @endslot

    @slot('message')
        @lang('errorpages.400.message')
    @endslot

@endcomponent