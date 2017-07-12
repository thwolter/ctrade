<template>
    <div>
        <h5>show a graph</h5>
        <button @click="draw">Draw</button>
        <canvas id="positions-chart"></canvas>
    </div>
</template>

<script>
    import Chart from 'chart.js';

    export default {

        data() {
            return {
                chartData: {
                    datasets: [{
                        data: [10, 20, 30],

                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)'
                        ]
                    }],

                    // These labels appear in the legend and in the tooltips when hovering different arcs
                    labels: [
                        'Red',
                        'Yellow',
                        'Blue'
                    ]
                },

                options: {}
            }
        },

        methods: {
            
            doDraw() {
                this.draw();
            },
            
            draw() {
                
                var ctx = document.getElementById("positions-chart");

                new Chart(ctx, {
                    type: 'doughnut',
                    data: this.chartData,
                    options: this.options
                });
            }
        },
        
        mounted() {
          this.draw();
        },

        /*created() {
            axios.get('/api/portfolio/positions', {
                params: { id: 1 }})
                .then(data => {

                })
        }*/
    }
</script>