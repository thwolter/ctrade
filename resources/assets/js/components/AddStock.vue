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
                        <cleave v-model="amount" :options="cleave" class="form-control"></cleave>
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
                        <cleave v-model="price" :options="cleave" class="form-control" ></cleave>
                    </div>
                </div>
            </div>
            <div class="col-md-6">

                <!-- total -->
                <div class="form-group">
                    <label for="query" class="control-label">Gesamt</label>
                    <div class="input-group">
                        <span class="input-group-addon">{{ form.currency }}</span>
                        <input type="text" class="form-control">
                    </div>
                </div>
            </div>
        </div><!-- /.row -->
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

                cleave: {
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

            }
        },

        watch: {
            exchange: function(index) {
                this.updateExchange(index);
            },

            price: (value) => {
                this.form.price = this.formatToNumber(this.price, this.cleave.numeralDecimalMark);
                this.updateTotal();
            },

            amount: (value) => {
                this.form.amount = this.formatToNumber(this.amount, this.cleave.numeralDecimalMark);
                this.updateTotal();
            },

        },

        created() {
            this.fetch()
        }
    }
</script>