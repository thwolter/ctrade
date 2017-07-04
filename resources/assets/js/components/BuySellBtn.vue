<script>
    export default {

        data() {
            return {
                show: false,
                direction: null,
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
                if (this.direction !== direction) {
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
                   Event.fire('onBuy')
               } else {
                   Event.fire('onSell')
               }
            }
        },

        computed: {
            buy() {
                return (this.direction === 'buy')
            },
            sell() {
                return (this.direction === 'sell')
            }
        }
    }
</script>