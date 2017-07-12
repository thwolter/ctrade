<template>
    <div>
        <h5>show a graph</h5>
        <button @click="doDraw">Draw</button>
        <canvas id="positions-chart"></canvas>
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
            }
        },

        methods: {

            fetch() {
                axios.get(this.route, {params: {id: this.pid}})
                    .then(response => {
                        this.assign(response.data);
                        this.render();
                    })
                    .catch(function (error) {
                        console.debug(error);
                    });
            },

            assign(data) {

                const items = data.positions;

                let i = 0;
                let sum = 0;

                let n = Object.keys(items).length;

                while (i < Math.min(n, this.segments))
                {
                    let item = items[i];

                    this.share[i] = item.share;
                    this.labels[i] = item.name + item.total;

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

                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: this.share,

                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)'
                            ]
                        }],

                        labels: this.labels
                    },
                    options: this.options
                });
            }
        },
        
        mounted() {
            this.fetch()
        }
    }
</script>