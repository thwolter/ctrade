<template>
    <form @submit.prevent="onSubmis">
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
                        <cleave v-model="amount" :options="cleaveAmount" class="form-control"
                            placeholder="Anzahl"></cleave>
                    </div>
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
                        <cleave v-model="total" :options="cleavePrice" class="form-control"
                            readonly></cleave>
                    </div>
                </div>
            </div>
        </div><!-- /.row -->

        <div class="row">
            <div class="col-md-12">
                <div class="pull-right">
                    <button type="reset" class="btn btn-default">Abbrechen</button>
                    <button class="btn btn-primary">Hinzufügen</button>
                </div>
            </div>
        </div>

    </form>
</template>

<script>
    import Input from '../mixins/Input.js';


    export default {

        props: ['id', 'lookup'],

        mixins: [Input],

        data() {
            return {
                form: new Form({
                    exchange: 'Stuttgart',
                    price: null,
                    amount: null,
                    currency: null
                }),
                stock: [],
                exchange: 0,
                price: '',
                amount: '',
                total: '',

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
            },

            fetch() {
                let lookupForm = new Form({id: this.id});
                lookupForm.post(this.lookup)
                    .then(data => this.add(data))
            },

            add(data) {
                this.stock = data;
                this.form.currency = this.stock.item.currency;

                this.updateExchange(this.exchange);
            },

            updateExchange(index) {
                let price = this.stock.prices[index];

                this.form.exchange = price.exchange;
                this.form.price = Object.values(price.price)[0];

                this.price = this.formatMoney(this.form.price);
            },

            updateTotal() {
                this.total = this.formatMoney(this.form.price * this.form.amount);
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
            }

        },

        created() {
            this.fetch()
        }
    }
</script>