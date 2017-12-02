<template>
    <div class="u-header u-header--sticky-bottom">
        <div class="alert fade show g-bg-gray-light-v5 rounded-0" role="alert">
            <button type="button" class="close u-alert-close--light g-ml-10 g-mt-1" data-dismiss="alert"
                    aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>

            <div class="media">
                <div class="d-flex g-mr-10">
                    bild
                </div>
                <div class="media-body">
                    <p class="m-0"><strong>Htmlstream</strong> released a new update.</p>
                    <span class="g-font-size-12 g-color-gray">2 hours ago</span>
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
            }
        },

        data() {
            return {
                ratio: 0
            }
        },

        computed: {
            show() {
                return this.ratio > 0;
            }
        },


        mounted() {
            Echo.private('App.Entities.User.' + this.userId)
                .notification((data) => {
                   /* this.notifications.push({
                        'title': data.title
                    });*/
                });
        }
    };

</script>
