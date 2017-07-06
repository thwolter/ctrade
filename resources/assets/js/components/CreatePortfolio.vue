<template>
    <div>
        <div class="input-form">

            <form @submit.prevent="onSubmit">
                <!-- portfolio name -->
                <div class="form-group row">
                    <label for="name" class="col-md-2 col-md-offset-1 col-form-label">Bezeichnung</label>
                    <div class="col-md-3">

                        <div>
                            <input type="text" name="name" placeholder="z.B. Deutsche Standardwerte" class="form-control">
                        </div>

                    </div>
                </div><!-- /portfolio name -->

                <!-- currency -->
                <div class="form-group row">
                    <label for="currency" class="col-md-2 col-md-offset-1 col-form-label">Währung</label>
                    <div class="col-md-3">

                        <select name="currency" v-model="currency" class="form-control">
                            <option value="" disabled selected hidden>Währung</option>
                            <option v-for="currency in currencies" :value="currency">
                                {{ currency }}
                            </option>
                        </select>

                    </div>
                </div><!-- /currency -->

                <!-- cash -->
                <div class="form-group row">
                    <label for="cash" class="col-md-2 col-md-offset-1 col-form-label">Barbestand</label>
                    <div class="col-md-3">

                        <div class="input-group">
                            <span class="input-group-addon">{{ currency }}</span>
                            <cleave type="text" id="cash" name="cash" class="form-control" v-model="form.cash"
                                placeholder="Betrag" :options="cleave"></cleave>
                        </div>

                    </div>
                </div><!-- /cash -->

                <div class="pull-right">
                    <button type="reset" class="btn btn-default">Abbrechen</button>
                    <button class="btn btn-primary">Erstellen</button>
                </div>
            </form>


        </div>
    </div>

</template>

<script>
    import {required, between} from 'vuelidate/lib/validators';
    import Input from '../mixins/Input.js';
    import Cleave from 'vue-cleave';

    export default {
        mixins: [Input],

        components: {
            Cleave
        },

        props: {
            route: String,
            currencies: Object
        },

        data() {
            return {
                form: new Form({
                    cash: null,
                    currency: null,
                    amount: null
                }),

                decimal: ',',
                currency: 'EUR',

                cleave: {
                    numeral: true,
                    numeralDecimalMark: ',',
                    delimiter: '.'
                }
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
            onSubmit()
            {
                this.form.currency = this.currency;
                this.form.post(this.route)
                    .then(Event.fire('portfolio-created', this.form));
            }
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

            error()
            {
                return (this.form.cash !== null && (this.$v.form.amount.$invalid))
            }
        },

        watch: {
            form: {
                handler()
                {
                    if (this.form.cash === '') {
                        this.form.amount = null;
                    } else {
                        this.form.amount = this.formatToNumber(this.form.cash, this.decimal)
                    }
                },
                deep: true
            }
        }
    }
</script>