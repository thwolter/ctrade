<template>
    <div v-cloak>

        <!-- Spinner -->
        <div v-if="showSpinner">
            <spinner class="spinner-overlay" :height="this.height"></spinner>
        </div>

        <div>
            <canvas ref="canvas"></canvas>
        </div>

    </div>
</template>

<script>
    import Chart from 'chart.js';

    export default Vue.extend({

        props: ['pid', 'height'],

        data() {
            return {
                showSpinner: true,

                type: 'doughnut',
                data: null,
                options: null,
                legend: null,

                backgroundColor: Colors.standard(),

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
                        this.showSpinner = false;
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
            this.fetch();
        },
    })
</script>

