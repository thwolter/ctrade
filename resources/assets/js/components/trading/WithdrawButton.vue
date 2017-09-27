<template>
    <div v-cloak>
        <a href="#" class="btn btn-default" @click="doSell">Geld auszahlen</a>
    </div>
</template>

<script>
    import BuySellBtn from './BuySellBtn.vue';

    export default {

        extends: BuySellBtn
    }
</script>