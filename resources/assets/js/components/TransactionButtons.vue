<script>
    export default {

        data() {
            return {
                show: false,
                direction: null
            }
        },

        mounted() {
            console.log('Component mounted.')
        },

        methods: {
            makeDeposit() {
                this.setFocus('deposit');
            },

            makeWithdrawal() {
                this.setFocus('withdrawal');
            },

            setFocus(direction) {
                if (this.direction !== direction) {
                    this.show = true;
                    this.direction = direction;
                } else {
                    this.show = false;
                    this.direction = null;
                }
            }
        }
    }
</script>