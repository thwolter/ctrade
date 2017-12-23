<template>
    <div v-cloak>

        <div class="btn-group btn-group-xs g-mb-20" role="group">
            <button @click.prevent="length=null" class="btn btn-xs u-btn-outline-primary"
                    :class="{active: length==null}">Alle</button>
            <button @click="length=1250" class="btn btn-xs u-btn-outline-primary"
                    :class="{active: length==1250}">5 Jahre</button>
            <button @click="length=250" class="btn btn-xs u-btn-outline-primary"
                    :class="{active: length==250}">1 Jahr</button>
            <button @click="length=125" class="btn btn-xs u-btn-outline-primary"
                    :class="{active: length==125}">6 Monate</button>
            <button @click="length=20" class="btn btn-xs u-btn-outline-primary"
                    :class="{active: length==20}">1 Monat</button>
        </div>
        <span v-text="exchange" class="pull-right"></span>

        <div>
            <canvas ref="canvas"></canvas>
        </div>

    </div>
</template>

<script>

    export default {

        props: {
            exchanges: {
                type: Array,
                required: true
            },
            history: {
                type: Object,
                required: true
            }
        },

        data() {
            return {
                length: 250,
                type: 'line',
                exchange: null,
            }
        },

        methods: {

            render() {
                let ctx = this.$refs.canvas.getContext('2d');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: _.keys(this.history.data),

                        datasets: [{
                            label: 'Value',
                            data: _.values(this.history.data),
                            pointRadius: 0,
                        }]
                    },
                    options: {
                        legend: {
                            display: false
                        },
                        elements: {
                            line: {
                                tension: 0, // disables bezier curves
                            }
                        }
                    },
                });
            }
        },

        watch: {
            length() {
                this.render();
            }
        },

        mounted() {
            this.render();
        }
    }
</script>