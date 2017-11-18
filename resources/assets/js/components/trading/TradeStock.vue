<template>

    <form @submit.prevent="onSubmit">

        <!-- Spinner -->
        <div v-if="showSpinner" class="spinner-gritcode">
            <vue-simple-spinner class="spinner-wrapper" message="Kurse laden"></vue-simple-spinner>
        </div>

        <div class="row">

            <!-- Select Exchange -->
            <div class="col-md-6 g-mb-20">
                <div class="form-group">
                    <label for="exchange" class="g-mb-10">Handelsplatz</label>
                    <select name="exchange" v-model="exchange"
                            class="form-control form-control-md rounded-0"
                            data-open-icon="fa fa-angle-down"
                            data-close-icon="fa fa-angle-up">
                        <option v-for="(price, key) in stock.prices" :value="key">
                            {{ price.exchange }}
                        </option>
                    </select>
                </div>
            </div>

            <!-- Price Input -->
            <div class="col-md-6 g-mb-20">
                <div class="form-group">
                    <label for="form.price" class="g-mb-10">Preis</label>
                    <div class="input-group g-brd-primary--focus">
                        <div class="input-group-addon d-flex align-items-center g-bg-white g-color-gray-light-v1 rounded-0">
                            {{ portfolio.currency }}
                        </div>
                        <cleave id="price"
                                v-model="form.price"
                                placeholder="Preis"
                                :options="cleavePrice"
                                class="form-control form-control-md rounded-0">
                        </cleave>
                        <small v-if="form.errors.has('amount')" class="form-control-feedback">
                            {{ form.errors.get('amount') }}
                        </small>
                    </div>
                </div>
            </div>

            <!-- Amount Input -->
            <div class="col-md-6 g-mb-20">
                <div class="form-group">
                    <label for="form.amount" class="g-mb-10">Anzahl</label>
                    <cleave v-model="form.amount"
                            :options="cleaveAmount"
                            placeholder="Anzahl"
                            class="form-control form-control-md"
                            @input="form.errors.clear('amount')">
                    </cleave>
                    <small v-if="form.errors.has('amount')" class="form-control-feedback">
                        {{ form.errors.get('amount') }}
                    </small>
                </div>
            </div>


            <!-- Select Date -->
            <div class="col-md-6 g-mb-20">
                <div class="form-group"
                     :class="[ overlap || form.errors.has('date') ? 'u-has-error-v1-2' : '' ]">
                    <label for="executed" class="g-mb-10">Datum</label>
                    <div>
                        <div class="input-group g-brd-primary--focus">
                            <datepicker id="executed"
                                        v-model="form.executed"
                                        name="executed"
                                        wrapper-class="w-100"
                                        input-class="form-control form-control-md w-100 g-brd-right-none rounded-0 g-bg-white"
                                        language="de"
                                        placeholder="Datum"
                                        :full-month-name="true"
                                        :monday-first="true"
                                        :disabled="state.disabled"
                                        :highlighted="state.highlighted"
                                        ref="datepicker"
                                        @input="form.errors.clear('executed')">
                            </datepicker>
                            <div class="input-group-addon d-flex align-items-center g-bg-white g-color-gray-dark-v5 rounded-0 g-brd-left-non">
                                <i class="icon-calendar"></i>
                            </div>
                        </div>
                    </div>
                    <small v-if="form.errors.has('executed')" class="form-control-feedback">
                        <span v-text="form.errors.get('executed')"></span>
                    </small>
                </div>

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

        props: {
            portfolio: {
                type: Object,
                required: true
            },
            instrument: {
                type: Object,
                required: true
            },
            route: {
                type: String,
                required: true
            },
            transaction: {
                type: String,
                required: true
            },
            minDate: {
                type: String,
                required: true
            }
        },

        data() {
            return {
                lookup: '/api/lookup',

                form: new Form({
                    portfolioId: this.portfolio.id,
                    instrumentId: this.instrument.id,
                    instrumentType: this.instrument.type,
                    currency: this.instrument.currency,

                    transaction: this.transaction,
                    price: null,
                    amount: null,
                    executed: null,
                    fees: 0,
                }),

                stock: [],
                exchange: 0,

                hasFormError: false,
                showSpinner: true,
                disabled: {},

                state: {
                    disabled: {
                        from: new Date()
                    },
                    highlighted: {
                        dates: [new Date()]
                    }
                },

                cleavePrice: {
                    numeral: true,
                    numeralDecimalMark: ',',
                    numeralDecimalScale: 2,
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

                this.form.post(this.route)
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
                        instrumentId: this.instrument.id,
                        instrumentType: this.instrument.type
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
//                this.form.currency = this.stock.item.currency;
//                this.form.instrumentType = this.stock.item.type;
//                this.form.instrumentId = this.stock.item.id;
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
                return (this.asNumeric(this.portfolio.cash) < this.total);
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
            },

            overlap() {

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
