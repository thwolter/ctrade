<template>
    <div v-cloak>

        <!-- Spinner -->
        <div v-if="showSpinner">
            <spinner class="spinner-overlay"></spinner>
        </div>

        <div v-if="data">

            <!-- absolute limit -->
            <div v-if="data.absolute" class="progress-stat">

                <div class="progress-stat-label">
                    Absolutes Limit <span class="label-detail">({{ data.absolute.limit.toFixed(2) + ' ' + data.absolute.ccy}})</span>
                </div>

                <div class="progress-stat-value">{{ (data.absolute.quota * 100).toFixed(0) }}%</div>

                <div class="progress progress-striped progress-sm active">
                    <div :class="this.barCls(data.absolute.quota)" role="progressbar"
                         :aria-valuenow="data.absolute.risk"
                         aria-valuemin="0"
                         :aria-valuemax="data.absolute.limit"
                         :style="{width: data.absolute.quota * 100 +'%'}">
                        <span class="sr-only">{{ (data.absolute.quota * 100).toFixed(0) }} Auslastung</span>
                    </div>
                </div> <!-- /.progress -->

            </div>

            <!-- relative limit -->
            <div v-if="data.relative" class="progress-stat">

                <div class="progress-stat-label">
                    Relatives Limit <span class="label-detail">({{ data.relative.limit.toFixed(1) }} % vom Portfoliowert)</span>
                </div>

                <div class="progress-stat-value">{{ (data.relative.quota * 100).toFixed(0) }}%</div>

                <div class="progress progress-striped progress-sm active">
                    <div :class="this.barCls(data.relative.quota)" role="progressbar"
                         :aria-valuenow="data.relative.risk"
                         aria-valuemin="0"
                         :aria-valuemax="data.relative.limit"
                         :style="{width: data.relative.quota * 100 +'%'}">
                        <span class="sr-only">{{ (data.relative.quota * 100).toFixed(0) }} Auslastung</span>
                    </div>
                </div> <!-- /.progress -->

            </div>

            <!-- floor limit -->
            <div v-if="data.floor" class="progress-stat">

                <div class="progress-stat-label">
                    Mindestwert Limit <span class="label-detail">({{ data.floor.limit.toFixed(2) + ' ' + data.floor.ccy}})</span>
                </div>

                <div class="progress-stat-value">{{ (data.floor.quota * 100).toFixed(0) }}%</div>

                <div class="progress progress-striped progress-sm active">
                    <div :class="this.barCls(data.floor.quota)" role="progressbar"
                         :aria-valuenow="data.floor.risk"
                         aria-valuemin="0"
                         :aria-valuemax="data.floor.limit"
                         :style="{width: data.floor.quota * 100 +'%'}">
                        <span class="sr-only">{{ (data.floor.quota * 100).toFixed(0) }} Auslastung</span>
                    </div>
                </div> <!-- /.progress -->

            </div>

            <!-- target limit -->
            <div v-if="data.target" class="progress-stat">

                <div class="progress-stat-label">
                    Zielwert Limit <span class="label-detail">({{ data.target.limit.toFixed(2) + ' ' + data.target.ccy}})</span>
                </div>

                <div class="progress-stat-value">{{ (data.target.quota * 100).toFixed(0) }}%</div>

                <div class="progress progress-striped progress-sm active">
                    <div :class="this.barCls(data.target.quota)" role="progressbar"
                         :aria-valuenow="data.target.risk"
                         aria-valuemin="0"
                         :aria-valuemax="data.target.limit"
                         :style="{width: data.target.quota * 100 +'%'}">
                        <span class="sr-only">{{ (data.target.quota * 100).toFixed(0) }} Auslastung</span>
                    </div>
                </div> <!-- /.progress -->

            </div>

        </div>
    </div>

</template>

<script>
    export default {

        props: ['pid', 'conf', 'period', 'reference'],

        data() {
            return {
                showSpinner: true,
                data: null,

                route: '/api/portfolio/utilisation',

                routeParams: {
                    id: this.pid,
                    conf: this.conf,
                    period: this.period,
                    reference: this.reference
                }
            }
        },

        methods: {

            fetch() {
                axios.get(this.route, {params: this.routeParams})
                    .then(response => {
                        this.assign(response.data);
                    })
                    .catch(error => alert(error));
            },

            assign(data) {
                this.data = data;
            },

            barCls(quota) {
                let base = 'progress-bar progress-bar-';
                if (quota <= 0.8) { return base + 'success' }
                if (quota > 0.8 && quota <= 0.95) { return base + 'warning' }
                if (quota > 0.95) { return base + 'danger' }
            }
        },

        mounted() {
            this.fetch()
        },

        updated() {
            this.showSpinner = false;
        }
    }
</script>

<style>
    .progress-stat-label {
        width: 70%;
    }
    .progress-stat-value {
        width: 30%;
    }
    .label-detail {
        text-transform: none;
    }
</style>