<template>
    <div v-if="showDialog">
        <p class="g-mb-30">Zahle Geld ein oder aus.</p>
        <div class="row justify-content-center">

            <!-- Form -->
            <form v-if="showDialog" @submit.prevent="onSubmit"
                  class="col-md-8 g-brd-around g-brd-gray-light-v4 g-mb-30 g-bg-secondary">

                <!-- Spinner -->
                <div v-if="showSpinner" class="spinner-gritcode">
                    <vue-simple-spinner class="spinner-wrapper" message="Transaktion durchführen"></vue-simple-spinner>
                </div>

                <div class="g-pa-30">

                    <!-- Transaction Type -->
                    <div>
                        <div class="g-mb-10">Transaktion</div>
                        <div class="g-mb-30">
                            <label class="form-check-inline u-check g-pl-25 ml-0 g-mr-25">
                                <input class="g-hidden-xs-up g-pos-abs g-top-0 g-left-0" name="radInline1_1"
                                       type="radio"
                                       v-model="form.deposit" :value="true">
                                <div class="u-check-icon-radio-v4 g-absolute-centered--y g-left-0 g-width-18 g-height-18">
                                    <i class="g-absolute-centered d-block g-width-10 g-height-10 g-bg-primary--checked"></i>
                                </div>
                                Einzahlung
                            </label>

                            <label class="form-check-inline u-check g-pl-25 ml-0 g-mr-25">
                                <input class="g-hidden-xs-up g-pos-abs g-top-0 g-left-0" name="radInline1_1"
                                       type="radio"
                                       v-model="form.deposit" :value="false">
                                <div class="u-check-icon-radio-v4 g-absolute-centered--y g-left-0 g-width-18 g-height-18">
                                    <i class="g-absolute-centered d-block g-width-10 g-height-10 g-bg-primary--checked"></i>
                                </div>
                                Auszahlung
                            </label>
                        </div>
                    </div>

                    <!-- Amount Input -->
                    <div class="form-group g-mb-20"
                         :class="[ exceed || form.errors.has('amount') ? 'u-has-error-v1-2' : '' ]">
                        <label class="g-mb-10" for="amount">Betrag</label>
                        <div class="input-group g-brd-primary--focus">
                            <div class="input-group-addon align-items-center g-bg-white rounded-0">
                                {{ portfolio.currency }}
                            </div>
                            <cleave id="amount"
                                    v-model="form.amount"
                                    placeholder="Betrag"
                                    :options="cleave"
                                    :class="['form-control form-control-md']"
                                    @input="form.errors.clear('amount')">
                            </cleave>
                        </div>
                        <small v-if="exceed" class="form-control-feedback">Betrag übertsteigt vohandenen Geldbetrag.
                        </small>
                        <small v-if="form.errors.has('amount')" class="form-control-feedback">{{
                            form.errors.get('amount')
                            }}
                        </small>
                        <small class="form-text text-muted g-font-size-default g-mt-10">We'll never share your email
                            with
                            anyone else.
                        </small>

                    </div>

                    <!-- Select Date Input -->
                    <div class="form-group g-mb-30"
                         :class="[ overlap || form.errors.has('date') ? 'u-has-error-v1-2' : '' ]">
                        <label class="g-mb-10" for="date">Datum der Transaktion</label>
                        <div class="input-group g-brd-primary--focus">
                            <datepicker id="date"
                                        v-model="rawDate"
                                        name="date"
                                        wrapper-class="w-100"
                                        input-class="form-control form-control-md w-100 g-brd-right-none rounded-0 g-bg-white"
                                        language="de"
                                        placeholder="Datum"
                                        :full-month-name="true"
                                        :monday-first="true"
                                        :disabled="state.disabled"
                                        :highlighted="state.highlighted"
                                        ref="datepicker"
                                        @input="form.errors.clear('date')">
                            </datepicker>
                            <div class="input-group-addon d-flex align-items-center g-bg-white g-color-gray-dark-v5 rounded-0 g-brd-left-non">
                                <i class="icon-calendar"></i>
                            </div>
                        </div>
                        <small v-if="overlap" class="form-control-feedback">{{ trans('validation.transaction.after') }}
                        </small>
                        <small v-if="form.errors.has('date')" class="form-control-feedback">{{ form.errors.get('date')
                            }}
                        </small>

                    </div>

                    <!-- Buttons -->
                    <div class="form-group pull-right g-mb-30 g-mt-20">
                        <button v-if="form.deposit" class="btn u-btn-teal" :disabled="hasError">
                            Einzahlen
                        </button>
                        <button v-else type="submit" class="btn u-btn-deeporange" :disabled="hasError">
                            Auszahlen
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <div v-else>
        sucess
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import Spinner from 'vue-simple-spinner';

    let moment = require('moment');

    export default {

        props: {
            portfolio: {
                type: Object,
                required: true
            },
            route: {
                type: String,
                required: true
            }
        },

        components: {
            Datepicker
        },

        data() {
            return {
                form: new Form({
                    amount: null,
                    deposit: true,
                    date: new Date(),
                    id: this.portfolio.id
                }),

                rawDate: new Date(),

                cleave: {
                    numeral: true,
                    numeralDecimalMark: ',',
                    delimiter: '.',
                    numeralPositiveOnly: true
                },

                state: {
                    disabled: {
                        from: new Date()
                    },
                    highlighted: {
                        dates: [new Date()]
                    }
                },

                showDialog: true,
                showSpinner: false,

                hasFormError: false,
                exceedCash: false,
            }
        },


        methods: {
            onSubmit() {
                this.form.date = this.asDateString(this.rawDate);
                this.showSpinner = true;

                this.form.post(this.route)
                    .then(data => {
                        this.showDialog = false;
                        this.showSpinner = false;
                    })
                    .catch(error => {
                        this.showSpinner = false;
                    });
            },

            asDateString(date) {
                return date.toISOString().split('T')[0]
            }
        },

        computed: {

            overlap() {
                return this.portfolio.lastTransactionDate > this.asDateString(this.rawDate);
            },

            exceed() {
                return (parseFloat(this.portfolio.cash) < this.form.amount) && !this.deposit
            },

            hasError() {
                return (this.hasFormError || this.exceedCash);
            }
        },

        watch: {
            form: {
                deep: true,
                handler() {
                    this.hasFormError = this.form.errors.any();
                }
            }
        }
    }
</script>
