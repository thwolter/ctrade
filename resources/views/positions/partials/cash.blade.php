<portlet id="cash-container" title="Barbestand">
    <buy-sell-btn inline-template>
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
                        <div class="buy-sell-icons text-center">
                            <a href="#" class="btn-link" @click="doBuy">
                                <i class="fa fa-plus-square buy-icon" aria-hidden="true"></i>
                            </a>
                            <a href="#" class="btn-link" @click="doSell">
                                <i class="fa fa-minus-square sell-icon" aria-hidden="true"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>

            <transition name="none">
                <div v-if="show" class="transaction-dialog">
                    <template v-if="buy">
                        <cash-trade route="{{ route('portfolios.deposit', $portfolio->id, false) }}"
                                    :deposit="true">
                        </cash-trade>
                    </template>

                    <div v-else>
                        <cash-trade route="{{ route('portfolios.withdraw', $portfolio->id, false) }}"
                                    :deposit="false">
                        </cash-trade>
                    </div>
                </div>
            </transition>

        </div>
    </buy-sell-btn>
</portlet>

<cash-success decimal=","></cash-success>