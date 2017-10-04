<template>
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 v-if="deposit" class="modal-title">Cash einzahlen</h3>
                <h3 v-if="withdraw" class="modal-title">Cash auszahlen</h3>
            </div>

            <form @submit.prevent="onSubmit">

                <div class="modal-body">
                    <div class="row">

                        <!-- date -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="date" class="col-form-label">Datum</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <datepicker
                                            v-model="form.date"
                                            name="date"
                                            input-class="form-control"
                                            language="de"
                                            :disabled="disabled"
                                            :full-month-name="true"
                                            :monday-first="true"
                                            ref="datepicker">
                                    </datepicker>
                                </div>
                                <p v-if="form.errors.has('date')" class="error-text">
                                    <span v-text="form.errors.get('date')"></span>
                                </p>

                            </div>
                        </div><!-- /date -->

                        <!-- amount -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="amount" class="control-label cursor-pointer">Betrag</label>
                                <div>
                                    <div class="input-group">
                                        <span class="input-group-addon">EUR</span>
                                        <cleave v-model="form.amount" placeholder="Betrag"
                                                :options="cleave"
                                                :class="['form-control', { 'error': form.errors.has('date') }]"
                                                @input="form.errors.clear('amount')"></cleave>
                                    </div>

                                    <p v-if="form.errors.has('amount')" class="error-text">
                                        <span v-text="form.errors.get('amount')"></span>
                                    </p>
                                    <p v-if="exceedCash" class="error-text">
                                        Betrag übersteigt verfügbaren Barbestand.
                                    </p>

                                </div>
                            </div>
                        </div> <!-- /amount -->

                    </div>
                </div>

                <div class="modal-footer">
                    <div class="pull-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">Abbrechen</button>
                        <button type="submit" v-if="deposit" class="btn btn-success" :disabled="hasError">
                            Einzahlen
                        </button>
                        <button type="submit" v-if="withdraw" class="btn btn-primary" :disabled="hasError">
                            Auszahlen
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>

</template>

<script>
    import Input from '../../mixins/Input.js';
    import Datepicker from 'vuejs-datepicker';

    export default {

        mixins: [Input],

        props: [
            'route',
            'id',
            'cash',
            'transaction'
        ],

        components: {
            Datepicker
        },

        data() {
            return {
                form: new Form({
                    amount: null,
                    transaction: this.transaction,
                    date: (new Date()).toISOString().split('T')[0],
                    id: null
                }),


                cleave: {
                    numeral: true,
                    numeralDecimalMark: ',',
                    delimiter: '.',
                    numeralPositiveOnly: true
                },

                hasFormError: false,
                disabled: {}
            }
        },


        methods: {
            onSubmit() {
                this.form.post(this.route)
                    .then(data => {
                        this.hide();
                        window.location = data.redirect;
                    })
            },

            initEventListeners(vm) {
                if (this.transaction === 'deposit' || this.transaction === 'withdraw') {
                    vm.show(this.id, this.transaction);

                } else {
                    Event.listen('depositCash', function (id) {
                        vm.show(id, 'deposit');
                    });

                    Event.listen('withdrawCash', function (id) {
                        console.log('ok, withdraw');
                        vm.show(id, 'withdraw');
                    });
                }
            },

            initDatapickerEvents() {
                this.$refs.datepicker.$on('opened', () => {
                    this.form.errors.clear('executed');
                    this.updatePrice();
                });
            },

            show(id, transaction) {
                this.form.transaction = transaction;
                this.form.id = id ? id : this.id;
            },

            hide() {
                this.form.reset();
            },
        },

        computed: {
            classObject() {
                return this.error ? 'form-control error' : 'form-control';
            },


            hasError() {
                return (this.hasFormError || (this.exceedCash && this.withdraw));
            },

            exceedCash() {
                return ((parseFloat(this.cash) < this.form.amount) && this.withdraw)
            },

            deposit() {
                return (this.form.transaction === 'deposit');
            },

            withdraw() {
                return (this.form.transaction === 'withdraw');
            }
        },

        watch: {
            form: {
                deep: true,
                handler() {
                    this.hasFormError = this.form.errors.any();
                }
            }
        },

        mounted() {
            this.initEventListeners(this);
            this.initDatapickerEvents();
        }
    }
</script>
