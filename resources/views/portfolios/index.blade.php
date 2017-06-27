@extends('layouts.master')

@section('content')

    @if (count($portfolios) == 0)
        @include('portfolios.partials.welcome')
        @component('partials.portlet-boxed')
            @slot('title', 'Beispiele')
            @foreach($examples as $portfolio)
                @include('portfolios.partials.item')
            @endforeach
        @endcomponent

    @endif

    @if (count($portfolios) > 0)
        @component('partials.portlet-boxed')
            @slot('title', 'Meine Portfolios')
            @foreach($portfolios as $portfolio)
                @include('portfolios.partials.item')
            @endforeach
        @endcomponent
    @endif
@endsection



