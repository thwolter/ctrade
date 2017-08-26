<template>
    <div class="row buy-sell-icons text-center">
        <div class="col-md-2 col-md-push-2">
            <a href="#" class="btn-link" @click="doBuy">
                <i class="fa fa-plus-square buy-icon" aria-hidden="true"></i>
            </a>
        </div>
        <div>
            <a href="#" class="btn-link" @click="doSell">
                <i class="fa fa-minus-square sell-icon" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</template>

<script>
    export default {

        props: ['id', 'eventBuy', 'eventSell', 'toggle'],

        data() {
            return {
                show: false,
                direction: null,
                event: {
                    buy: 'onBuy',
                    sell: 'onSell'
                },
                doToggle: true
            }
        },

        methods: {
            doBuy() {
                this.setFocus('buy');
            },

            doSell() {
                this.setFocus('sell');
            },

            setFocus(direction) {
                if (this.direction !== direction  || !this.doToggle) {
                    this.show = true;
                    this.direction = direction;
                    this.fireEvent();
                } else {
                    this.show = false;
                    this.direction = null;
                }
            },

            fireEvent() {
               if (this.buy) {
                   Event.fire(this.event.buy, this.id)
               } else {
                   Event.fire(this.event.sell, this.id)
               }
            }
        },

        computed: {
            buy() {
                return (this.direction === 'buy');
                this.$nextTick();
            },
            sell() {
                return (this.direction === 'sell');
                this.$nextTick();
            }
        },

        mounted() {
            if (this.eventBuy) { this.event.buy = this.eventBuy; }
            if (this.eventSell) { this.event.sell = this.eventSell; }

            if (this.toggle === 'false') { this.doToggle = false; }
        }
    }
</script>