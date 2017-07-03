<script>
    export default {
        props: ['price'],
        data() {
            return {
                show: false,
                direction: null,
                value: null
            }
        },

        mounted() {
            console.log('Component mounted.')
        },

        created() {
            Event.listen('set-value', function(value) {
                this.value = value;
                console.log(this);
            })
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