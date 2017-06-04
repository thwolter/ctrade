@extends('layouts.portfolio')

@section('container-content')

    <h3>Cash</h3>
    <div class="space-40"></div>

    <dl>
        <dt>Barbestand:</dt>
        <dd>{{ $portfolio->present()->cash() }} </dd>
    </dl>

    <div class="space-70"></div>
    <h3>Aktien</h3>
    <div class="space-40"></div>
    <table class="table table-striped table-responsive">

        <thead>
            <tr>
                <th>Nr.</th>
                <th>Position</th>
                <th class="">Stück</th>
                <th class="table-cell-value">Gesamt</th>
                <th></th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th class="table-cell-value">Summe</th>
                <th class="table-cell-value">{{ $portfolio->present()->total($portfolio->currencyCode()) }}</th>
                <th></th>
            </tr>
        </tfoot>

        <tbody>
            @php( $count = 0)
            @foreach($portfolio->positions as $position)
                <tr>
                    <td class="align-middle">{{ ++$count }}</td>
                    <td class="align-middle">
                        <h5><a href="{{ route('positions.show', ['pid' => $portfolio->id, 'id' => $position->id]) }}">
                                {{ $position->name() }}</a>
                        </h5>
                        <span>
                            {{ $position->typeDisp() }} | {{ $position->present()->price() }}
                            ({{ $position->present()->priceDate() }})
                        </span>
                    </td>
                    <td class="align-middle table-cell-value">{{ $position->amount() }}</td>
                    <td class="align-middle table-cell-value">
                        {{ $position->present()->total() }}
                        @if ($position->currencyCode() != $portfolio->currencyCode())
                            <span>{{ $position->present()->total($portfolio->currencyCode()) }}</span>
                        @endif
                    </td>

                    <td class="align-middle">
                        <p style="margin-bottom: 0px"><a href="#">Zukaufen</a></p>
                        <p style="margin-bottom: 0px"><a href="#">Verkaufen</a></p>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Form with method Post -->
    {!! Form::open(['route' => ['positions.create', $portfolio->id], 'method' => 'Get']) !!}

        <div class="form-group">
            {!! Form::submit('Neue Position', ['class' => 'btn theme-btn-color']) !!}
        </div>

    {!! Form::close() !!}


@endsection


