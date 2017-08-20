@component('layouts.errors')

    @slot('page')
        401
    @endslot

    @slot('title')
        @lang('errorpages.401.title')
    @endslot

    @slot('message')
        @lang('errorpages.401.message')
    @endslot

@endcomponent