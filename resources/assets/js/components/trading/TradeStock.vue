<template>
    <form @submit.prevent="onSubmit">

        <!-- Spinner -->
        <div v-if="showSpinner">
            <spinner class="spinner-overlay"></spinner>
        </div>

        <!-- Form -->
        <div class="row">

            <!-- exchange -->
            <div class="form-group col-sm-4 col-md-3 col-md-offset-1">
                <label for="exchange" class="control-label">Handelsplatz</label>
                <div>
                    <select name="exchange" v-model="exchange" class="form-control">
                        <option v-for="(price, key) in stock.prices" :value="key">
                            {{ price.exchange }}
                        </option>
                    </select>
                </div>
            </div>

            <!-- price -->
            <div class="form-group col-sm-4 col-md-3">
                <label for="form.price" class="control-label">Preis</label>
                <div class="input-group">
                    <span class="input-group-addon">{{ form.currency }}</span>
                    <cleave v-model="form.price" :options="cleavePrice" class="form-control"
                        placeholder="Preis"></cleave>
                </div>
            </div>

            <!-- amount -->
            <div class="form-group col-sm-4 col-md-3">
                <label for="form.amount" class="control-label">Anzahl</label>
                <div>
                    <cleave v-model="form.amount" :options="cleaveAmount" placeholder="Anzahl"
                            :class="['form-control', { 'error': form.errors.has('amount') }]"
                            @input="form.errors.clear('amount')"></cleave>
                </div>
                <p v-if="form.errors.has('amount')" class="error-text">
                    <span v-text="form.errors.get('amount')"></span>
                </p>
            </div>

            <!-- date -->
            <div class="form-group col-sm-4 col-md-3 col-md-offset-1">
                <label for="form.executed" class="control-label">Datum</label>
                <div>
                    <div class="input-group date" id="datepicker">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <datepicker
                                v-model="form.executed"
                                name="date"
                                input-class="form-control"
                                language="de"
                                :disabled="disabled"
                                :full-month-name="true"
                                :monday-first="true"
                                ref="datepicker">
                        </datepicker>
                    </div>
                </div>
                <p v-if="form.errors.has('executed')" class="error-text">
                    <span v-text="form.errors.get('executed')"></span>
                </p>
            </div>

            <!-- fees -->
            <div class="form-group col-sm-4 col-md-3">
                <label for="form.fees" class="control-label">Gebühren</label>
                <div class="input-group">
                    <span class="input-group-addon">{{ form.currency }}</span>
                    <cleave v-model="form.fees" :options="cleaveAmount" placeholder="Gebühren"
                            :class="['form-control', { 'error': form.errors.has('fees') }]"
                            @input="form.errors.clear('fees')"></cleave>
                </div>
                <p v-if="form.errors.has('fees')" class="error-text">
                    <span v-text="form.errors.get('fees')"></span>
                </p>
            </div>

            <!-- total -->
            <div class="form-group col-sm-4 col-md-3">
                <label for="total" class="control-label">Gesamt</label>
                <div class="input-group">
                    <span class="input-group-addon">{{ form.currency }}</span>
                    <cleave v-model="total" :options="cleavePrice" :class="clsTotal"
                            readonly></cleave>
                </div>
                <div v-if="exceedCash" class="col-md-offset-1">
                    <p class="error-text pull-left">
                        Betrag übersteigt verfügbaren Barbestand.
                    </p>
                </div>

            </div>

        </div><!-- /.row -->

        <div class="modal-footer">

            <div>
                <button v-if="transaction === 'sell'" class="btn btn-warning" :disabled="hasError">Verkaufen</button>
                <button v-else class="btn btn-primary" :disabled="hasError">Kaufen</button>
            </div>
        </div>

    </form>
</template>

<script>

    import Datepicker from 'vuejs-datepicker';

    export default {

        components: {
            Datepicker
        },

        props: [
            'portfolioId',
            'instrumentType',
            'instrumentId',
            'storeRoute',
            'cash',
            'amount',
            'transaction',
            'minDate'
        ],

        data() {
            return {
                lookup: '/api/lookup',

                form: new Form({
                    portfolioId: this.portfolioId,
                    transaction: this.transaction,
                    instrumentId: null,
                    instrumentType: this.instrumentType,
                    price: null,
                    amount: null,
                    executed: null,
                    fees: 0,
                    currency: null,
                }),

                stock: [],
                exchange: 0,

                hasFormError: false,
                showSpinner: true,
                disabled: {},

                cleavePrice: {
                    numeral: true,
                    numeralDecimalMark: ',',
                    delimiter: '.',
                    numeralPositiveOnly: true
                },

                cleaveAmount: {
                    numeral: true,
                    numeralDecimalMark: ',',
                    delimiter: '.',
                    numeralPositiveOnly: true
                }
            }
        },

        methods: {

            onSubmit() {
                this.showSpinner = true;
                this.form.amount *= (this.transaction === 'sell') ? -1 : 1;

                this.form.post(this.storeRoute)
                    .then(data => {
                        window.location = data.redirect;
                    })
                    .catch(error => {
                        this.showSpinner = false;
                    });
            },


            fetch() {
                axios.get(this.lookup, {
                    params: {
                        instrumentId: this.instrumentId,
                        instrumentType: this.instrumentType
                    }
                })
                    .then(data => {
                        this.stock = data.data;
                        this.initiateForm();
                        this.updateExchange(this.exchange);

                        this.form.executed = this.lastPrice;
                        this.updatePrice();

                        this.showSpinner = false;
                    })
            },

            initiateForm() {
                this.form.currency = this.stock.item.currency;
                this.form.instrumentType = this.stock.item.type;
                this.form.instrumentId = this.stock.item.id;
            },

            updateExchange(index) {
                this.form.executed = _.first(Object.keys(this.stock.prices[index].history));
            },


            updatePrice() {
                this.form.price = this.stock.prices[this.exchange].history[this.form.executed];

                let firstPrice = new Date(this.firstPrice);
                let date = this.minDate ? new Date(Math.max(firstPrice, new Date(this.minDate))) : firstPrice;

                this.disabled = {
                    to: date,
                    from: new Date(this.lastPrice),
                    days: [6, 0]
                }
            },

            asNumeric(value) {
                let number = parseFloat(value);
                return (isNaN(number) || !value) ? 0 : number;
            },
        },

        watch: {
            exchange: function (index) {
                this.updateExchange(index);
            },

            form: {
                handler() {
                    this.hasFormError = this.form.errors.any();
                    this.form.executed = this.form.executed.toISOString().split('T')[0];
                    this.updatePrice();
                },
                deep: true
            }
        },

        computed: {
            total() {
                let price = this.asNumeric(this.form.price);
                let amount = this.asNumeric(this.form.amount);
                let fees = this.asNumeric(this.form.fees);
                return ((price * amount) + fees).toFixed(2);
            },

            exceedCash() {
                return (this.asNumeric(this.cash) < this.total);
            },

            clsTotal() {
                return this.exceedCash ? 'form-control error' : 'form-control';
            },

            hasError() {
                return (this.hasFormError || this.exceedCash);
            },

            firstPrice() {
                return _.last(Object.keys(this.stock.prices[this.exchange].history));
            },

            lastPrice() {
                return _.first(Object.keys(this.stock.prices[this.exchange].history));
            }
        },


        mounted() {

            this.$refs.datepicker.$on('opened', () => {
                this.form.errors.clear('executed');
                this.updatePrice();
            });

            this.fetch();
        }
    }
</script>
