
<script>
    import chart from './Chart.vue'

    export default {

        extends: chart,

        data() {
            return {
                route: '/api/valueHistory',
                type: 'line',
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
                    }
                }
            }
        }
    }
</script>