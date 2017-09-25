<template>
    <div v-cloak>

        <!-- Spinner -->
        <div v-if="showSpinner">
            <spinner class="spinner-overlay" :height="this.height"></spinner>
        </div>

        <div class="btn-group btn-group-xs" role="group">
            <button @click.prevent="length=null" class="btn btn-default"
                    :class="{active: length==null}">Alle</button>
            <button @click="length=1250" class="btn btn-default"
                    :class="{active: length==1250}">5 Jahre</button>
            <button @click="length=250" class="btn btn-default"
                    :class="{active: length==250}">1 Jahr</button>
            <button @click="length=125" class="btn btn-default"
                    :class="{active: length==125}">6 Monate</button>
            <button @click="length=20" class="btn btn-default"
                    :class="{active: length==20}">1 Monat</button>
        </div>
        <span v-text="exchange" class="pull-right"></span>

        <div class="spacer-md"></div>

        <div>
            <canvas ref="canvas"></canvas>
        </div>

    </div>
</template>

<script>
    import chart from './../Chart.vue'

    export default {

        props: [
            'stockId'
        ],

        extends: chart,

        data() {
            return {
                route: '/api/stock/history',

                routeParams: {
                    id: this.stockId,
                    exchange: null
                },

                history: null,
                exchange: null,
                length: 250,

                type: 'line'
            }
        },

        methods: {

            assign(data) {
                this.history = data.history;
                this.exchange = data.exchanges[0].name;
                this.updateChart();
            },

            updateChart() {
                this.data = {
                    labels: this.dateColumn,

                    datasets: [{
                        label: 'Value',
                        data: this.priceColumn,
                        pointRadius: 0,
                    }]
                };

                this.options = {
                    legend: {
                        display: false
                    },
                    elements: {
                        line: {
                            tension: 0, // disables bezier curves
                        }
                    }
                }
            },

            column(name) {
                return this.history.columns.findIndex((element) => (element === name));
            }
        },

        computed: {
            priceColumn() {
                return _.zip.apply(_, this.timeSeries)[this.column('Close')];
            },

            dateColumn() {
                let dates = _.zip.apply(_, this.timeSeries)[this.column('Date')];
                let copy = [];

                dates.forEach( (element) => {
                    copy.push((new Date(element)).toLocaleDateString());
                });

                return copy;
            },

            timeSeries() {
                return _.reverse(_.take(this.history.data, this.length));
            }
        },

        watch: {
            length() {
                this.updateChart();
                this.render()
            }
        }
    }
</script>