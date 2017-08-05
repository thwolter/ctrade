<template>
    <div v-cloak>

        <!-- Spinner -->
        <div v-if="showSpinner">
            <spinner class="spinner-overlay"></spinner>
        </div>

        <div :class="clsContainer">
            <canvas ref="canvas"></canvas>
        </div>
        <div v-html="legend" :class="clsLegend"></div>
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

                clsContainer: null,
                clsLegend: 'display-hidden',

                routeParams: {
                    id: this.pid
                }
            }
        },

        methods: {
            fetch() {
                axios.get(this.route, {params: this.routeParams})
                    .then(response => {
                        this.assign(response.data);
                        this.render();
                    })
                    .catch(error => alert(error));
            },

            render() {
                let ctx = this.$refs.canvas.getContext('2d');

                let chart = new Chart(ctx, {
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
    .display-hidden {
        display: none;
    }
</style>

