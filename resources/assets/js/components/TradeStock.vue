<template>
    <div v-if="showDialog">
        <div class="modal-backdrop fade in" @click="hide"></div>
        <div id="trade-dialog" class="modal show" role="dialog" aria-labelledby="trade-dialog">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                        @click="hide">&times;</button>

                        <h3 v-if="buy" class="modal-title">Wertpapier kaufen</h3>
                        <h3 v-if="sell" class="modal-title">Wertpapier verkaufen</h3>
                    </div> <!-- /.modal-header -->

                    <div class="modal-body">
                        <div class="form-title">
                            <h5>{{ item.name }}</h5>
                            <h6> ISIN {{ item.isin }} / WKN {{ item.wkn }}</h6>
                        </div>

                        <form @submit.prevent="onSubmit">

                            <!-- Spinner -->
                            <div v-if="showSpinner">
                                <spinner class="spinner-overlay"></spinner>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">

                                    <!-- exchange -->
                                    <div class="form-group">
                                        <label for="exchange" class="control-label">Handelsplatz</label>
                                        <div>
                                            <select name="exchange" class="form-control">
                                                <option value="0">Stuttgart</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">

                                    <!-- amount -->
                                    <div class="form-group">
                                        <label for="amount" class="control-label">Anzahl</label>
                                        <div>
                                            <cleave v-model="form.amount" :options="cleaveAmount" placeholder="Anzahl"
                                                    :class="['form-control', { 'error': form.errors.has('amount') }, {'error': exceedInventory && sell}]"
                                                    @input="form.errors.clear('amount')"></cleave>
                                        </div>
                                        <p v-if="form.errors.has('amount')" class="error-text">
                                            <span v-text="form.errors.get('amount')"></span>
                                        </p>
                                        <p v-if="exceedInventory && sell" class="error-text">
                                            <span>Anzahl übersteigt verfügbaren Bestand.</span>
                                        </p>
                                    </div>
                                </div>
                            </div> <!-- /.row -->

                            <div class="row">
                                <div class="col-sm-6">

                                    <!-- price -->
                                    <div class="form-group">
                                        <label for="price" class="control-label">Preis</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">{{ item.currency }}</span>
                                            <cleave v-model="form.price" :options="cleavePrice"
                                                    class="form-control"></cleave>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">

                                    <!-- total -->
                                    <div class="form-group">
                                        <label for="total" class="control-label">Gesamt</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">{{ item.currency }}</span>
                                            <cleave v-model="total" :options="cleavePrice" :class="classTotal"
                                                    readonly></cleave>
                                        </div>
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
                                        <button type="reset" class="btn btn-default" @click="hide">Abbrechen</button>
                                        <button v-if="buy" class="btn btn-success" :disabled="hasError">Kaufen</button>
                                        <button v-if="sell" class="btn btn-primary" :disabled="hasError">Verkaufen</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        props: ['route', 'lookup'],

        data() {
            return {
                form: new Form({
                    price: null,
                    amount: null,
                    id: null,
                    transaction: null
                }),

                total: '',
                originalAmount: null,

                item: [],
                price: [],

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
                },

                showDialog: false
            }
        },

        methods: {

            onSubmit() {
                this.form.put(this.route)
                    .then(data => {
                        window.location = data.redirect;
                    })
                    .catch(data => {

                    });
            },

            updateTotal() {
                let total = this.form.price * this.form.amount;
                this.total = (isNaN(total)) ? (0).toFixed(2) : total.toFixed(2)
            },

            originalPrice() {
                return Object.keys(this.price).map(key => this.price[key])[0].toFixed(2);
            },

            hide() {
                this.form.reset();
                this.showDialog = false;
                this.form.price = null; // why is price not reset with form?
                this.showSpinner = true;
            },

            show(id, transaction) {
                this.form.transaction = transaction;
                this.form.id = id;

                this.fetch();
                this.showDialog = true;
            },

            fetch() {
                let lookupForm = new Form({ id: this.form.id });
                lookupForm.post(this.lookup)
                    .then(data => {
                        this.setData(data);
                        this.showSpinner = false;
                    })
            },

            setData(data) {

                this.item = data.item;
                this.price = data.price;
                this.form.price = this.originalPrice();

                this.cash = data.cash;

                this.originalAmount = data.amount;
                if (this.form.transaction === 'sell') {
                    this.form.amount = data.amount;
                }
            }
        },

        watch: {

            form: {
                deep: true,
                handler() {
                    this.hasFormError = this.form.errors.any();
                    if (this.form.price === '') {
                        this.form.price = this.originalPrice();
                    }
                    this.updateTotal();
                }
            }
        },

        computed: {
            exceedCash() {
                return (parseFloat(this.cash) < this.form.price * this.form.amount)
            },

            exceedInventory() {
                return (this.form.amount > this.originalAmount);
            },

            classTotal() {
                return ['form-control', this.exceedCash ? 'error' : ''];
            },

            hasError() {
                return (this.hasFormError || this.exceedCash ||
                    (this.exceedInventory && this.sell));
            },

            buy() {
                return (this.form.transaction === 'buy');
            },

            sell() {
                return (this.form.transaction === 'sell');
            }
        },

        mounted() {
            var vm = this;

            Event.listen('buyStock', function (id) {
                vm.show(id, 'buy');
            });

            Event.listen('sellStock', function (id) {
                vm.show(id, 'sell');
            });
        }
    }
</script>

<style scoped>
    .form-title {
        margin-bottom: 30px;
    }
</style>