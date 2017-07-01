<template>
    <div class="icon-stat">

        <div class="row">
            <div class="col-xs-8 text-left">
                <span class="icon-stat-label">{{ label }}</span> <!-- /.icon-stat-label -->
                <span class="icon-stat-value">
                    <slot></slot>
                </span> <!-- /.icon-stat-value -->
            </div><!-- /.col-xs-8 -->

            <div class="col-xs-4 text-center">
                <i :class="iconClass"></i> <!-- /.icon-stat-visual -->
            </div><!-- /.col-xs-4 -->
        </div><!-- /.row -->

        <div class="icon-stat-footer">
            <i class="fa fa-clock-o"></i> Updated Now
        </div>

    </div> <!-- /.icon-stat -->

</template>

<script>
    export default {
        data() {
            return {
                iconClass: 'fa icon-stat-visual '
            }
        },
        props: {
            label: { required: true },
            icon: { default: 'fa-dollar bg-primary'}
        },
        created() {
            this.iconClass = this.iconClass + this.icon
        }
    }
</script>