<template>

    <form @submit.prevent="onSubmit" class="g-bg-brown-opacity-0_1">
        <div class="g-ml-10--md">

            <!-- portfolio name -->
            <div class="form-group g-mb-25 col-md-6">
                <label for="name" class="g-mb-10">Bezeichnung</label>
                <div class="col-md-7">

                    <input type="text" name="name" placeholder="Name des Portfolios"
                           :class="['form-control form-control-md', { 'error': form.errors.has('name') }]"
                           v-model="form.name" @keydown="form.errors.clear('name')">

                    <p v-if="form.errors.has('name')" class="form-control-feedback">
                        <span v-text="form.errors.get('name')"></span>
                    </p>

                </div>
            </div><!-- /portfolio name -->


            <!-- currency -->
            <div class="g-mb-25 col-md-6">
                <label for="currency" class="g-mb-10">Währung</label>
                <div class="col-md-7">

                    <select name="currency" v-model="form.currency" class="form-control form-control-md">
                        <option value="" disabled selected hidden>Währung</option>
                        <option v-for="currency in currencies" :value="currency">
                            {{ currency }}
                        </option>
                    </select>

                </div>
            </div><!-- /currency -->


            <div v-if="showCash">

                <!-- cash -->
                <div class="form-group row">
                    <label for="cash" class="col-md-3 col-md-offset-1 col-form-label">Einzahlung</label>
                    <div class="col-md-7">

                        <div class="input-group">
                            <span class="input-group-addon">{{ form.currency }}</span>
                            <cleave type="text" id="cash" name="cash" v-model="cash"
                                    placeholder="Betrag" :options="cleave"
                                    :class="['form-control', { 'error': form.errors.has('amount') }]"
                                    @rawValueChanged="form.errors.clear('amount')"></cleave>
                        </div>
                        <p v-if="form.errors.has('amount')" class="error-text">
                            <span v-text="form.errors.get('amount')"></span>
                        </p>
                    </div>
                </div><!-- /cash -->

                <!-- date -->
                <div class="form-group row">
                    <label for="date" class="col-md-3 col-md-offset-1 col-form-label">Datum</label>
                    <div class="col-md-7">
                        <div class="input-group date" id="datepicker">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <datepicker
                                    v-model="form.date"
                                    name="date"
                                    input-class="form-control"
                                    language="de"
                                    @keydown="form.errors.clear('date')">
                            </datepicker>
                        </div>

                        <p v-if="form.errors.has('date')" class="error-text">
                            <span v-text="form.errors.get('date')"></span>
                        </p>

                    </div>
                </div><!-- /date -->

            </div>


            <!-- portfolio category -->
            <div v-if="categories.length" class="form-group row">
                <label for="category" class="col-md-3 col-md-offset-1 col-form-label">Kategorie</label>
                <div class="col-md-7">

                    <select name="category" class="form-control" v-model="form.category">
                        <option :value="null">keine Kategorie</option>
                        <option v-for="category in categories" :value="category">{{ category }}</option>
                    </select>

                    <p v-if="form.errors.has('category')" class="error-text">
                        <span v-text="form.errors.get('category')"></span>
                    </p>

                </div>
            </div><!-- /portfolio category -->

            <!-- portfolio description -->
            <div class="form-group row">
                <label for="category" class="col-md-3 col-md-offset-1 col-form-label">Notiz</label>
                <div class="col-md-7">

                    <div>
                                <textarea rows="6" name="description" placeholder="Notizen zum Portfolio"
                                          class="form-control" v-model="form.description"
                                          @keydown="form.errors.clear('description')">
                                </textarea>
                    </div>

                    <p v-if="form.errors.has('description')" class="error-text">
                        <span v-text="form.errors.get('description')"></span>
                    </p>

                </div>
            </div><!-- /portfolio description -->

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="pull-right">
                        <button type="reset" class="btn btn-default">Abbrechen</button>
                        <button class="btn btn-primary">Erstellen</button>
                    </div>
                </div>
            </div>

        </div>

    </form>

</template>

<script>

    import {required, between} from 'vuelidate/lib/validators';
    import Input from '../mixins/Input.js';
    import Cleave from 'vue-cleave';
    import Datepicker from 'vuejs-datepicker';

    export default {

        mixins: [Input],

        components: {
            Cleave,
            Datepicker
        },

        props: {
            route: String,
            redirect: String,
            currencies: Object,
            categories: null
        },

        data() {
            return {
                form: new Form({
                    currency: 'EUR',
                    amount: null,
                    date: (new Date()).toISOString().split('T')[0],
                    name: null,
                    manage: true,
                    category: null,
                    description: null,
                    transaction: 'deposit'
                }),

                decimal: ',',
                cash: null,

                showCash: true,

                management: [
                    {text: 'Ohne Cash Management', value: false},
                    {text: 'Mit Cash Management', value: true},
                ],

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
            onSubmit() {
                this.form.date = (new Date(this.form.date)).toISOString().split('T')[0];

                this.form.post(this.route)
                    .then(data => {
                        Event.fire('portfolio-created', data);
                        window.location = data.redirect;
                    })
                    .catch(error => {

                    });
            }
        },

        watch: {
            cash: {
                handler() {
                    if (this.cash === '') {
                        this.form.amount = null;
                    } else {
                        this.form.amount = this.formatToNumber(this.cash, this.decimal)
                    }
                },
                deep: true
            },

            form: {
                deep: true,
                handler() {
                    this.showCash = (this.form.manage === true);
                }
            }
        }
    }
</script>