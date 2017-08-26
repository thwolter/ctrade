<portlet id="cash-container" title="Barbestand">
    
        <div class="table-responsive">
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
                <tr class="">
                    <td class="align-middle">1</td>
                    <td class="align-middle">Cash</td>
                    <td class="text-right">{{ $portfolio->present()->cash }}</td>
                    <td></td>

                    <td class="align-middle">
                        <buy-sell-btn 
                            event-buy="depositCash" event-sell="withdrawCash"
                            id="{{ $portfolio->id }}" toggle="false">
                        </buy-sell-btn>
                    </td>
                </tr>
                </tbody>
            </table>

            <cash-trade
                route="{{ route('portfolios.pay', [], false) }}"
                cash="{{ $portfolio->cash }}">
            </cash-trade>
                   

        </div>
    </buy-sell-btn>
</portlet>
