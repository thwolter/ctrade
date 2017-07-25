<template>
    <div v-cloak>

        <!-- Spinner -->
        <div v-if="showSpinner">
            <spinner class="spinner-overlay"></spinner>
        </div>

        <div class="chart-canvas col-xs-7">
            <canvas width="400" id="positions-chart" ref="canvas"></canvas>
        </div>
        <div v-html="legend" class="chart-legend col-xs-5"></div>
    </div>

</template>

<script>
    import Chart from 'chart.js';

    export default {

        props: ['pid'],

        data() {
            return {
                route: '/api/positions',
                segments: 5,

                share: [],
                labels: [],
                legend: '',

                showSpinner: true
            }
        },

        methods: {

            fetch() {
                axios.get(this.route, {params: {id: this.pid}})
                    .then(response => {
                        this.assign(response.data);
                        this.render();
                    })
                    .catch(error => alert(error));
            },

            assign(data) {

                const items = data.positions;

                let i = 0;
                let sum = 0;

                let n = Object.keys(items).length;

                while (i < Math.min(n, this.segments))
                {
                    let item = items[i];

                    this.share[i] = (100 * item.share).toFixed(0);
                    this.labels[i] = item.name;

                    sum =+ item.share;
                    i++;
                }

                if (n > this.segements) {
                    this.share[i] = data.total - sum;
                    this.labels[i] = 'Andere' + this.share[i];
                }
            },
            
            render() {
                
                var ctx = document.getElementById("positions-chart");

                var chart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: this.share,

                            backgroundColor: Colors.standard()
                        }],

                        labels: this.labels
                    },
                    options: {
                        legend: {
                            display: false
                        }
                    }
                });

                this.legend = chart.generateLegend();
            }
        },
        
        mounted() {
            this.fetch()
        },

        updated() {
            this.showSpinner = false;
        }
    }
</script>

<style>
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

    .chart-canvas {
        float: left;
    }
</style>
