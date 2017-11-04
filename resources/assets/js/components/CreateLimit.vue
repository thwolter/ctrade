<template>
    <div>

        <!-- Set the limit parameters -->
        <div v-if="showForm">
            <header class="text-uppercase g-mb-35">
                <div class="g-mb-30">
                    <span class="d-block g-color-primary g-font-weight-700 g-font-size-default g-mb-15">Sichere dein Portfolio</span>
                    <h2 class="h2 g-font-weight-700 mb-0">{{ text[type].formTitle }}</h2>
                </div>
                <div class="g-width-70 g-brd-bottom g-brd-2 g-brd-primary"></div>
            </header>

            <p class="g-mb-30">{{ text[type].formMessage }}</p>

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
                <div v-if="type=3" class="form-group row g-mb-25">
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
                                    :disabled="disabled"
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

                <hr class="g-my-50">

                <!-- Buttons -->
                <div class="text-sm-right">
                    <button type="" class="btn rounded-0 g-py-12 g-px-25 g-mr-10">Zurück</button>
                    <button type="submit" class="btn u-btn-primary rounded-0 g-py-12 g-px-25 g-mr-10">Speichern</button>
                </div>

            </form>
        </div>

        <!-- Choose a limit type -->
        <div v-else>
            <header class="text-uppercase g-mb-35">
                <div class="g-mb-30">
                    <span class="d-block g-color-primary g-font-weight-700 g-font-size-default g-mb-15">Sichere dein Portfolio</span>
                    <h2 class="h2 g-font-weight-700 mb-0">Schwellenwerte festlegen</h2>
                </div>
                <div class="g-width-70 g-brd-bottom g-brd-2 g-brd-primary"></div>
            </header>

            <p class="g-mb-30">Lege eine oder mehrere Schwellen für dein Portfoliofest. Bei Überschreiten der Schwellen
                kannst du dich per Mail banachrichtigen lassen.</p>

            <!-- Buttons -->
            <div class="row align-items-stretch">
                <div v-for="msg in text" class="col-sm-6">
                    <a href="#"
                       @click="setType(msg.type)"
                       class="btn u-btn-content u-btn-darkgray g-brd-2 g-mr-10
                                    g-brd-primary-left g-mb-15 g-pa-20 g-flex-centered">
                        <div class="text-left g-flex-middle-item">
                            <h4 class="h6 g-color-white g-font-weight-600 text-uppercase g-mb-10">
                                {{ msg.title }}
                            </h4>
                            <p class="g-color-white-opacity-0_7">
                                {{ msg.description }}
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

        components: {
            Datepicker
        },

        data() {
            return {
                type: null,
                showForm: false,

                form: new Form({
                    amount: null,
                    date: (new Date()).toISOString().split('T')[0],
                    portfolio: null
                }),

                cleave: {
                    numeral: true,
                    numeralDecimalMark: ',',
                    delimiter: '.',
                    numeralPositiveOnly: true
                },

                text: [
                    {
                        title: 'Absolut',
                        description: 'Fester Wert in der Portfoliowährung',
                        formTitle: 'Absolute Warnschwelle',
                        formMessage: 'Der Mindestwert, den das Portfolio am Ende einer festgelegten Periode ' +
                        'ausweisen soll. Bei dieser Limitart wird davon ausgegangen, dass keine Anpassung des ' +
                        'Portfolio bis zum Ende der gewählten Period erfolgen soll.',
                        type: 0
                    },
                    {
                        title: 'Relativ',
                        description: 'prozentualer Wert in der Portfoliowährung',
                        formTitle: 'Absolute Warnschwelle',
                        formMessage: 'blabla',
                        type: 1
                    },
                    {
                        title: 'Untergrenze',
                        description: 'prozentualer Wert in der Portfoliowährung',
                        formTitle: 'Absolute Warnschwelle',
                        formMessage: 'blabla',
                        type: 2
                    },
                    {
                        title: 'Zielwert',
                        description: 'prozentualer Wert in der Portfoliowährung',
                        formTitle: 'Absolute Warnschwelle',
                        formMessage: 'blabla',
                        type: 3
                    }
                ]
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

            setType(type) {
                this.type = type;
                this.showForm = true;
            }
        },

        mounted() {
            this.initDatapickerEvents();
        }
    }
</script>
