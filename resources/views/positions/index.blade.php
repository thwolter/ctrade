@extends('layouts.portfolio')

@section('container-content')

    <dl>
        <dt>Barbestand:</dt>
        <dd>{{ $portfolio->present()->cash() }} </dd>
    </dl>



    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nr.</th>
                <th>Position</th>
                <th class="">Stück</th>
                <th class="table-cell-value">Gesamt</th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th class="table-cell-value"></th>
                <th class="table-cell-value">Summe</th>
                <th class="table-cell-value">{{ $portfolio->present()->total($portfolio->currencyCode()) }}</th>
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
                        <span><a href="#">Zukaufen</a></span>
                        <span><a href="#">Verkaufen</a></span>
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


