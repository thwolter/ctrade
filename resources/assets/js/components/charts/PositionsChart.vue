<template>
    <div v-cloak>

        <!-- Spinner -->
        <div v-if="showSpinner">
            <spinner class="spinner-overlay" :height="this.height"></spinner>
        </div>

        <div class="col-xs-5">
            <canvas ref="canvas"></canvas>
        </div>

        <div v-html="legend" class="col-xs-6 col-xs-offset-1">
        </div>

    </div>
</template>

<script>
    import chart from './ApiChart.vue';

    export default {

        extends: chart,

        props: ['pid'],

        data() {
            return {
                route: '/api/portfolio/assets',

                type: 'doughnut',
                maxSegments: 5,
            }
        },

        methods: {

            assign(data) {
                var segments = this.segments(data);

                this.data = {
                    datasets: [{
                        data: segments.values,
                        backgroundColor: this.backgroundColor
                    }],

                    labels: segments.labels
                };

                this.options = {
                    legend: {
                        display: false,
                        position: 'top'
                    }
                };
            },

            segments(data)  {
                const items = data.assets;
                let share = [];
                let labels = [];

                let i = 0;
                let sum = 0;

                let n = Object.keys(items).length;

                while (i < Math.min(n, this.maxSegments)) {
                    let item = items[i];

                    share[i] = (100 * item.share).toFixed(0);
                    labels[i] = item.name;

                    sum = +item.share;
                    i++;
                }

                if (n > this.segements) {
                    share[i] = data.total - sum;
                    labels[i] = 'Andere' + share[i];
                }
                return {values: share, labels: labels};
            }
        }
    }
</script>

<style>

    @media (min-width: 992px) {
        .chart-container {
            height: 257px;
        }
    }

    @media (min-width: 1200px) {
        .chart-container {
            height: 315px;
        }
    }
    .chart-container {
        padding: 0 20px;
    }

    .chart-legend {

    }

    .chart-legend span {
        width: 10px;
        height: 10px;
        display: inline-block;
        margin-right: 10px;
    }

    .chart-legend li {
        list-style-type: none;
        text-indent: -20px;
    }
</style>
