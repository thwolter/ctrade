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

    export default {
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
                separator: '.'
            }
        },

        validations: {
            form: {
                amount: {
                    required,
                    between: between(0, Infinity)
                }
            }
        },

        methods: {
            onSubmit() {
                this.form.post(this.route)
                    .then(response => alert('Wahoo!'));
            },

            /**
             * Format provided value to number type.
             * @param {String} value
             * @return {Number}
             */
            formatToNumber (value) {
                let number = 0;
                if (this.separator === '.') {
                    number = Number(String(value).replace(/[^0-9-,]+/g, '').replace(',', '.'))
                } else {
                    number = Number(String(value).replace(/[^0-9-.]+/g, ''))
                }
                return number
            },

            /**
             * test if a string value corresponds the float Value
             *
             * @param floatVal
             * @param stringVal
             * @returns {boolean}
             */
            floatMatchString(floatVal, stringVal) {
                let a = floatVal;
                let b = stringVal;

                let rounded = Math.round(a * 100) / 100;
                a = rounded.toString().replace('.', ',').replace(/,\s*$/, '');

                if (b.includes(',')) b = b.replace(/((,0*)|,?0*)$/, '');

                console.log('a=' + a);
                console.log('b=' + b);
                return (a === b);
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
                let match = this.floatMatchString(this.form.amount, this.form.value);
                return (this.form.amount !== null && (this.$v.form.amount.$invalid || !match))
            }
        },

        watch: {
            form: {
                handler() {
                    if (this.form.value === '') {
                        this.form.amount = null;
                    } else {
                        this.form.amount = this.formatToNumber(this.form.value)
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
