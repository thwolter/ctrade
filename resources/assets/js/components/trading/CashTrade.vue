<template>
    <form @submit.prevent="onSubmit"
          class="col-md-8 g-brd-around g-brd-gray-light-v4 g-pa-30 g-mb-30">

        <div class="g-mb-15">
            <label class="form-check-inline u-check g-pl-25 ml-0 g-mr-25">
                <input class="g-hidden-xs-up g-pos-abs g-top-0 g-left-0" name="radInline1_1" type="radio"
                       v-model="form.deposit">
                <div class="u-check-icon-radio-v4 g-absolute-centered--y g-left-0 g-width-18 g-height-18">
                    <i class="g-absolute-centered d-block g-width-10 g-height-10 g-bg-primary--checked"></i>
                </div>
                Einzahlung
            </label>

            <label class="form-check-inline u-check g-pl-25 ml-0 g-mr-25">
                <input class="g-hidden-xs-up g-pos-abs g-top-0 g-left-0" name="radInline1_1" type="radio">
                <div class="u-check-icon-radio-v4 g-absolute-centered--y g-left-0 g-width-18 g-height-18">
                    <i class="g-absolute-centered d-block g-width-10 g-height-10 g-bg-primary--checked"></i>
                </div>
                Auszahlung
            </label>
        </div>

        <!-- Amount Input -->
        <div class="form-group g-mb-20">
            <label class="g-mb-10" for="amount">Betrag</label>
            <div class="input-group g-brd-primary--focus">
                <div class="input-group-addon d-flex align-items-center g-bg-white g-color-gray-light-v1 rounded-0">
                    {{ portfolio.currency }}
                </div>
                <cleave id="amount"
                        v-model="form.amount"
                        placeholder="Betrag"
                        :options="cleave"
                        :class="['form-control form-control-md', { 'error': form.errors.has('amount') }]"
                        @input="form.errors.clear('amount')">
                </cleave>
            </div>
            <small class="form-text text-muted g-font-size-default g-mt-10">We'll never share your email with
                anyone else.
            </small>
        </div>

        <!-- Select Date Input -->
        <div class="form-group g-mb-30">
            <label class="g-mb-10" for="date">Datum der Transaktion</label>
            <div class="input-group g-brd-primary--focus">
                <datepicker id="date"
                            v-model="form.date"
                            name="date"
                            wrapper-class="w-100"
                            input-class="form-control form-control-md w-100 g-brd-right-none rounded-0 g-bg-white"
                            language="de"
                            placeholder="Datum"
                            :full-month-name="true"
                            :monday-first="true"
                            ref="datepicker">
                </datepicker>
                <div class="input-group-addon d-flex align-items-center g-bg-white g-color-gray-dark-v5 rounded-0 g-brd-left-non">
                    <i class="icon-calendar"></i>
                </div>
            </div>
        </div>

    </form>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';

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
                    date: (new Date()).toISOString().split('T')[0],
                    id: this.portfolio.id
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
            }
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
