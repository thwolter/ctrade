<template>
    <div>
        <h5>show a graph</h5>
        <button @click="draw">Draw</button>
        <canvas id="chart"></canvas>
    </div>
</template>

<script>
    import Chart from 'chart.js';

    export default {

        methods: {
            
            doDraw() {
                this.draw();
            },
            
            draw() {
                
                var ctx = document.getElementById("chart");

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
                        datasets: [{
                            label: '# of Votes',
                            data: [12, 19, 3, 5, 2, 3],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });
            }
        },
        
        mounted() {
          this.draw();
        },

        created() {
            axios.get('/api/portfolio/history/value', {
                params: {
                    id: 1,
                    symbol: 'x'
                }
            })
        }
    }
</script>