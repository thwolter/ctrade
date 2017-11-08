<template>
    <div>

        <!-- Set the limit parameters -->
        <div v-if="showForm">
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

            <form @submit.prevent="onSubmit">

                <!-- Limit amount -->
                <div class="form-group row g-mb-25">
                    <div class="col-sm-9 g-mt-10">
                        <div class="input-group g-brd-primary--focus">
                            <div class="input-group-addon d-flex align-items-center g-bg-white g-color-gray-light-v1 rounded-0">
                                EUR
                            </div>
                            <cleave v-model="form.amount" placeholder="Betrag"
                                    :options="cleave"
                                    :class="['form-control form-control-md', { 'error': form.errors.has('date') }]"
                                    @input="form.errors.clear('amount')"></cleave>
                        </div>
                    </div>
                </div>

                <!-- Limit target date -->
                <div v-if="form.type === 'target'" class="form-group row g-mb-25">
                    <div class="col-sm-9 g-mt-10">
                        <div class="input-group g-brd-primary--focus">
                            <div class="input-group-addon d-flex align-items-center g-bg-white g-color-gray-dark-v5 rounded-0">
                                <i class="icon-calendar"></i>
                            </div>
                            <datepicker
                                    v-model="form.date"
                                    name="date"
                                    input-class="form-control form-control-md u-datepicker-v1 g-width-auto g-brd-left-none rounded-0"
                                    language="de"
                                    placeholder="Zieldatum"
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

                <hr class="g-mt-50">

                <!-- Buttons -->
                <div class="text-sm-right">
                    <a @click="showForm=false" class="btn btn-outline-secondary rounded-0 g-py-12 g-px-25 g-mr-10">Zurück</a>
                    <button @click="onSubmit" class="btn u-btn-primary rounded-0 g-py-12 g-px-25 g-mr-10">Speichern</button>
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
                                {{ text[type].button.title }}
                            </h4>
                            <p class="g-color-white-opacity-0_7">
                                {{ text[type].button.text }}
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
            portfolioId: {
                type: Number,
                required: true,
            }
        },

        components: {
            Datepicker
        },

        data() {
            return {
                showForm: false,
                limitItem: null,
                text: null,

                types: ['absolute', 'relative', 'floor', 'target'],

                form: new Form({
                    type: null,
                    amount: null,
                    date: (new Date()).toISOString().split('T')[0],
                    portfolioId: this.portfolioId
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
                this.limitItem = this.text[type];
                this.form.type = type;
                this.showForm = true;
            }
        },

        mounted() {
            this.text = trans('limits');
            this.initDatapickerEvents();
        }
    }
</script>
