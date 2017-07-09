<template>
    <div v-if="showDialog">
        <div class="modal-backdrop fade in" @click="hide"></div>
        <div id="trade-dialog" class="modal show" role="dialog" aria-labelledby="trade-dialog">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                        @click="hide">&times;</button>
                        <h3 class="modal-title">Wertpapier kaufen</h3>
                    </div> <!-- /.modal-header -->

                    <div class="modal-body">
                        <div class="form-title">
                            <h5>{{ store.item.name }}</h5>
                            <h6> ISIN {{ store.item.isin }} / WKN {{ store.item.wkn }}</h6>
                        </div>

                        <form @submit.prevent="onSubmit">
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
                                                    :class="['form-control', { 'error': form.errors.has('amount') }]"
                                                    @input="form.errors.clear('amount')"></cleave>
                                        </div>
                                        <p v-if="form.errors.has('amount')" class="error-text">
                                            <span v-text="form.errors.get('amount')"></span>
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
                                            <span class="input-group-addon">{{ store.item.currency }}</span>
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
                                            <span class="input-group-addon">{{ store.item.currency }}</span>
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
                                        <button class="btn btn-primary" :disabled="hasError">Hinzufügen</button>
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
    import Input from '../mixins/Input.js';


    export default {

        props: ['route', 'lookup'],

        mixins: [Input],

        data() {
            return {
                form: new Form({
                    price: null,
                    amount: null,
                    id: null,
                    direction: null
                }),

                total: '',

                store: {
                    item: [],
                    price: []
                },

                hasFormError: false,

                cleavePrice: {
                    numeral: true,
                    numeralDecimalMark: ',',
                    delimiter: '.'
                },
                cleaveAmount: {
                    numeral: true,
                    numeralDecimalMark: ',',
                    delimiter: '.'
                },

                showDialog: false
            }
        },

        methods: {

            onSubmit() {
                let route = this.route.replace('%s', this.form.id);
                console.log(route);
                this.form.put(route)
                    .then(data => {
                        window.location = data.redirect;
                    });

            },

            updateTotal() {
                let total = this.form.price * this.form.amount;
                this.total = (isNaN(total)) ? (0).toFixed(2) : total.toFixed(2)
            },

            originalPrice() {
                return Object.values(this.store.price)[0].toFixed(2);
            },

            hide() {
                this.form.reset();
                this.showDialog = false;
                this.form.price = null; // why is price not reset with form?
            },

            show(id, direction) {
                this.form.direction = direction;
                this.form.id = id;

                this.fetch();
                this.showDialog = true;
            },

            fetch() {
                let lookupForm = new Form({ id: this.form.id });
                lookupForm.post(this.lookup)
                    .then(data => this.setData(data))
            },

            setData(data) {
                this.store.item = data.item;
                this.store.price = data.price;

                this.form.price = this.originalPrice();

                this.cash = data.cash;

                if (this.form.direction === 'sell') {
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

            classTotal() {
                return ['form-control', this.exceedCash ? 'error' : ''];
            },

            hasError() {
                return (this.hasFormError || this.exceedCash);
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