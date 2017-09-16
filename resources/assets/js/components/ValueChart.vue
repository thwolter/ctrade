
<script>
    import chart from './Chart.vue'

    export default {

        props: [
            'date',
            'conf',
            'count'
        ],

        extends: chart,

        data() {
            return {
                route: '/api/portfolio/keyFigures',

                routeParams: {
                    id: this.pid,
                    date: this.date,
                    conf: this.conf,
                    count: this.count
                },

                type: 'line'
            }
        },

        methods: {

            assign(data) {
                this.data = {
                    datasets: [
                        {
                            label: 'Value',
                            data: _.toArray(data.values),
                            backgroundColor: 'rgba(3, 78, 123, 0.3)'
                        },
                        {
                            label: 'Risk',
                            data: _.toArray(data.risk),
                            backgroundColor: 'rgba(3, 78, 123, 0.3)'
                        }
                    ],

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