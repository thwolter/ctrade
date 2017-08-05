
<script>
    import chart from './Chart.vue';

    export default {

        extends: chart,

        props: ['pid'],

        data() {
            return {
                route: '/api/portfolio/positions',

                type: 'doughnut',
                segments: 5,

                clsContainer: 'chart-container col-xs-7',
                clsLegend: 'chart-legend col-xs-5'
            }
        },

        methods: {

            assign(data) {

                const items = data.positions;
                let share = [];
                let labels = [];

                let i = 0;
                let sum = 0;

                let n = Object.keys(items).length;

                while (i < Math.min(n, this.segments)) {
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

                this.data = {
                    datasets: [{
                        data: share,
                        backgroundColor: this.backgroundColor
                    }],

                    labels: labels
                };

                this.options = {
                    legend: {
                        display: false
                    }
                }
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
