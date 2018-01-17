<template>
    <div v-if="show" class="col-12">
        <!-- Set the limit parameters -->
        <form @submit.prevent="onSubmit" class="">

            <div class="col-8 offset-4">

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

                    <p v-if="form.errors.has('value')" class="error-text">
                        <span v-text="form.errors.get('value')"></span>
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

            <!-- Buttons -->

            <div class="float-right g-mt-30">
                <button class="btn btn-md u-btn-outline-lightgray" role="button" @click="onCancel">
                    {{ trans('buttons.cancel') }}
                </button>

                <div class="float-right g-ml-10">
                    <button class="btn btn-md u-btn-primary rounded-0">
                        <i v-if="submitting" class="fa fa-spinner fa-spin"></i>
                        {{ trans('buttons.save') }}
                    </button>
                </div>

            </div>

        </form>

    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import numeral from 'numeral';

    export default {

        props: {
            portfolio: {
                type: Object,
                required: true
            },
            limit: {
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
                    value: numeral(this.limit.value).format('0,0.00'),
                    date: this.limit.date,
                    email: this.limit.notify,
                    type: this.limit.type,
                    id: this.limit.id
                }),

                submitting: false,
                show: false,

                cleave: {
                    numeral: true,
                    numeralDecimalMark: ',',
                    numeralDecimalScale: 2,
                    delimiter: '.',
                    numeralPositiveOnly: true
                },
            }
        },

        methods: {

            onSubmit() {
                this.submitting = true;

                if (this.form.type !== 'target') {
                    this.form.date = null;
                }

                this.form.value = this.asNumeric(this.form.value);

                this.form.put(this.route)
                    .then(data => {
                        this.show = false;
                        window.location = data.redirect;
                    })
                    .catch(data => {
                        alert(data);
                    })
            },

            onCancel() {
                this.show = false;
            },

            asNumeric(value) {
                let number = parseFloat(value);
                return (isNaN(number) || !value) ? 0 : number;
            },
        },

        mounted() {
            this.$refs.datepicker.$on('opened', () => {
                this.form.errors.clear('date');
            })
        },

        created() {
            Event.listen('showLimitUpdate', (id) => {
                this.show = (this.limit.id === id);
            })
        }
    }
</script>
