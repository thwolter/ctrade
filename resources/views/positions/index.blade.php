@extends('layouts.portfolio')

@section('container-content')


    @if (count($portfolio->positions) == 0)
        @include('positions.partials.empty')
    @else

        <h3>Zusammenfassung</h3>
        <div class="space-20"></div>

        <div class="boxed-container">
            <table class="summary-table">
                <tr>
                    <td class="table-key">Barbestand</td>
                    <td class="pull-right table-value">{{ $portfolio->present()->cash() }}</td>
                </tr>
                <tr>
                    <td class="table-key">Aktien</td>
                    <td class="pull-right table-value">{{ $portfolio->present()->stockTotal() }}</td>
                </tr>
                <tfoot>
                    <tr>
                        <th class="table-key">Gesamt</th>
                        <th class="pull-right table-value">{{ $portfolio->present()->total() }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="space-40"></div>

        <!-- Form with method Post -->
        {!! Form::open(['route' => ['positions.create', $portfolio->id], 'method' => 'Get']) !!}
            <div class="pull-right">
                {!! Form::submit('Neue Position', ['class' => 'btn theme-btn-color']) !!}
            </div>
        {!! Form::close() !!}

        <div class="space-70"></div>
        <h3>Aktien</h3>
        <div class="space-40"></div>
        <table class="table table-striped">

            <thead>
                <tr>
                    <th>Nr</th>
                    <th>Aktien</th>
                    <th class="text-right">Stück</th>
                    <th class="text-right">Gesamt</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @php( $count = 0)
                @foreach($portfolio->positions as $position)
                    <tr>
                        <td class="align-middle">{{ ++$count }}</td>
                        <td class="align-middle">
                            <h5><a href="{{ route('positions.show', ['id' => $position->id]) }}">
                                    {{ $position->name() }}</a>
                            </h5>
                            <span>
                                {{ $position->typeDisp() }} | {{ $position->present()->price() }}
                                ({{ $position->present()->priceDate() }})
                            </span>
                        </td>
                        <td class="align-middle text-right">{{ $position->amount() }}</td>
                        <td class="align-middle text-right">
                            {{ $position->present()->total() }}
                            @if ($position->currencyCode() != $portfolio->currencyCode())
                                <div>({{ $position->present()->total($portfolio->currencyCode()) }})</div>
                            @endif
                        </td>

                        <td class="align-middle">
                            <div class="buy-sell-group">
                                <a href="{{ route('positions.buy', ['id' => $position->id]) }}">
                                    <i class="fa fa-plus-square-o buy-sell-icon" aria-hidden="true"></i>
                                </a>
                                <a href="{{ route('positions.sell', ['id' => $position->id]) }}">
                                    <i class="fa fa-minus-square-o buy-sell-icon" aria-hidden="true"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection


