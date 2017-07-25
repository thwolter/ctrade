<template>
    <form @submit.prevent="onSubmit">

        <!-- Spinner -->
        <div v-if="showSpinner">
            <spinner class="spinner-overlay"></spinner>
        </div>

        <!-- Form -->
        <div class="row">
            <div class="col-md-6">

                <!-- exchange -->
                <div class="form-group">
                    <label for="query" class="control-label">Handelsplatz</label>
                    <div>
                        <select name="exchange" v-model="exchange" class="form-control">
                            <option v-for="(price, key) in stock.prices" :value="key">
                                {{ price.exchange }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">

                <!-- amount -->
                <div class="form-group">
                    <label for="query" class="control-label">Anzahl</label>
                    <div>
                        <cleave v-model="amount" :options="cleaveAmount" placeholder="Anzahl"
                                :class="['form-control', { 'error': form.errors.has('amount') }]"
                                @input="form.errors.clear('amount')"></cleave>
                    </div>
                    <p  v-if="form.errors.has('amount')" class="error-text">
                        <span v-text="form.errors.get('amount')"></span>
                    </p>
                </div>
            </div>
        </div> <!-- /.row -->

        <div class="row">
            <div class="col-md-6">

                <!-- price -->
                <div class="form-group">
                    <label for="query" class="control-label">Preis</label>
                    <div class="input-group">
                        <span class="input-group-addon">{{ form.currency }}</span>
                        <cleave v-model="price" :options="cleavePrice" class="form-control" ></cleave>
                    </div>
                </div>
            </div>
            <div class="col-md-6">

                <!-- total -->
                <div class="form-group">
                    <label for="query" class="control-label">Gesamt</label>
                    <div class="input-group">
                        <span class="input-group-addon">{{ form.currency }}</span>
                        <cleave v-model="total" :options="cleavePrice" :class="clsTotal"
                            readonly></cleave>
                    </div>
                </div>
            </div>
        </div><!-- /.row -->

        <div v-if="exceedCash">
            <p  class="error-text">
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

        props: ['pid', 'id', 'store', 'cash'],

        data() {
            return {
                lookup: '/api/lookup',

                form: new Form({
                    exchange: 'Stuttgart',
                    price: null,
                    amount: null,
                    currency: null,
                    id: null,
                    type: null,
                    pid: null
                }),

                stock: [],
                exchange: 0,
                price: '',
                amount: '',
                total: '',

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
                    });

            },

            onCancel() {
                Event.fire('backToSearch');
            },

            fetch() {
                axios.get(this.lookup, {
                    params: {
                        id: this.id
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

                this.form.exchange = price.exchange;
                this.form.type = this.stock.item.type;
                this.form.price = Object.values(price.price)[0];

                this.price = this.form.price.toFixed(2);
            },

            updateTotal() {
                this.total = (this.form.price * this.form.amount).toFixed(2);
                if (this.total === '') { this.total = '0'; }
            }
        },

        watch: {
            exchange: function(index) {
                this.updateExchange(index);
            },

            price: function(value) {
                if (value !== '') {
                    this.form.price = parseFloat(value);
                    this.updateTotal();
                } else {
                    this.updateExchange(this.exchange);
                }
            },

            amount: function(value) {
                this.form.amount = parseFloat(value);
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
