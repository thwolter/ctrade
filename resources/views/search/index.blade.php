@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <!-- Form with method Get -->
            {!! Form::open([
                'route' => ['search.index', $portfolio->id],
                'method' => 'Get', 'class' => 'form-horizontal']) !!}

            @include('partials.errors')

            <!-- select type -->
            <div class="form-group">
                {!! Form::label('type', 'Typ:', ['class' => 'col-md-1 control-label']) !!}
                <div class="col-md-8">
                    {!! Form::select('type', $types, null, ['class' => 'form-control']) !!}
                    <span class="help-block">
                        Momentan auf Aktien beschränkt; bald gibt's mehr!
                    </span>
                </div>
            </div>

            <!-- search form input -->
            <div class="form-group">
                {!! Form::label('search', 'Suchen:', ['class' => 'col-md-1 control-label']) !!}
                <div class="col-md-8">
                    {!! Form::text('search', null, ['placeholder' => 'Search ...', 'class' => 'form-control']) !!}
                    <span class="help-block">
                        Name, Wkn oder Isin
                    </span>
                </div>
            </div>

            <!-- submit button -->
            <div class="form-group">
                <div class="col-md-8 col-md-offset-1">
                    {!! Form::submit('Suchen', ['class' => 'btn btn-primary']) !!}
                    <a href="{{ URL::previous() }}" class="btn btn-default">Abbrechen</a>
                </div>
            </div>

            {!! Form::close() !!}


            @if(isset($suggest))

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Nr.</th>
                    <th>Tpye</th>
                    <th>Währung</th>
                    <th>Name</th>
                    <th>WKN</th>
                    <th>ISIN</th>
                    <th>Sektor</th>
                    <th>Kurs</th>
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
                        <td style="text-align: right">{{ $item->present()->price() }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>

@endsection


