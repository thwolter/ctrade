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
                <label for="price" class="control-label">Preis</label>
                <div class="input-group">
                    <span class="input-group-addon">{{ form.currency }}</span>
                    <cleave v-model="price" :options="cleavePrice" class="form-control"></cleave>
                </div>
            </div>

            <!-- amount -->
            <div class="form-group col-sm-4 col-md-3">
                <label for="amount" class="control-label">Anzahl</label>
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
                <label for="executed" class="control-label">Datum</label>
                <div>
                    <input v-model="executed" type="date" name="date"
                           :class="['form-control', { 'error': form.errors.has('executed') }]"
                           @keydown="form.errors.clear('executed')">
                </div>
                <p v-if="form.errors.has('executed')" class="error-text">
                    <span v-text="form.errors.get('executed')"></span>
                </p>
            </div>

            <!-- fees -->
            <div class="form-group col-sm-4 col-md-3">
                <label for="fees" class="control-label">Gebühren</label>
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
                <button class="btn btn-default" type="reset" @click="onReset">Reset</button>
                <button v-if="transaction === 'sell'" class="btn btn-warning" :disabled="hasError">Verkaufen</button>
                <button v-else class="btn btn-primary" :disabled="hasError">Kaufen</button>
            </div>
        </div>

    </form>
</template>

<script>

    export default {

        props: [
            'portfolioId',
            'instrumentType',
            'instrumentId',
            'storeRoute',
            'cash',
            'amount',
            'transaction'
        ],

        data() {
            return {
                lookup: '/api/lookup',

                form: new Form({
                    portfolioId: null,
                    transaction: this.transaction,
                    instrumentId: null,
                    instrumentType: this.instrumentType,
                    price: null,
                    amount: null,
                    executed: (new Date()).toISOString().split('T')[0],
                    fees: 0,
                    currency: null,
                }),

                stock: [],
                exchange: 0,
                price: '',
                total: '',
                executed: (new Date()).toISOString().split('T')[0],

                hasFormError: false,
                showSpinner: true,

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

            onReset() {
                this.initiateForm();
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
                        this.showSpinner = false;
                    })
            },

            initiateForm() {
                this.form.currency = this.stock.item.currency;
                this.form.instrumentType = this.stock.item.type;
                this.updateExchange(this.exchange);
                this.updatePrice();
            },

            updateExchange(index) {
                let price = this.stock.prices[index];
                this.executed = _.first(Object.keys(price.history));
            },

            updateTotal() {
                this.total = (this.form.price * this.form.amount + this.asNumeric(this.form.fees)).toFixed(2);
                if (this.total === '') {
                    this.total = '0';
                }
            },

            updatePrice() {
                let history = this.stock.prices[this.exchange].history;
                this.price = history[this.executed];
                this.form.price = this.price;
            },

            asNumeric(value) {
                let number = parseFloat(value);
                return (isNaN(number) || !value) ? 0 : number;
            }
        },

        watch: {
            exchange: function (index) {
                this.updateExchange(index);
            },

            price: function (value) {
                if (value !== '') {
                    this.form.price = this.asNumeric(value);
                    this.updateTotal();
                } else {
                    this.updateExchange(this.exchange);
                }
            },

            executed: function (value) {
                this.form.executed = value;
                this.updatePrice();
            },

            form: {
                deep: true,
                handler() {
                    this.hasFormError = this.form.errors.any();
                    this.updateTotal();
                }
            }
        },

        computed: {
            exceedCash() {
                return (this.asNumeric(this.cash) < this.total);
            },

            clsTotal() {
                if (this.exceedCash) {
                    return 'form-control error';
                } else {
                    return 'form-control';
                }
            },

            hasError() {
                return (this.hasFormError || this.exceedCash);
            }
        },

        mounted() {
            this.fetch();
            //this.form.instrumentId = this.instrumentId;
            //this.form.portfolioId = this.portfolioId;
        }
    }
</script>
