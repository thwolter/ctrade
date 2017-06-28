@extends('layouts.master')

@section('content')

    <div class="content">
        <div class="container">
            @component('partials.portlet-boxed')

                @if (count($portfolios) == 0)
                    @slot('title', 'Beispiele')
                    @include('portfolios.partials.welcome')
                    @php ($portfolios = $examples)
                @else
                    @slot('title', 'Meine Portfolios')
                @endif

                @foreach($portfolios as $portfolio)
                    @include('portfolios.partials.item')
                @endforeach
            @endcomponent
        </div>
    </div>
@endsection



