<template>
    <div v-if="showForm" class="g-brd-gray-light-v5 g-brd-around">
        <!-- Set the limit parameters -->
        <form @submit.prevent="onSubmit" class="g-pa-20">

            <div class="row g-pa-20">

                <div class="col-md-3">
                    <!-- Select Buttons -->
                    <div class="form-group">
                        <label class="g-mb-10" for="amount">{{ trans('limits.type') }}</label>

                        <div class="btn-group-vertical w-100">
                            <label v-for="type in types" class="w-100 u-check">
                                <input :id="type"
                                       v-model="form.type"
                                       type="radio"
                                       :value="type"
                                       class="g-hidden-xs-up g-pos-abs g-top-0 g-left-0"
                                       checked>
                                <span class="btn btn-md btn-block u-btn-outline-lightgray g-color-white--checked g-bg-primary--checked rounded-0">
                                    {{ trans('limits.' + type + '.short') }}
                                </span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-md-9 g-pl-100--md">

                    <!-- Limit amount -->
                    <div class="form-group g-mb-25">
                        <label class="g-mb-10" for="amount">{{ trans('limits.limit') }}</label>
                        <div class="input-group g-brd-primary--focus">
                            <div class="input-group-addon d-flex align-items-center g-bg-white g-color-gray-light-v1 rounded-0">
                                {{ portfolio.currency }}
                            </div>
                            <cleave id="value"
                                    v-model="form.value"
                                    :placeholder="trans('limits.value')"
                                    :options="cleave"
                                    :class="['form-control form-control-md', { 'error': form.errors.has('value') }]"
                                    @input="form.errors.clear('value')">
                            </cleave>
                        </div>

                        <p v-if="form.errors.has('amount')" class="error-text">
                            <span v-text="form.errors.get('amount')"></span>
                        </p>
                    </div>

                    <!-- Limit target date -->
                    <div v-if="form.type === 'target'" class="form-group g-mb-25">
                        <label class="g-mb-10" for="date">{{ trans('limits.date') }}</label>
                        <div class="input-group g-brd-primary--focus">
                            <div class="input-group-addon d-flex align-items-center g-bg-white g-color-gray-dark-v5 rounded-0">
                                <i class="icon-calendar"></i>
                            </div>
                            <datepicker id="date"
                                        v-model="form.date"
                                        name="date"
                                        input-class="form-control form-control-md u-datepicker-v1 g-width-auto g-brd-left-none rounded-0 g-bg-white"
                                        language="de"
                                        :placeholder="trans('limits.date.target')"
                                        :full-month-name="true"
                                        :monday-first="true"
                                        ref="datepicker">
                            </datepicker>
                        </div>

                        <p v-if="form.errors.has('date')" class="error-text">
                            <span v-text="form.errors.get('date')"></span>
                        </p>
                    </div>

                    <!-- Email -->
                    <div class="form-group g-pt-10">
                        <label class="form-check-inline u-check g-pl-25">
                            <input v-model="form.email" class="g-hidden-xs-up g-pos-abs g-top-0 g-left-0"
                                   type="checkbox">
                            <div class="u-check-icon-checkbox-v6 g-absolute-centered--y g-left-0">
                                <i class="fa" data-check-icon=""></i>
                            </div>
                            {{ trans('limits.email') }}
                        </label>
                    </div>
                </div>
            </div>


            <!-- Buttons -->
            <div class="row">
                <div class="col-md-9 g-mb-0--md g-mb-20">
                    {{ trans('limits.' + form.type + '.help') }}
                </div>
                <div class="align-items-end col-md-3 d-flex justify-content-end">
                    <div style="position: relative;">
                        <button @click="onSubmit" class="btn u-btn-darkgray rounded-0 g-py-12 g-px-25">
                            {{ trans('limits.save') }}
                        </button>

                        <!-- Spinner -->
                        <div v-if="submitting" class="spinner-gritcode g-bg-black-opacity-0_4">
                            <vue-simple-spinner class="spinner-wrapper" message="" size="small"></vue-simple-spinner>
                        </div>
                    </div>

                </div>
            </div>

        </form>
    </div>
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

                types: ['absolute', 'relative', 'floor', 'target'],

                form: new Form({
                    type: 'absolute',
                    value: null,
                    date: (new Date()).toISOString().split('T')[0],
                    email: false,
                    id: this.portfolio.id
                }),

                submitting: false,
                showForm: true,

                cleave: {
                    numeral: true,
                    numeralDecimalMark: ',',
                    delimiter: '.',
                    numeralPositiveOnly: true
                },
            }
        },

        methods: {

            onSubmit() {
                this.submitting = true;
                this.form.post(this.route)
                    .then(data => {
                        this.showForm = false;
                        window.location = data.redirect;
                    })
            }
        },

        mounted() {
            this.$refs.datepicker.$on('opened', () => {
                this.form.errors.clear('date');
            });
        }
    }
</script>
