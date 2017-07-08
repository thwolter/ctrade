<template>
    <input type="text" @keyup="updateValue">
</template>

<script>
    export default {

        props: ['value', 'options'],

        mounted() {
            this.cleave = new Cleave(this.$el, this.options)
            this.cleave.setRawValue(10)
        },

        destroyed() {
            this.cleave.destroy()
        },
        watch: {
            value: 'updateInput'
        },
        methods: {
            updateValue() {
                var val = this.cleave.getRawValue()
                if (val !== this.value) {
                    this.$emit('input', val)
                }
            },
            updateInput() {
                this.cleave.setRawValue(this.value);
                Event.fire('rawValueChanged', this.value);
            }
        }
    }
</script>