<template>
    <div v-cloak>

    </div>
</template>

<script>
    export default {

        props: [
            'stockId'
        ],

        data() {
            return {
                lookup: '/api/stock/history',

                routeParams: {
                    id: this.stockId,
                    count: 1
                },

                data: null
            }
        },

        methods: {
            fetch() {
                axios.get(this.lookup, {
                    params: this.routeParams
                })
                    .then(data => {
                        this.data = data.data;
                    })
            },

        },

        mounted() {
            this.fetch();
        }
    }
</script>
