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
                <label for="query" class="control-label">Handelsplatz</label>
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
                <label for="query" class="control-label">Preis</label>
                <div class="input-group">
                    <span class="input-group-addon">{{ form.currency }}</span>
                    <cleave v-model="price" :options="cleavePrice" class="form-control"></cleave>
                </div>
            </div>

            <!-- amount -->
            <div class="form-group col-sm-4 col-md-3">
                <label for="query" class="control-label">Anzahl</label>
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
                <label for="query" class="control-label">Datum</label>
                <div>
                   <input v-model="date" type="date" name="date"
                          :class="['form-control', { 'error': form.errors.has('date') }]">
                </div>
                <p v-if="form.errors.has('date')" class="error-text">
                    <span v-text="form.errors.get('date')"></span>
                </p>
            </div>

            <!-- fees -->
            <div class="form-group col-sm-4 col-md-3">
                <label for="query" class="control-label">Gebühren</label>
                <div class="input-group">
                    <span class="input-group-addon">{{ form.currency }}</span>
                    <cleave v-model="fees" :options="cleaveAmount" placeholder="Betrag"
                            :class="['form-control', { 'error': form.errors.has('fees') }]"
                            @input="form.errors.clear('fees')"></cleave>
                </div>
                <p v-if="form.errors.has('fees')" class="error-text">
                    <span v-text="form.errors.get('fees')"></span>
                </p>
            </div>

            <!-- total -->
            <div class="form-group col-sm-4 col-md-3">
                <label for="query" class="control-label">Gesamt</label>
                <div class="input-group">
                    <span class="input-group-addon">{{ form.currency }}</span>
                    <cleave v-model="total" :options="cleavePrice" :class="clsTotal"
                            readonly></cleave>
                </div>
            </div>

        </div><!-- /.row -->

        <div v-if="exceedCash">
            <p class="error-text">
                Betrag übersteigt verfügbaren Barbestand.
            </p>
        </div>

        <div class="modal-footer">
            <div>
                <div class="pull-right">
                    <button class="btn btn-default" type="reset" @click="onCancel">Zurück</button>
                    <button class="btn btn-primary" :disabled="hasError">Hinzufügen</button>
                </div>
            </div>
        </div>

    </form>
</template>

<script>

    export default {

        props: ['pid', 'id', 'store', 'cash', 'entity'],

        data() {
            return {
                lookup: '/api/lookup',

                form: new Form({
                    exchange: null,
                    datasourceId: null,
                    price: null,
                    amount: null,
                    date: null,
                    fees: null,
                    currency: null,
                    id: null,
                    type: null,
                    pid: null,
                    entity: this.entity
                }),

                stock: [],
                exchange: 0,
                price: '',
                amount: '',
                total: '',
                fees: '',
                date: (new Date()).toISOString().split('T')[0],

                hasFormError: false,
                showSpinner: true,

                cleavePrice: {
                    numeral: true,
                    numeralDecimalMark: ',',
                    delimiter: '.'
                },

                cleaveAmount: {
                    numeral: true,
                    numeralDecimalMark: ',',
                    delimiter: '.'
                }
            }
        },

        methods: {

            onSubmit() {
                this.showSpinner = true;
                this.form.post(this.store)
                    .then(data => {
                        window.location = data.redirect;
                    })
            },

            onCancel() {
                Event.fire('backToSearch');
            },

            fetch() {
                axios.get(this.lookup, {
                    params: {
                        id: this.id,
                        entity: this.entity
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

                this.updateExchange(this.exchange);
            },

            updateExchange(index) {
                let price = this.stock.prices[index];

                this.date = _.first(Object.keys(price.history));

                this.form.exchange = price.exchange;
                this.form.datasourceId = price.datasourceId;
                this.form.type = this.stock.item.type;
            },

            updateTotal() {
                this.total = (this.form.price * this.form.amount + this.form.fees).toFixed(2);
                if (this.total === '') {
                    this.total = '0';
                }
            },

            updatePrice() {
                let history = this.stock.prices[this.exchange].history;
                this.price = history[this.date];
                this.form.price = this.price;
            }
        },

        watch: {
            exchange: function (index) {
                this.updateExchange(index);
            },

            price: function (value) {
                if (value !== '') {
                    this.form.price = parseFloat(value);
                    this.updateTotal();
                } else {
                    this.updateExchange(this.exchange);
                }
            },

            amount: function (value) {
                this.form.amount = parseFloat(value);
                this.updateTotal();
            },

            date: function (value) {
                this.form.date = value;
                this.updatePrice();
            },

            fees: function (value) {
                this.form.fees = parseFloat(value);
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
                return (parseFloat(this.cash) < this.form.price * this.form.amount)
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
            this.form.id = this.id;
            this.form.pid = this.pid;
        }
    }
</script>
