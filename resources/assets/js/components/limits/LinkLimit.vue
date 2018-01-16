<template>
   <a :class="cls" href="#" @click.prevent="fireEvent" role="button">
       <slot></slot>
   </a>
</template>

<script>

    export default {

        props: {
            cls: {
                type: String,
                required: true
            },
            event: {
                type: String,
                required: true
            },
            id: {
                type: Number,
                required: true
            }
        },

        methods: {

            fireEvent() {
               Event.fire(this.event, this.id)
            }
        }
    }
</script>
