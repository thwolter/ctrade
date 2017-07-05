<template>
    <div>
        <h4 class="title">{{ title }}</h4>

        <form @submit.prevent="onSubmit">
            <div class="form-group">
                <label for="amount" class="control-label col-xs-2 cursor-pointer"></label>
                <div class="col-xs-7">
                    <div class="input-group">
                        <span class="input-group-addon">EUR</span>
                        <input type="text" id="value" name="value" :class="classObject" v-model="form.value"
                               placeholder="Betrag">
                    </div>
                    <p class="error-text">
                        <span v-if="error">Ungültiger Wert.</span>
                        <span v-if="form.errors.has('amount')" v-text="form.errors.get('amount')"></span>
                    </p>
                    <input :amount="form.amount" type="hidden" name="cash" id="cash">

                </div>
                <div class="col-xs-2">
                    <button :class="btn.cls">{{ btn.title }}</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import {required, between} from 'vuelidate/lib/validators';
    import Input from '../mixins/Input.js';

    export default {

        mixins: [ Input ],

        props: {
            route: String,
            deposit: Boolean
        },

        data() {
            return {
                form: new Form({
                    value: '',
                    amount: null
                }),
                title: null,
                btn: {
                    cls: null,
                    title: null
                },
                decimal: ','
            }
        },

        validations: {
            form: {
                amount: {
                    between: between(0, Infinity)
                }
            }
        },

        methods: {
            onSubmit() {
                this.form.post(this.route)
                    .then(Event.fire(this.eventName, this.form.amount));
            }
        },

        computed: {
            classObject() {
                if (this.error) {
                    return 'form-control error'
                } else {
                    return 'form-control'
                }
            },

            error() {
                let match = this.floatMatchesString(this.form.amount, this.form.value);
                return (this.form.amount !== null && (this.$v.form.amount.$invalid || !match))
            },

            eventName() {
                return (this.deposit) ? 'deposit-success' : 'withdraw-success';
            }
        },

        watch: {
            form: {
                handler() {
                    if (this.form.value === '') {
                        this.form.amount = null;
                    } else {
                        this.form.amount = this.formatToNumber(this.form.value, this.decimal)
                    }
                },
                deep: true
            }
        },

        created()
        {
            if (this.deposit) {
                this.title = 'Cash einzahlen';
                this.btn.title = 'Einzahlen';
                this.btn.cls = 'btn btn-secondary';
            } else {
                this.title = 'Cash auszahlen';
                this.btn.title = 'Auszahlen';
                this.btn.cls = 'btn btn-primary'
            }
        }
    }
</script>
