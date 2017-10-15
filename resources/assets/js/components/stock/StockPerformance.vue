<template>
    <div v-cloak>


        <div class="form-group row g-mb-25">
            <select v-model="exchange" data-open-icon="fa fa-angle-down" data-close-icon="fa fa-angle-up"
                    class="form-control u-select-v1 g-brd-gray-light-v2 g-color-gray-dark-v5 w-100 g-pt-11 g-pb-10">
                <option v-for="exchange in exchanges" :value="exchange.code">
                    {{ exchange.name }}
                </option>
            </select>
        </div>

        <div class="row">
            <div class="col-md-6 g-mb-30">

                <table class="table table-responsive table-hoover">
                    <tbody>
                    <tr>
                        <td>Kurs</td>
                        <td v-text="close"></td>
                    </tr>
                    <tr>
                        <td>Kursdatum</td>
                        <td v-text="date"></td>
                    </tr>
                    <tr>
                        <td>Vortag</td>
                        <td v-text="previous"></td>
                    </tr>
                    <tr>
                        <td>Volume</td>
                        <td v-text="volume"></td>
                    </tr>
                    <tr>
                        <td>High/Low</td>
                        <td>{{ high }} / {{ low }}</td>
                    </tr>
                    <tr>
                        <td>52 Wo. hoch</td>
                        <td v-text="highYear">...</td>
                    </tr>
                    <tr>
                        <td>52 Wo. tief</td>
                        <td v-text="lowYear">...</td>
                    </tr>
                    <tr>
                        <td>52 Wo. perf.</td>
                        <td v-text="returnYear"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        props: [
            'stockId',
            'locale'
        ],

        data() {
            return {
                lookup: '/api/stock/history',

                routeParams: {
                    id: this.stockId,
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
