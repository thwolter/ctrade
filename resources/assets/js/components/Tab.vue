<template>
    <div>
        <div>
            <div class="panel-body">

                <slot></slot>

            </div>
        </div>

    </div>
</template>

<script>
    export default {

        name: 'tab',

        props: {
            name: { required: true },
            selected: { default: false}
        },

        created() {
            console.log('Tab created')
        },

        mounted() {
            console.log('Tab mounted.')
        }
    }
</script>