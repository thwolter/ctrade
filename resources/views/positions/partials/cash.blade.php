<portlet title="Barbestand">
    <table class="table table-striped table-hover positions-table">
        <thead>
        <tr>
            <th>Nr</th>
            <th>Position</th>
            <th class="text-right">Gesamt</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr class="h5">
            <td class="align-middle">1</td>
            <td class="align-middle">Cash</td>
            <td class="text-right">{{ $portfolio->present()->cash }}</td>
            <td></td>

            <td class="align-middle">
                <div class="buy-sell-icons text-center">
                    <a href="{{ route('positions.buy', ['id' => 0]) }}">
                        <i class="fa fa-plus-square buy-icon" aria-hidden="true"></i>
                    </a>
                    <a href="{{ route('positions.sell', ['id' => 0]) }}">
                        <i class="fa fa-minus-square sell-icon" aria-hidden="true"></i>
                    </a>
                </div>
            </td>
        </tr>
        </tbody>
    </table>

    <!-- Form with method Post -->
    {!! Form::open(['route' => ['positions.create', $portfolio->id], 'method' => 'Get']) !!}
    <div>
        {!! Form::submit('Position hinzufügen', ['class' => 'btn btn-default']) !!}
    </div>
    {!! Form::close() !!}

</portlet>
