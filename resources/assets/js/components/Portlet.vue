<template>
    <div class="portlet portlet-boxed" v-cloak>

        <div class="portlet-header">
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
        props: ['title'],
    }
</script>
