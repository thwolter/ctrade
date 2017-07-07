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