<template>
    <div class="portlet portlet-plain" v-cloak>

        <div v-if="showHeader" class="portlet-header">
            <h3 class="portlet-title"><u>{{ title }}</u></h3>
        </div>

        <div class="portlet-body">
            <div class="row">

                <slot></slot>

            </div>
        </div>
    </div>

</template>

<script>
    export default {
        props: [
            'title',
        ],

        computed: {
            showHeader() {
                return typeof this.title !== 'undefined';
            }
        }
    }
</script>
