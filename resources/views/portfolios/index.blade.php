@extends('layouts.master')

@section('content')

    <div class="content">
        <div class="container">

            @php( $focus = 'Meine Portfolios' )

                @if (count($portfolios) == 0)

                    <portlet title="Portfolio anlegen">
                        @include('portfolios.partials.welcome')
                    </portlet>

                    @if ($examples)
                        <portlet id="examples" title="Beispiele">
                            @foreach($examples as $portfolio)
                                @include('portfolios.partials.item')
                            @endforeach
                        </portlet>
                    @endif

                @else

                    <portlet title="Meine Portfolios">
                        @foreach($portfolios as $portfolio)
                            @php $route = route('portfolios.show', ['id' => $portfolio->id]) @endphp
                            <ol>
                                <li>
                                    <a href="{{ $route }}" class="">{{ $portfolio->name }}</a>
                                    <p>{{ $portfolio->description }}</p>
                                </li>
                            </ol>
                        @endforeach
                    </portlet>

                @endif
        </div>
    </div>
@endsection



