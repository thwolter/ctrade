<template>
    <input type="text" @keyup="updateValue">
</template>

<script>
    import Cleave from 'cleave.js';

    export default {

        props: ['value', 'options'],

        mounted() {
            this.cleave = new Cleave(this.$el, this.options)
        },

        destroyed() {
            this.cleave.destroy()
        },

        watch: {
            value: 'updateInput'
        },

        methods: {
            updateValue() {
                let val = this.cleave.getRawValue();
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