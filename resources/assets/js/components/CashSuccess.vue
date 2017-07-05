<template>
    <div v-if="show">
        <div class="modal-backdrop fade in" @click="hide"></div>
        <div id="confirm" class="modal show" role="dialog" aria-labelledby="confirm">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" @click="hide">
                            &times;
                        </button>
                        <h3 class="modal-title">{{ title }}</h3>
                    </div> <!-- /.modal-header -->

                    <div class="modal-body">
                        <span class="lead">{{ body }}</span>
                    </div> <!-- /.modal-body -->

                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" @click="hide">Weiter</button>
                    </div> <!-- /.modal-footer -->
                </div> <!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
</template>

<script>
    import Input from '../mixins/Input.js';
    export default {

        mixins: [ Input ],

        props: [
            'route',
            'decimal',
            'currency'
        ],

        data() {
            return {
                show: false,
                form: new Form(),
                text: '',
                body: '',
                textDeposit: {
                    title: 'Einzahlung erfolgreich',
                    body: 'Auf dein Konto wurden %s eingezahlt.'
                },
                textWithdrawal: {
                    title: 'Auszahlung erfolgreich',
                    body: 'Von deinem Konto wurden %s ausgezahlt.'
                }
            }
        },

        created() {
            var vm = this;

            Event.listen('deposit-success', function (amount) {
                console.log('deposit confirmed with amount ' + amount);
                vm.setText('deposit', amount);
                vm.showModal();
            });

            Event.listen('withdraw-success', function (amount) {
                console.log('withdrawal confirmed with amount ' + amount);
                vm.setText('withdraw', amount);
                vm.showModal();
            });
        },

        methods: {
            showModal() {
                this.show = true;
            },

            hide() {
                this.show = false;
                location.reload(true);
            },

            setText(direction, amount) {
                let amountString = this.formatMoney(amount, this.currency, this.decimal);

                if (direction === 'deposit') {
                    this.title = this.textDeposit.title;
                    this.body = this.textDeposit.body.replace('%s', amountString);
                }
                else {
                    this.title = this.textWithdrawal.title;
                    this.body = this.textWithdrawal.body.replace('%s', amountString);
                }
            }
        }
    }
</script>