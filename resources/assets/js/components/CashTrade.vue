

<script>
    export default {
        props: ['pid'],

        data() {
            return {
                show: false
            }
        },

        created() {
            Event.listen('make-deposit', () => { this.show = ! this.show})
        }
    }
</script>