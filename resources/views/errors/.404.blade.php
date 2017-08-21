@component('layouts.errors')

    @slot('page')
        404
    @endslot

    @slot('title')
        @lang('errorpages.404.title')
    @endslot

    @slot('message')
        @lang('errorpages.404.message')
    @endslot

@endcomponent