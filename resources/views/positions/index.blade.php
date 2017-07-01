@extends('layouts.master')

@section('content')


    @if (count($portfolio->positions) == 0)
        @include('positions.partials.empty')
    @else

        <div class="content">
            <div class="container">
                <div class="row">
                    <portlet name="Aktien">
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

                    <!-- Form with method Post -->
                    {!! Form::open(['route' => ['positions.create', $portfolio->id], 'method' => 'Get']) !!}
                    <div class="pull-right">
                        {!! Form::submit('Neue Position', ['class' => 'btn theme-btn-color']) !!}
                    </div>
                    {!! Form::close() !!}

                </portlet>
                </div>
            </div>
        </div>
    @endif
@endsection


