<template>
    <vue-numeric
            :currency="currency"
            min=0
            placeholder="only number allowed"
            separator="."
            :minus="false"
            :precision="2"
            currency-symbol-position="suffix"
            v-model="price"
            @input="setValue">
    </vue-numeric>
</template>

<script>
    import VueNumeric from 'vue-numeric'

    export default {

        inherit: true,
        props: ['currency', 'value'],

        components: {
            VueNumeric
        },

        data() {
            return {
                price: null,
                symbol: 'EUR'
            }
        },

        methods: {
            setValue() {
                Event.fire('set-value', this.price);
            }
        }
    }
</script>