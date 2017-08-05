
<script>
    import chart from './Chart.vue'

    export default {

        extends: chart,

        data() {
            return {
                route: '/api/portfolio/value',
                type: 'line'
            }
        },

        methods: {

            assign(data) {
                this.data = {
                    datasets: [{
                        data: _.toArray(data.values),
                        backgroundColor: 'rgba(3, 78, 123, 0.3)'
                    }],

                    labels: Object.keys(data.values)
                };

                this.options = {
                    legend: {
                        display: false
                    },
                    //responsive: false,
                    //maintainAspectRatio: false,
                }
            }
        }
    }
</script>