<template>
    <div v-if="showDialog">
        <div class="modal-backdrop fade in" @click="hide"></div>
        <div id="cash-dialog" class="modal show" role="dialog" aria-labelledby="trade-dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                        
                    <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                @click="hide">&times;</button>
        
                                <h3 v-if="deposit" class="modal-title">Cash einzahlen</h3>
                                <h3 v-if="withdraw" class="modal-title">Cash auszahlen</h3>
                            </div> <!-- /.modal-header -->
        
                            
                    <div class="modal-body">
                        <form @submit.prevent="onSubmit">
                             <div class="row">
                                <div class="col-sm-6">
                                    
                                    <div class="form-group">
                                        <label for="amount" class="control-label col-xs-2 cursor-pointer"></label>
                                        
                                        <div class="col-xs-7">
                                            
                                            <div class="input-group">
                                                <span class="input-group-addon">EUR</span>
                                                <cleave name="value" :class="classObject" v-model="form.value"
                                                    placeholder="Betrag" :options="cleave" @rawValueChanged="form.errors.clear('amount')"></cleave>
                                            </div>
                                            
                                            <p class="error-text">
                                                <span v-if="form.errors.has('amount')" v-text="form.errors.get('amount')"></span>
                                            </p>
                                
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        
                    </div> <!-- /.modal-body -->
                        
                    <div class="modal-footer">
                        <div class="pull-right">
                            <button type="reset" class="btn btn-default" @click="hide">Abbrechen</button>
                            <button type="submit" v-if="deposit" class="btn btn-success" :disabled="hasError">Einzahlen</button>
                            <button type="submit" v-if="withdraw" class="btn btn-primary" :disabled="hasError">Auszahlen</button>
                        </div>
                    </div> <!-- /.modal-footer -->
                                    
                </div> <!-- /.modal-content -->
            </div> <!-- /.modal-dialog -->
        </div> <!--/#cash-dialog -->
    </div>
</template>

<script>
    import Input from '../mixins/Input.js';
    import Cleave from 'vue-cleave';

    export default {

        mixins: [Input],

        components: {
            Cleave
        },

        props: ['route', 'id'],
        
        data() {
            return {
                form: new Form({
                    value: '',
                    amount: null,
                    transaction: null,
                    id: null
                }),
                
             
                cleave: {
                    numeral: true,
                    numeralDecimalMark: ',',
                    delimiter: '.'
                },
                
                showDialog: false
            }
        },


        methods: {
            onSubmit() {
                console.log('hi');
                this.form.post(this.route)
                    .then(data => Event.fire('cashSuccess', data))
            },
            
             show(id, transaction) {
                this.form.transaction = transaction;
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

            hasError()
            {
                return (this.form.errors.any())
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
                handler()
                {
                    if (this.form.value === '') {
                        this.form.amount = null;
                    } else {
                        this.form.amount = this.formatToNumber(this.form.value, this.decimal)
                    }
                },
                deep: true
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
