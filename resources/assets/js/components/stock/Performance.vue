<template>
    <div v-cloak>

       <!-- <select v-model="exchange" class="form-control">
            <option v-for="type in management" :value="type.value">
                {{ type.text }}
            </option>
        </select>-->

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
                    <td>52 Wo. performance</td>
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
                    count: 1
                },

                data: null,
                stocks: null,
                exchanges: null
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
                    })
            },

        },

        mounted() {
            this.fetch();
        }
    }
</script>
