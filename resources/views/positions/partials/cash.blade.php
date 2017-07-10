<portlet id="cash-container" title="Barbestand">
    
        <div>
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
                        <buy-sell-btn 
                            event-buy="depositCash" event-sell="withdrawCash"
                            toggle="false">
                        </buy-sell-btn>
                    </td>
                </tr>
                </tbody>
            </table>

            <cash-trade 
                id="{{ $portfolio->id }}"
                route="{{ route('portfolios.pay', [], false) }}">
            </cash-trade>
                   

        </div>
    </buy-sell-btn>
</portlet>

<cash-success decimal=","></cash-success>