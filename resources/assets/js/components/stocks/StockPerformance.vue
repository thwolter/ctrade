<template>
    <div v-cloak>

        <div class="row">
            <div class="col-md-3 ml-md-auto">
                <div class="form-group row g-mb-25">
                    <select v-model="exchange" data-open-icon="fa fa-angle-down" data-close-icon="fa fa-angle-up"
                            class="form-control rounded-0 u-select-v1 g-brd-gray-light-v2 g-color-gray-dark-v5 w-100 g-pt-11 g-pb-10">
                        <option v-for="exchange in exchanges" :value="exchange.code">
                            {{ exchange.name }}
                        </option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 g-mb-30">
                <ul class="list-unstyled g-color-text">
                    <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                        <span>Name</span>
                        <span class="float-right g-color-black" v-text="stock.name"></span>
                    </li>
                    <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                        <span>ISIN/WKN</span>
                        <span class="float-right g-color-black">{{ stock.isin }} / {{ stock.wkn }}</span>
                    </li>
                    <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                        <span>Sector</span>
                        <span class="float-right g-color-black" v-text="stock.sector"></span>
                    </li>
                    <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                        <span>Industry</span>
                        <span class="float-right g-color-black" v-text="stock.industry"></span>
                    </li>
                </ul>
            </div>

            <div class="col-md-4 g-mb-30">
                <ul class="list-unstyled g-color-text">
                    <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                        <span>Kurs</span>
                        <span class="float-right g-color-black" v-text="close">...</span>
                    </li>
                    <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                        <span>Kursdatum</span>
                        <span class="float-right g-color-black" v-text="date">...</span>
                    </li>
                    <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                        <span>Vortag</span>
                        <span class="float-right g-color-black" v-text="previous"></span>
                    </li>
                    <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                        <span>Volume</span>
                        <span class="float-right g-color-black" v-text="volume"></span>
                    </li>
                </ul>
            </div>

            <div class="col-md-4 g-mb-30">
                <ul class="list-unstyled g-color-text">
                    <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                        <span>High/Low</span>
                        <span class="float-right g-color-black">{{ high }} / {{ low }}</span>
                    </li>
                    <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                        <span>52 Wo. hoch</span>
                        <span class="float-right g-color-black" v-text="highYear">...</span>
                    </li>
                    <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                        <span>52 Wo. tief</span>
                        <span class="float-right g-color-black" v-text="lowYear">...</span>
                    </li>
                    <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                        <span>52 Wo. perf.</span>
                        <span class="float-right g-color-black" v-text="returnYear"></span>
                    </li>
                </ul>
            </div>

        </div>
    </div>

</template>

<script>
    export default {

        props: [
            'stock',
            'locale'
        ],

        data() {
            return {
                lookup: '/api/stock/history',

                routeParams: {
                    id: this.stock.id,
                    date: null,
                    count: 250,
                    exchange: null
                },

                history: null,
                exchanges: null,
                exchange: null
            }
        },

        methods: {
            fetch() {
                axios.get(this.lookup, {
                    params: this.routeParams
                })
                    .then(data => {
                        this.history = data.data.history;
                        this.exchanges = data.data.exchanges;

                    })
            },

            column(name) {
                return this.history.columns.findIndex((element) => (element === name));
            }
        },

        computed: {
            currency: function () {
                return this.history.currency;
            },

            close: function () {
                return this.history.data[0][this.column('Close')]
                    .toLocaleString(this.locale, {style: 'currency', currency: this.currency});
            },

            previous: function () {
                return this.history.data[1][this.column('Close')]
                    .toLocaleString(this.locale, {style: 'currency', currency: this.currency});
            },

            date() {
                return new Date(this.history.data[0][this.column('Date')])
                    .toLocaleDateString(this.locale);
            },

            volume() {
                return this.history.data[0][this.column('Volume')]
                    .toLocaleString(this.locale);
            },

            high: function () {
                return this.history.data[0][this.column('High')]
                    .toLocaleString(this.locale, {style: 'currency', currency: this.currency});
            },

            low: function () {
                return this.history.data[0][this.column('Low')]
                    .toLocaleString(this.locale, {style: 'currency', currency: this.currency});
            },

            highYear() {
                return _.max(this.history.data.map(x => x[this.column('Close')]))
                    .toLocaleString(this.locale, {style: 'currency', currency: this.currency});
            },

            lowYear() {
                return _.min(this.history.data.map(x => x[this.column('Close')]))
                    .toLocaleString(this.locale, {style: 'currency', currency: this.currency});
            },

            returnYear() {
                let current = this.history.data[0][this.column('Close')];

                if (this.history.data.length >= 250) {
                    let previous = this.history.data[249][this.column('Close')];
                    if (previous !== 0) {
                        return (current / previous - 1)
                            .toLocaleString(this.locale, {style: 'percent'});
                    }
                }
            }
        },

        watch: {
            exchange: function (value) {
                this.routeParams.exchange = value;
                this.fetch();
            },

            exchanges: function () {
                if (!this.exchange) {
                    this.exchange = this.exchanges[0].code;
                }
            }
        },

        mounted() {
            this.fetch();
        }
    }
</script>
