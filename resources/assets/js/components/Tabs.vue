<template>
    <div>
        <div class="panel-group">

            <div v-for="tab in tabs" class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-paneled" href="#collapseOne">
                        {{ name }}
                    </a>
                </h4>
            </div> <!-- /.panel-heading -->
        </div>

        <div></div>
    </div>
</template>

<script>
    export default {

        name: 'tabs',

        data() {
            return { tabs: [] }
        },

        created() {
            this.tabs = this.$children;
        },

        mounted() {
            console.log('Tabs mounted.');
            console.log(this.$children)
        }
    }
</script>