<template>
    <div v-if="showDialog">
        <div class="modal-backdrop fade in" @click="hide"></div>
        <div id="cash-dialog" class="modal show" role="dialog" aria-labelledby="trade-dialog">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form @submit.prevent="onSubmit">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                    @click="hide">&times;
                            </button>

                            <h3 v-if="deposit" class="modal-title">Cash einzahlen</h3>
                            <h3 v-if="withdraw" class="modal-title">Cash auszahlen</h3>
                        </div> <!-- /.modal-header -->

                        <div class="modal-body">

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="amount" class="control-label cursor-pointer"></label>
                                        <div>
                                            <div class="input-group">
                                                <span class="input-group-addon">EUR</span>
                                                <cleave v-model="form.amount" :class="classObject"
                                                        placeholder="Betrag" :options="cleave"
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
                                </div>
                            </div>
                        </div> <!-- /.modal-body -->

                        <div class="modal-footer">
                            <div class="pull-right">
                                <button type="reset" class="btn btn-default" @click="hide">Abbrechen</button>
                                <button type="submit" v-if="deposit" class="btn btn-success" :disabled="hasError">
                                    Einzahlen
                                </button>
                                <button type="submit" v-if="withdraw" class="btn btn-primary" :disabled="hasError">
                                    Auszahlen
                                </button>
                            </div>
                        </div> <!-- /.modal-footer -->
                    </form>
                </div> <!-- /.modal-content -->
            </div> <!-- /.modal-dialog -->
        </div> <!--/#cash-dialog -->
    </div>
</template>

<script>
    import Input from '../mixins/Input.js';

    export default {

        mixins: [Input],

        props: ['route', 'id', 'cash'],

        data() {
            return {
                form: new Form({
                    amount: null,
                    transaction: null,
                    id: null
                }),


                cleave: {
                    numeral: true,
                    numeralDecimalMark: ',',
                    delimiter: '.',
                    numeralPositiveOnly: true
                },

                showDialog: false,

                hasFormError: false,
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

            show(id, transaction) {
                this.form.transaction = transaction;
                this.form.id = id;
                this.showDialog = true;
            },

            hide() {
                this.form.reset();
                this.showDialog = false;
            },
        },

        computed: {
            classObject()
            {
                if (this.error) {
                    return 'form-control error'
                } else {
                    return 'form-control'
                }
            },


            hasError() {
                return (this.hasFormError ||
                (this.exceedCash && this.withdraw));
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
                handler()
                {
                    this.hasFormError = this.form.errors.any();
                }
            }
        },

        mounted() {
            var vm = this;

            this.form.id = this.id;

            Event.listen('depositCash', function (id) {
                vm.show(id, 'deposit');
            });

            Event.listen('withdrawCash', function (id) {
                vm.show(id, 'withdraw');
            });
        }
    }
</script>
