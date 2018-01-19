<template>
    <div v-if="success">
        <div class="u-shadow-v4 g-bg-white g-brd-around g-brd-gray-light-v4 g-line-height-2 g-pa-40 g-mb-30" role="alert">
            <h3 class="h2 g-font-weight-300 g-mb-20">Kauf erfolgreich</h3>
            <p class="mb-0">
                Deinem Portfolio wurden {{ form.amount }} {{ stock.name }} Aktien im Wert
                von insgesamt {{ netTotal }} {{ portfolio.currency }} hinzugefügt.
            </p>

            <div class="g-mt-20">
                <button @click="onRedirect" class="btn u-btn-blue g-mr-10 g-mb-15">Portfolioübersicht</button>
                <button @click="onTransaction" class="btn u-btn-outline-blue g-mr-10 g-mb-15">Neue Transaktion</button>
            </div>
        </div>
    </div>

    <div v-else style="position: relative;">
        <form @submit.prevent="onSubmit" class="g-pa-20">

            <!-- Spinner -->
            <div v-if="showSpinner" class="spinner-gritcode">
                <vue-simple-spinner class="spinner-wrapper" message="Kurse laden ..."></vue-simple-spinner>
            </div>

            <!-- Select Buttons -->
            <div class="justify-content-center d-flex">
                <div class="w-50">
                    <div class="btn-group justified-content g-my-30">
                        <label class="g-width-120 u-check">
                            <input id="buy"
                                   v-model="form.transaction"
                                   type="radio"
                                   value="buy"
                                   class="g-hidden-xs-up g-pos-abs g-top-0 g-left-0"
                                   checked>
                            <span class="btn btn-md btn-block u-btn-outline-lightgray g-color-white--checked g-bg-primary--checked rounded-0">
                            Kauf
                        </span>
                        </label>
                        <label class="g-width-120 u-check">
                            <input id="sell"
                                   v-model="form.transaction"
                                   type="radio"
                                   value="sell"
                                   class="g-hidden-xs-up g-pos-abs g-top-0 g-left-0">
                            <span class="btn btn-md btn-block u-btn-outline-lightgray g-color-white--checked g-bg-primary--checked g-brd-left-none--md rounded-0">
                            Verkauf
                        </span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Input Fields -->
            <div class="row g-mb-20 row">

                <!-- Left Column -->
                <div class="col-md-6">

                    <!-- Exchange Select -->
                    <div class="mb-3">
                        <label for="exchange" class="d-block g-color-gray-dark-v2 g-font-size-13">Handelsplatz</label>
                        <select id="exchange"
                                name="exchange"
                                v-model="exchange"
                                class="custom-select form-control u-form-control g-placeholder-gray-light-v1 rounded-0 g-py-15 h-50"
                                data-open-icon="fa fa-angle-down"
                                data-close-icon="fa fa-angle-up">
                            <option v-for="(price, key) in stock.prices" :value="key">
                                {{ price.exchange }}
                            </option>
                        </select>
                    </div>

                    <!-- Date Select -->
                    <div class="mb-3"
                         :class="[ overlap || form.errors.has('executed') ? 'u-has-error-v1-2' : '' ]">
                        <label class="d-block g-color-gray-dark-v2 g-font-size-13">Datum</label>
                        <div class="input-group g-brd-primary--focus">
                            <datepicker id="executed"
                                        v-model="form.executed"
                                        name="executed"
                                        wrapper-class="w-100"
                                        input-class="form-control u-form-control g-placeholder-gray-light-v1 rounded-0 g-py-15 g-brd-right-none w-100 g-bg-white"
                                        language="de"
                                        placeholder="Datum"
                                        :full-month-name="true"
                                        :monday-first="true"
                                        :disabled="state.disabled"
                                        :highlighted="state.highlighted"
                                        ref="datepicker"
                                        @input="form.errors.clear('executed')">
                            </datepicker>
                            <div class="input-group-addon d-flex align-items-center g-bg-white g-color-gray-dark-v5 rounded-0 g-brd-left-none">
                                <i class="icon-calendar"></i>
                            </div>
                        </div>
                        <small v-if="form.errors.has('executed')" class="form-control-feedback">
                            {{ form.errors.get('executed') }}
                        </small>
                    </div>

                    <!-- Price Input -->
                    <div class="mb-3"
                         :class="[ form.errors.has('price') ? 'u-has-error-v1-2' : '' ]">
                        <label for="price" class="d-block g-color-gray-dark-v2 g-font-size-13">Preis</label>
                        <div class="input-group g-brd-primary--focus">
                            <div class="input-group-addon d-flex align-items-center g-bg-white g-color-gray-light-v1 rounded-0">
                                {{ portfolio.currency }}
                            </div>
                            <cleave id="price"
                                    v-model="form.price"
                                    class="form-control u-form-control g-placeholder-gray-light-v1 rounded-0 g-py-15"
                                    placeholder="Preis"
                                    :options="cleavePrice"
                                    @input="form.errors.clear('price')">
                            </cleave>
                        </div>
                        <small v-if="form.errors.has('price')" class="form-control-feedback">
                            {{ form.errors.get('price') }}
                        </small>
                    </div>

                    <!-- Amount Input -->
                    <div class="mb-3"
                         :class="[ form.errors.has('amount') ? 'u-has-error-v1-2' : '' ]">
                        <label for="amount" class="d-block g-color-gray-dark-v2 g-font-size-13">Anzahl</label>
                        <cleave id="amount"
                                v-model="form.amount"
                                class="form-control u-form-control g-placeholder-gray-light-v1 rounded-0 g-py-15"
                                :options="cleaveAmount"
                                placeholder="Anzahl"
                                @input="form.errors.clear('amount')">
                        </cleave>
                        <small v-if="form.errors.has('amount')" class="form-control-feedback">
                            {{ form.errors.get('amount') }}
                        </small>
                    </div>

                    <!-- Fees Input -->
                    <div class="mb-3"
                         :class="[ form.errors.has('fees') ? 'u-has-error-v1-2' : '' ]">
                        <label for="amount" class="d-block g-color-gray-dark-v2 g-font-size-13">Gebühren</label>
                        <div class="input-group g-brd-primary--focus">
                            <div class="input-group-addon d-flex align-items-center g-bg-white g-color-gray-light-v1 rounded-0">
                                {{ form.currency }}
                            </div>
                            <cleave id="amount"
                                    v-model="form.fees"
                                    class="form-control u-form-control g-placeholder-gray-light-v1 rounded-0 g-py-15"
                                    :options="cleaveAmount"
                                    placeholder="Betrag"
                                    :class="['form-control', { 'error': form.errors.has('fees') }]"
                                    @input="form.errors.clear('fees')">
                            </cleave>
                            <small v-if="form.errors.has('fees')" class="form-control-feedback">
                                {{ form.errors.get('fees') }}
                            </small>
                        </div>
                    </div>

                </div>

                <!-- Right Column -->
                <div class="col-md-6">

                    <!-- Available Cash -->
                    <div class="row justify-content-end">
                        <div class="col-md-10">
                            <div class="g-bg-brown-opacity-0_1 g-mt-20 g-pa-10">
                                <div>Cash ({{ portfolio.currency }})</div>
                                <div class="d-flex g-font-size-30 justify-content-end g-pr-20">{{ portfolio.cash }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Result -->
                    <div class="row justify-content-end">
                        <div class="col-md-10">
                            <div class="g-bg-brown-opacity-0_1 g-mt-20 g-pa-10">
                                <div>Total ({{ portfolio.currency }})</div>
                                <div class="d-flex g-font-size-30 justify-content-end g-pr-20">{{ total }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Risk Result -->
                    <div class="row justify-content-end">
                        <div class="col-md-10">
                            <div class="g-bg-brown-opacity-0_1 g-mt-20 g-pa-10">
                                <div>Risiko ({{ portfolio.currency }})</div>
                                <div class="d-flex g-font-size-30 justify-content-end g-pr-20">1200,40 €</div>
                            </div>
                        </div>
                    </div>

                    <!-- Hint -->
                    <div class="row justify-content-end g-mt-20">
                        <div class="col-md-10">
                            <p>Das Risiko für dein Gesamtportfolio kann niedriger ausfallen und ist
                                abhängig von der Zusammensetzung deines Portfolios</p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Submit Button -->
            <div class="d-flex justify-content-end py-3">

                <div class="g-mr-10" style="position: relative;">
                    <!-- Button -->
                    <button v-if="form.transaction === 'sell'" class="btn btn-md u-btn-outline-blue"
                            :disabled="hasError">Verkaufen
                    </button>
                    <button v-else class="btn btn-md u-btn-blue"
                            :disabled="hasError">Kaufen
                    </button>

                    <!-- Spinner -->
                    <div v-if="submitting" class="spinner-gritcode g-bg-black-opacity-0_4">
                        <vue-simple-spinner class="spinner-wrapper" message="" size="small"></vue-simple-spinner>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>


<script>

    import Datepicker from 'vuejs-datepicker';
    import numeral from 'numeral';

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
            prices: {
                type: Array,
                required: true
            },
            store: {
                type: String,
                required: true
            },
            redirect: {
                type: String,
                required: true
            }
        },

        data() {
            return {

                form: new Form({
                    portfolioId: this.portfolio.id,
                    instrumentId: this.instrument.id,
                    instrumentType: this.instrument.type,
                    currency: this.instrument.currency,
                    transaction: "buy",
                    exchange: null,
                    price: null,
                    amount: null,
                    executed: null,
                    fees: null
                }),

                stock: {
                    item: this.instrument,
                    prices: this.prices
                },

                exchange: 0,

                submitting: false,
                success: false,

                hasFormError: false,
                showSpinner: false,
                message: null,

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
                this.submitting = true;
                this.form.amount *= (this.form.transaction === 'sell') ? -1 : 1;
                if (this.form.fees === null) {
                    this.form.fees = 0;
                }

                this.form.doReset = false;
                this.form.exchange = this.exchange;

                this.form.post(this.store)
                    .then(data => {
                        this.success = true;
                        this.submitting = false;
                    })
                    .catch(error => {
                        this.success = false;
                        this.submitting = false;
                    });
            },

            onRedirect() {
                window.location = this.redirect;
            },

            onTransaction() {
                this.form.amount = 0;
                this.form.fees = 0;
                this.updatePrice();
                this.success = false;
            },


            updateExchange(index) {
                this.form.executed = _.first(Object.keys(this.stock.prices[index].data));
            },

            updatePrice() {
                this.form.price = this.stock.prices[this.exchange].data[this.form.executed];

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
            netTotal() {
                let price = this.asNumeric(this.form.price);
                let amount = this.asNumeric(this.form.amount);
                return numeral(price * amount).format('0,0.00');
            },

            total() {
                let price = this.asNumeric(this.form.price);
                let amount = this.asNumeric(this.form.amount);
                let fees = this.asNumeric(this.form.fees);
                return numeral((price * amount) + fees).format('0,0.00');
            },

            exceedCash() {
                return (this.asNumeric(this.portfolio.cash) < this.total);
            },


            hasError() {
                return (this.hasFormError || !this.form.amount);
            },

            firstPrice() {
                return _.last(Object.keys(this.stock.prices[this.exchange].data));
            },

            lastPrice() {
                return _.first(Object.keys(this.stock.prices[this.exchange].data));
            },

            overlap() {

            }
        },


        mounted() {
            this.$refs.datepicker.$on('opened', () => {
                this.form.errors.clear('executed');
                this.updatePrice();
            });

            this.updateExchange(this.exchange);
            this.form.executed = this.lastPrice;
            this.updatePrice();
        }
    }
</script>
