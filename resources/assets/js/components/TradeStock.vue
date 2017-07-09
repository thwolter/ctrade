<template>
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">Wertpapier kaufen</h3>
            </div> <!-- /.modal-header -->

            <div class="modal-body">
                <form @submit.prevent="onSubmit">
                    <div class="row">
                        <div class="col-md-6">

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
                        <div class="col-md-6">

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
                        <div class="col-md-6">

                            <!-- price -->
                            <div class="form-group">
                                <label for="price" class="control-label">Preis</label>
                                <div class="input-group">
                                    <span class="input-group-addon">{{ store.item.currency }}</span>
                                    <cleave v-model="form.price" :options="cleavePrice" class="form-control"></cleave>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">

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
                                <button type="reset" class="btn btn-default">Abbrechen</button>
                                <button class="btn btn-primary" :disabled="hasError">Hinzufügen</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import Input from '../mixins/Input.js';


    export default {

        props: ['id', 'amount', 'route', 'cash', 'item', 'direction', 'price'],

        mixins: [Input],

        data() {
            return {
                form: new Form({
                    price: 0,
                    amount: 0,
                    id: null,
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
                }
            }
        },

        methods: {

            onSubmit() {
                this.form.post(this.route)
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

        created() {
            this.store.item = JSON.parse(this.item);
            this.store.price = JSON.parse(this.price);
            this.form.id = this.id;
        },

        mounted() {
            this.form.price = this.originalPrice();
        }
    }
</script>