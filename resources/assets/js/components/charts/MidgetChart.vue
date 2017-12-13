
<script>
    // import chart from './ApiChart.vue'

    export default {

        props: {
            values: {
                type: Object,
                required: true
            },
        },

        // extends: chart,

        data() {
            return {
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