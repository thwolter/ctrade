<template>
    <div v-cloak>

      <select v-model="exchange" class="form-control">
            <option v-for="exchange in exchanges" :value="exchange.code">
                {{ exchange.name }}
            </option>
        </select>

        <table>
            <tbody>
                <tr>
                    <td>Kurs</td>
                    <td>...</td>
                </tr>
                <tr>
                    <td>Kursdatum</td>
                    <td>...</td>
                </tr>
                <tr>
                    <td>Vortag</td>
                    <td>...</td>
                </tr>
                <tr>
                    <td>Volume</td>
                    <td>...</td>
                </tr>
                <tr>
                    <td>High/Low</td>
                    <td>...</td>
                </tr> <tr>
                    <td>52 Wo. hoch</td>
                    <td>...</td>
                </tr> <tr>
                    <td>52 Wo. tief</td>
                    <td>...</td>
                </tr>
                <tr>
                    <td>52 Wo. perf.</td>
                    <td>...</td>
                </tr>
            </tbody>
        </table>
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
                    date: null,
                    count: 1,
                    exchange: 0
                },

                stocks: null,
                exchanges: null,
                exchange: null
            }
        },

        methods: {
            fetch() {
                axios.get(this.lookup, {
                    params: this.routeParams
                })
                    .then(data => {
                        this.stocks = data.data.stocks;
                        this.exchanges = data.data.exchanges;
                        this.exchange = this.exchanges[0].code;
                    })
            }
        },

        watch: {
            exchange: function(value) {
                this.routeParams.exchange = value;
                this.fetch();
            }
        },

        mounted() {
            this.fetch();
        }
    }
</script>
