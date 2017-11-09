<template>
    <div>

        <!-- Set the limit parameters -->
        <div v-if="showForm">
            <header class="text-uppercase g-mb-35">
                <div class="g-mb-30">
                    <span class="d-block g-color-primary g-font-weight-700 g-font-size-default g-mb-15">
                        {{ trans('limits.'+form.type+'.form.subtitle') }}
                    </span>
                    <h2 class="h2 g-font-weight-700 mb-0">{{ trans('limits.'+form.type+'.form.title') }}</h2>
                </div>
                <div class="g-width-70 g-brd-bottom g-brd-2 g-brd-primary"></div>
            </header>

            <p class="g-mb-30">{{ trans('limits.'+form.type+'.form.text') }}</p>

            <form @submit.prevent="onSubmit">

                <div class="row g-ml-10--md">

                    <!-- Limit amount -->
                    <div class="form-group g-mb-25 col-md-6">
                    <label class="g-mb-10" for="amount">{{ trans('limits.limit') }}</label>
                    <div class="input-group g-brd-primary--focus">
                        <div class="input-group-addon d-flex align-items-center g-bg-white g-color-gray-light-v1 rounded-0">
                            {{ portfolio.currency }}
                        </div>
                        <cleave id="amount"
                                v-model="form.amount"
                                :placeholder="trans('limits.amount')"
                                :options="cleave"
                                :class="['form-control form-control-md', { 'error': form.errors.has('date') }]"
                                @input="form.errors.clear('amount')"></cleave>
                    </div>

                    <p v-if="form.errors.has('amount')" class="error-text">
                        <span v-text="form.errors.get('amount')"></span>
                    </p>
                </div>

                    <!-- Limit target date -->
                    <div v-if="form.type === 'target'" class="form-group g-mb-25 col-md-6">
                    <label class="g-mb-10" for="date">{{ trans('limits.date') }}</label>
                    <div class="input-group g-brd-primary--focus">
                        <div class="input-group-addon d-flex align-items-center g-bg-white g-color-gray-dark-v5 rounded-0">
                            <i class="icon-calendar"></i>
                        </div>
                        <datepicker id="date"
                                    v-model="form.date"
                                    name="date"
                                    input-class="form-control form-control-md u-datepicker-v1 g-width-auto g-brd-left-none rounded-0"
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

                </div>

                <!-- Email -->
                <label class="form-check-inline u-check g-pl-25 g-ml-25--md g-mt-20">
                    <input v-model="form.email" class="g-hidden-xs-up g-pos-abs g-top-0 g-left-0" type="checkbox">
                    <div class="u-check-icon-checkbox-v6 g-absolute-centered--y g-left-0">
                        <i class="fa" data-check-icon=""></i>
                    </div>
                    {{ trans('limits.email.option') }}
                </label>

                <hr class="g-mt-50">

                <!-- Buttons -->
                <div class="text-sm-right">
                    <a @click="showForm=false" class="btn btn-outline-secondary rounded-0 g-py-12 g-px-25 g-mr-10">
                        {{ trans('limits.buttons.back') }}
                    </a>
                    <button @click="onSubmit" class="btn u-btn-primary rounded-0 g-py-12 g-px-25 g-mr-10">
                        {{ trans('limits.buttons.save') }}
                    </button>
                </div>

            </form>
        </div>


        <!-- Choose a limit type -->
        <div v-else>
            <header class="text-uppercase g-mb-35">
                <div class="g-mb-30">
                    <span class="d-block g-color-primary g-font-weight-700 g-font-size-default g-mb-15">
                        {{ trans('limits.dialog.subtitle') }}
                    </span>
                    <h2 class="h2 g-font-weight-700 mb-0">{{ trans('limits.dialog.title') }}</h2>
                </div>
                <div class="g-width-70 g-brd-bottom g-brd-2 g-brd-primary"></div>
            </header>

            <p class="g-mb-30">{{ trans('limits.dialog.text') }}</p>

            <!-- Buttons -->
            <div class="row align-items-stretch">
                <div v-for="type in types" :key=type class="col-sm-6">
                    <a href="#"
                       @click="toggleForm(type)"
                       class="btn u-btn-content u-btn-darkgray g-brd-2 g-mr-10
                                    g-brd-primary-left g-mb-15 g-pa-20 g-flex-centered">
                        <div class="text-left g-flex-middle-item">
                            <h4 class="h6 g-color-white g-font-weight-600 text-uppercase g-mb-10">
                                {{ trans('limits.'+type+'.button.title') }}
                            </h4>
                            <p class="g-color-white-opacity-0_7">
                                {{ trans('limits.'+type+'.button.text') }}
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

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
                showForm: false,

                types: ['absolute', 'relative', 'floor', 'target'],

                form: new Form({
                    type: null,
                    amount: null,
                    date: (new Date()).toISOString().split('T')[0],
                    email: false,
                    id: this.portfolio.id
                }),

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
                this.form.post(this.route)
                    .then(data => {
                        this.hide();
                        window.location = data.redirect;
                    })
            },

            initDatapickerEvents() {
                this.$refs.datepicker.$on('opened', () => {
                    this.form.errors.clear('executed');
                    this.updatePrice();
                });
            },

            toggleForm(type) {
                this.form.type = type;
                this.showForm = true;
            }
        },

        mounted() {
            this.initDatapickerEvents();
        }
    }
</script>
