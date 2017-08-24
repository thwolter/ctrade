<template>
    <div>
        <div class="input-form">
            <form @submit.prevent="onSubmit">

                <div>

                    <!-- portfolio name -->
                    <div class="form-group row">
                        <label for="name" class="col-md-3 col-md-offset-1 col-form-label">Bezeichnung</label>
                        <div class="col-md-7">

                            <div>
                                <input type="text" name="name" placeholder="Name des Portfolios"
                                       class="form-control" v-model="form.name" @keydown="form.errors.clear('name')">
                            </div>

                            <p v-if="form.errors.has('name')" class="error-text">
                                <span v-text="form.errors.get('name')"></span>
                            </p>

                        </div>
                    </div><!-- /portfolio name -->

                    <!-- currency -->
                    <div class="form-group row">
                        <label for="currency" class="col-md-3 col-md-offset-1 col-form-label">Währung</label>
                        <div class="col-md-7">

                            <select name="currency" v-model="form.currency" class="form-control">
                                <option value="" disabled selected hidden>Währung</option>
                                <option v-for="currency in currencies" :value="currency">
                                    {{ currency }}
                                </option>
                            </select>

                        </div>
                    </div><!-- /currency -->

                    <!-- cash -->
                    <div class="form-group row">
                        <label for="cash" class="col-md-3 col-md-offset-1 col-form-label">Barbestand</label>
                        <div class="col-md-7">

                            <div class="input-group">
                                <span class="input-group-addon">{{ form.currency }}</span>
                                <cleave type="text" id="cash" name="cash" class="form-control" v-model="cash"
                                        placeholder="Betrag" :options="cleave"
                                        @rawValueChanged="form.errors.clear('amount')"></cleave>
                            </div>

                            <p v-if="form.errors.has('amount')" class="error-text">
                                <span v-text="form.errors.get('amount')"></span>
                            </p>

                        </div>
                    </div><!-- /cash -->

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
                        <label for="category" class="col-md-3 col-md-offset-1 col-form-label">Beschreibung</label>
                        <div class="col-md-7">

                            <div>
                                <textarea rows="6" name="description" placeholder="Beschreibe dein Portfolio"
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
            redirect: String,
            currencies: Object,
            categories: null,
        },

        data() {
            return {
                form: new Form({
                    currency: 'EUR',
                    amount: null,
                    name: null,
                    category: null,
                    description: null
                }),

                decimal: ',',
                cash: null,

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
                this.form.post(this.route)
                    .then(data => {
                        Event.fire('portfolio-created', data),
                            window.location = data.redirect;
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
            }
        }
    }
</script>