@extends('layouts.master')

@section('content')

    <div class="content">
        <div class="container">

            <div id="styledModal" class="modal show">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title">Styled Modal</h3>
                        </div> <!-- /.modal-header -->

                        <div class="modal-body">

                            <!-- Search input -->
                            <div id="searchForm" class="input-form">

                                <!-- Form with method Get -->
                                {!! Form::open([
                                    'route' => ['search.index', $portfolio->id],
                                    'method' => 'Get', 'class' => 'form-horizontal']) !!}

                                @include('partials.errors')
                                @include('search.partials.resultsError')

                                <div class="row">
                                    <!-- select type -->
                                    <div class="form-group row">
                                        {!! Form::label('type', 'Typ:', ['class' => 'control-label col-sm-2 col-sm-offset-1']) !!}
                                        <div class="col-sm-8">
                                            {!! Form::select('type', $types, null, ['class' => 'form-control']) !!}
                                            <span class="help-block">
                                    Momentan auf Aktien beschränkt; bald gibt's mehr!
                                </span>
                                        </div>
                                    </div><!-- /select type -->

                                    <!-- search form input -->
                                    <div class="form-group row">
                                        {!! Form::label('search', 'Suchen:', ['class' => 'control-label col-sm-2 col-sm-offset-1']) !!}
                                        <div class="col-sm-8">
                                            {!! Form::text('search', $search, ['placeholder' => 'Name, WKN, ISIN, ...', 'class' => 'form-control']) !!}
                                            <span class="help-block">
                                    Suche nach Namen oder Branche
                                </span>
                                        </div>
                                    </div>

                                    <!-- submit button -->
                                    <div class="col-sm-offset-3">
                                        {!! Form::submit('Suchen', ['class' => 'btn btn-primary']) !!}
                                    </div>

                                    {!! Form::close() !!}
                                </div>

                                <!-- Search results -->
                                @if(isset($suggest) and count($suggest) > 0)
                                    <div>
                                        <table class="table table-striped table-hover positions-table">
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
                                     <a href="{{ route('search.show', [$portfolio->id, 'type' => $type, 'id' => $item->id]) }}">
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
                                    </portlet>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


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

