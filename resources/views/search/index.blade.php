@extends('layouts.portfolio')

@section('container-content')

    <h5 class="text-uppercase">Position hinzufügen</h5>

    <!-- Form with method Get -->
    {!! Form::open([
        'route' => ['search.index', $portfolio->id],
         'method' => 'Get', 'class' => 'form-horizontal']) !!}

        @include('partials.errors')

        <!-- select type -->
        <div class="form-group row">
            {!! Form::label('type', 'Typ:', ['class' => 'col-md-3 offset-md-1 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::select('type', $types, null, ['class' => 'form-control']) !!}
                <span class="help-block">
                    Momentan auf Aktien beschränkt; bald gibt's mehr!
                </span>
            </div>
        </div><!-- /select type -->

        <!-- search form input -->
        <div class="form-group row">
            {!! Form::label('search', 'Suchen:', ['class' => 'col-md-3 offset-md-1 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::text('search', $search, ['placeholder' => 'Search ...', 'class' => 'form-control']) !!}
                <span class="help-block">
                    Name, Wkn oder Isin
                </span>
            </div>
        </div>

        <!-- submit button -->
        <div class="text-right">
            {!! Form::submit('Suchen', ['class' => 'btn theme-btn-color']) !!}
            <button href="{{ URL::previous() }}" class="btn theme-btn-outline">Abbrechen</button>
        </div>

    {!! Form::close() !!}
    <div class="space-70"></div>


    @if(isset($suggest))

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
    @endif

@endsection


