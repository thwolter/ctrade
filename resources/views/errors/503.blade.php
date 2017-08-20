@component('layouts.errors')

  @slot('page')
    503
  @endslot

  @slot('title')
    @lang('errorpages.503.title')
  @endslot

  @slot('message')
    @lang('errorpages.503.message')
  @endslot

@endcomponent