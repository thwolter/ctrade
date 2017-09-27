<template>
    <div>
        <a href="#" class="btn btn-default" @click="doBuy">Geld einzahlen</a>
    </div>
</template>

<script>
    import BuySellBtn from './BuySellBtn.vue';

    export default {

        extends: BuySellBtn
    }
</script>