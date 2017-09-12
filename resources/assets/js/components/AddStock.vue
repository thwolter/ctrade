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
                    <cleave v-model="amount" :options="cleaveAmount" placeholder="Anzahl"
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
                    <cleave v-model="fees" :options="cleaveAmount" placeholder="Gebühren"
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
                <button class="btn btn-default" type="reset" @click="onCancel">Zurück</button>
                <button class="btn btn-primary" :disabled="hasError">Hinzufügen</button>
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
            'cash'
        ],

        data() {
            return {
                lookup: '/api/lookup',

                form: new Form({
                    portfolioId: null,
                    transaction: 'buy',
                    instrumentId: null,
                    instrumentType: this.instrumentType,
                    price: null,
                    amount: null,
                    executed: null,
                    fees: null,
                    currency: null,
                }),

                stock: [],
                exchange: 0,
                price: '',
                amount: '',
                total: '',
                fees: '',
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
                this.form.post(this.storeRoute)
                    .then(data => {
                        window.location = data.redirect;
                    })
                    .catch(error => {
                        this.showSpinner = false;
                    });
            },

            onCancel() {
                Event.fire('backToSearch');
            },

            fetch() {
                axios.get(this.lookup, {
                    params: {
                        instrumentId: this.instrumentId,
                        instrumentType: this.instrumentType
                    }
                })
                    .then(data => {
                        this.add(data.data);
                        this.showSpinner = false;
                    })
            },

            add(data) {
                this.stock = data;
                this.form.currency = this.stock.item.currency;
                this.form.instrumentType = this.stock.item.type;

                this.updateExchange(this.exchange);
            },

            updateExchange(index) {
                let price = this.stock.prices[index];
                this.executed = _.first(Object.keys(price.history));
            },

            updateTotal() {
                this.total = (this.form.price * this.form.amount + this.form.fees).toFixed(2);
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
                return isNaN(number) ? 0 : number;
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

            amount: function (value) {
                this.form.amount = this.asNumeric(value);
                this.updateTotal();
            },

            executed: function (value) {
                this.form.executed = value;
                this.updatePrice();
            },

            fees: function (value) {
                this.form.fees = this.asNumeric(value);
                this.updateTotal();
            },

            form: {
                deep: true,
                handler() {
                    this.hasFormError = this.form.errors.any();
                }
            }
        },

        computed: {
            exceedCash() {
                return (this.asNumeric(this.cash) < this.total)
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
            this.form.instrumentId = this.instrumentId;
            this.form.portfolioId = this.portfolioId;
        }
    }
</script>
