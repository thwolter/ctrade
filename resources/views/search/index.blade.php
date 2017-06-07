@extends('layouts.portfolio')

@section('container-content')

    <div id="searchForm" class="input-form">
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
                        Suche nach Namen oder Branche
                    </span>
                </div>
            </div>

            @if (isset($suggest) and count($suggest) == 0)
                <div class="col-md-10 offset-md-2">
                    <div class="alert alert-info">
                        <p>Leider keine Ergebnisse gefunden.</p>
                        <p>Versuche es mit der WKN oder der ISIN oder gib
                            nur einen Teil des Namens ein.</p>
                    </div>
                </div>
            @endif

            <!-- submit button -->
            <div class="row buttons-row">
                <div class="col-md-10 offset-md-2">
                    {!! Form::submit('Suchen', ['class' => 'btn theme-btn-color']) !!}
                </div>
            </div>

        {!! Form::close() !!}
    </div>

    @if(isset($suggest) and count($suggest) > 0)
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
                        <th>Name/Sektor</th>
                        <th>WKN</th>
                        <th>ISIN</th>
                        <th>Kurs</th>
                    </tr>
                </thead>

                <tbody>
                     @php( $count = 0)
                     @foreach($suggest as $item)
                         @php ($sector = is_null($item->sector) ? '' : $item->sector->name)
                         <tr>
                             <td class="align-middle">{{ ++$count }}</td>
                             <td class="align-middle">{{ $item['typeDisp'] }}</td>
                             <td class="align-middle">{{ $item->currencyCode() }}</td>
                             <td class="align-middle">
                                 <span style="display:block">
                                     <a href="{{ route('search.show', [$portfolio->id, get_class($item), $item->id]) }}">
                                         {{ $item['name'] }}</a>
                                 </span>
                                 <span>{{ $sector }}</span>
                             </td>
                             <td>{{ $item->wkn }}</td>
                             <td>{{ $item->isin }}</td>
                             <td>{{ $item->present()->price() }}</td>
                         </tr>
                     @endforeach
                </tbody>
            </table>
        </div>
    @endif

@endsection


@section('scripts.footer')
    @if(isset($suggest) and count($suggest) > 0)
        <script>
            $(document).ready(function () {
                $('html, body').animate({
                    scrollTop: $('#searchResults').offset().top
                }, 800);
            });
        </script>
    @endif

    @if(isset($suggest) and count($suggest) == 0)
        <script>
            $(document).ready(function () {
                $('html, body').animate({
                    scrollTop: $('#searchForm').offset().top
                }, 800);
            });
        </script>
    @endif
@endsection

@section('scripts.footer')

@endsection



