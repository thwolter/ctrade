@extends('layouts.master')

@section('content')

    <div class="content">
        <div class="container">

            @if (count($portfolios) == 0)
            
                <portlet title="Portfolio anlegen">    
                    @include('portfolios.partials.welcome')
                    @php ($portfolios = $examples)
                </portlet>
                
                <portlet id="examples" title="Beispiele">
                     @foreach($examples as $portfolio)
                        @include('portfolios.partials.item')
                    @endforeach
                </portlet>
            
            @else
                
                <portlet title="Meine Portfolios">
                    @foreach($portfolios as $portfolio)
                        @include('portfolios.partials.item')
                    @endforeach
                </portlet>
                
            @endif
        </div>
    </div>
@endsection



