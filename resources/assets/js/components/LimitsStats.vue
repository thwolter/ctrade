<template>
    <div>

        <div class="progress-stat">

            <div class="progress-stat-label">Absolut Limit</div>

            <div class="progress-stat-value">77.7%</div>

            <div class="progress progress-striped progress-sm active">
                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="77" aria-valuemin="0" aria-valuemax="100" style="width: 77%">
                    <span class="sr-only">77.74% Visit Rate</span>
                </div>
            </div> <!-- /.progress -->

        </div> <!-- /.progress-stat -->

    </div>

</template>

<script>
    export default {

        props: ['pid'],

        data() {
            return {
                route: '/api/portfolio/positions'
            }
        },

        mounted() {
            console.log('Component mounted.')
        }
    }
</script>