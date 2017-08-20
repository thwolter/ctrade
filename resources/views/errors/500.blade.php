@component('layouts.errors')

  @slot('page')
    500
  @endslot

  @slot('title')
    @lang('errorpages.500.title')
  @endslot

  @slot('message')
    @lang('errorpages.500.message')
  @endslot

@endcomponent