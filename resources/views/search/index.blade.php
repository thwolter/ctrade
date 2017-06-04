@extends('layouts.portfolio')

@section('container-content')

    <div class="input-form">
        <div class="form-title">Suchen</div>

        <!-- Form with method Get -->
        {!! Form::open([
            'route' => ['search.index', $portfolio->id],
             'method' => 'Get', 'class' => 'form-horizontal']) !!}

            @include('partials.errors')

            <!-- select type -->
            <div class="form-group row">
                {!! Form::label('type', 'Typ:', ['class' => 'col-md-2 col-form-label']) !!}
                <div class="col-md-10">
                    {!! Form::select('type', $types, null, ['class' => 'form-control']) !!}
                    <span class="help-block">
                        Momentan auf Aktien beschränkt; bald gibt's mehr!
                    </span>
                </div>
            </div><!-- /select type -->

            <!-- search form input -->
            <div class="form-group row">
                {!! Form::label('search', 'Suchen:', ['class' => 'col-md-2 col-form-label']) !!}
                <div class="col-md-10">
                    {!! Form::text('search', $search, ['placeholder' => 'Search ...', 'class' => 'form-control']) !!}
                    <span class="help-block">
                        Name, Wkn oder Isin
                    </span>
                </div>
            </div>

            <!-- submit button -->
            <div class="row buttons-row">
                <div class="col-md-10 offset-md-2">
                    {!! Form::submit('Suchen', ['class' => 'btn theme-btn-color']) !!}
                    <a href="{{ URL::previous() }}" class="btn btn-secondary">Zurück</a>
                </div>
            </div>

        {!! Form::close() !!}
    </div>

    @if(isset($suggest))
    <div id="searchResults" class="space-70"></div>
        <div>
            <h4>Suchergebnisse</h4>
            <div class="space-20"></div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nr.</th>
                        <th>Tpye</th>
                        <th>Währung</th>
                        <th>Name</th>
                        <th>WKN</th>
                        <th>ISIN</th>
                        <th>Sektor</th>
                    </tr>
                </thead>

                <tbody>
                     @php( $count = 0)
                     @foreach($suggest as $item)
                         <tr>
                             <td>{{ ++$count }}</td>
                             <td>{{ $item['typeDisp'] }}</td>
                             <td>{{ $item->currencyCode() }}</td>
                             <td><a href="{{ route('search.show', [$portfolio->id, get_class($item), $item->id]) }}">{{ $item['name'] }}</a></td>
                             <td>{{ $item->wkn }}</td>
                             <td>{{ $item->isin }}</td>
                             @php ($sector = is_null($item->sector) ? '' : $item->sector->name)
                             <td>{{ $sector }}</td>
                         </tr>
                     @endforeach
                </tbody>
            </table>
        </div>
    @endif

@endsection


@section('scripts.footer')
    <script>
        $(document).ready(function () {
            // Handler for .ready() called.
            $('html, body').animate({
                scrollTop: $('#searchResults').offset().top
            }, 800);
        });
    </script>
@endsection



