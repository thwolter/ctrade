<template>
    <div v-cloak>

        <!-- Spinner -->
        <div v-if="showSpinner">
            <spinner class="spinner-overlay"></spinner>
        </div>

        <div class="chart-container">
            <canvas id="chart" ref="canvas"></canvas>
        </div>
        <div v-html="legend" class="chart-legend"></div>
    </div>
</template>

<script>
    import Chart from 'chart.js';

    export default Vue.extend({

        props: ['pid'],

        data() {
            return {
                showSpinner: true,

                legend: null,

                type: 'doughnut',
                data: null,
                options: null,

                backgroundColor: Colors.standard(),
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

            render() {
                var ctx = document.getElementById("chart");

                var chart = new Chart(ctx, {
                    type: this.type,
                    data: this.data,
                    options: this.options,
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
    })
</script>

<style>
    .chart-container {
        padding: 0 20px;
    }
</style>