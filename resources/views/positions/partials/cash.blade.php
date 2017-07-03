<portlet id="cash-container" title="Barbestand">
    <transaction-buttons inline-template>
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
                            <a href="#" class="btn-link" @click="makeDeposit">
                                <i class="fa fa-plus-square buy-icon" aria-hidden="true"></i>
                            </a>
                            <a href="#" class="btn-link" @click="makeWithdrawal">
                                <i class="fa fa-minus-square sell-icon" aria-hidden="true"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>

            <transition name="none">
                <div v-if="show" class="transaction-dialog">
                    <div v-if="direction === 'deposit'">

                        <h4 class="title">Geld einzahlen</h4>

                        <cash-trade route="{{ route('portfolios.deposit', $portfolio->id, false) }}"
                                    action="deposit">
                        </cash-trade>

                    </div>

                    <div v-else>
                        <!-- Form with method Post -->
                        {!! Form::open(['route' => ['portfolios.withdraw', $portfolio->id], 'method' => 'PUT']) !!}

                        <h3>Geld auszahlen</h3>

                        <div class="form-group">
                            {!! Form::label('cash', 'Betrag', ['class' => 'control-label col-xs-2 cursor-pointer']) !!}
                            <div class="col-xs-7">
                                <input-price id="withdraw" name="withdraw" class="form-control"
                                             symbol="EUR"></input-price>
                            </div>
                            <div class="col-xs-2">
                                {!! Form::submit('Auszahlen', ['class' => 'btn btn-primary']) !!}
                            </div>
                        </div>

                    </div>
                </div>
            </transition>
            {!! Form::close() !!}

        </div>
    </transaction-buttons>

</portlet>
