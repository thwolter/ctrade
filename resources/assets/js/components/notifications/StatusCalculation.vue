<template>
    <div v-show="show" class="u-header u-header--sticky-bottom">
        <div class="alert fade show g-bg-lightblue-radialgradient-ellipse rounded-0" role="alert">
            <button type="button" class="close u-alert-close--light g-ml-10 g-mt-1" data-dismiss="alert"
                    aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>

            <div v-if="calculating" class="media">
                <div class="d-flex g-mr-10">
                    <span class="u-icon-v1 g-mr-20 g-mb-20">
                        <i class="fa fa-refresh spin"></i>
                    </span>
                </div>
                <div class="media-body">
                    <div  class="row">
                        <div class="col-lg-3 col-md-5 col-sm-12">
                            <p class="m-0"><strong>Bitte habe etwas Geduld.</strong></p>
                            <p class="m-0">Wir berechnen gerade dein Portfolio.</p>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <span class="g-font-size-12 g-color-gray">Fortschritt</span>
                            <div class="js-hr-progress-bar progress rounded-0 g-mb-20">
                                <div class="js-hr-progress-bar-indicator progress-bar g-nowrap g-bg-blue-lineargradient-v4" role="progressbar"
                                     :style="'width: ' + ratio * 100 + '%;'" :aria-valuenow="ratio"
                                     aria-valuemin="0" aria-valuemax="100">{{ Math.ceil(ratio * 100) }}%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else class="media">
                <div class="d-flex g-mr-10">
                    <span class="u-icon-v1 g-mr-20 g-mb-20">
                        <i class="fa fa-thumbs-o-up shake"></i>
                    </span>
                </div>
                <div class="d-md-flex justify-content-between media-body">
                    <div>
                        <p class="m-0"><strong>Dein Portfolio wurde neu berechnet!</strong></p>
                        <p class="m-0">Bitte lade die Seite neu umd die aktuellen Werte anzuzeigen.</p>
                    </div>
                    <div class="g-mt-10">
                        <a :href="currentRoute" class="btn u-btn-blue">Neu laden</a>
                    </div>

                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {

        props: {
            userId: {
                type: Number,
                required: true
            },

            portfolioId: {
                type: Number,
                required: true
            },

            status: {
                type: Object,
                required: true
            },

            currentRoute: {
                type: String,
                required: true
            }
        },

        data() {
            return {
                risk: this.status.risk,
                value: this.status.value,

                notification: null
            }
        },

        methods: {
            asNumber(value) {
                return value == null ? 0 : value;
            }
        },

        computed: {

            total() {
                return (this.risk.total || 0) + (this.value.total || 0);
            },

            remainder() {
                return (this.risk.remainder || 0) + (this.value.remainder || 0);
            },

            ratio() {
                if (this.total > 0) {
                    return 1 - this.remainder / this.total;
                } else {
                    return 1;
                }
            },

            nextRatio() {
                return this.total > 0 ? Math.min(1, 1 - (this.remainder - 1) / this.total) : 1;
            },

            show() {
                return this.total > 0;
            },

            calculating() {
                return this.ratio < 1;
            }
        },


        mounted() {
            Echo.private('App.Entities.User.' + this.userId)
                .notification((data) => {

                    console.log('notification received for portfolio '+ data.portfolio_id);
                    this.notification = data;

                    if (data.portfolio_id === this.portfolioId) {
                        if (data.metric === 'risk') {
                            this.risk.total = data.total;
                            this.risk.remainder = data.remainder;
                        }
                        if (data.metric === 'value') {
                            this.value.total = data.total;
                            this.value.remainder = data.remainder;
                        }
                    }
                });
        }
    };

</script>
