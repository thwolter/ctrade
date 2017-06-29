<template>
    <vue-numeric 
        :currency="currency"
        min=0
        placeholder="only number allowed"
        separator="." 
        :minus="false" 
        :precision="2"
        currency-symbol-position="suffix"
        v-model="price">
    </vue-numeric>
</template>
 
<script>
import VueNumeric from 'vue-numeric'
 
export default {
 
  inherit: true,
 
    name: 'App',
 
    components: {
        VueNumeric
    },
 
    data: () => ({
        price: '',
        symbol: 'EUR'
    }),
}
</script>