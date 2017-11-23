<template>
    <div v-cloak>

        <div class="btn-group btn-group-xs g-mb-20" role="group">
            <button @click.prevent="length=null" class="btn btn-xs btn-outline-secondary"
                    :class="{active: length==null}">Alle</button>
            <button @click="length=1250" class="btn btn-xs btn-outline-secondary"
                    :class="{active: length==1250}">5 Jahre</button>
            <button @click="length=250" class="btn btn-xs btn-outline-secondary"
                    :class="{active: length==250}">1 Jahr</button>
            <button @click="length=125" class="btn btn-xs btn-outline-secondary"
                    :class="{active: length==125}">6 Monate</button>
            <button @click="length=20" class="btn btn-xs btn-outline-secondary"
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

        props: [
            'exchanges',
            'history'
        ],

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
                        labels: this.dateColumn,

                        datasets: [{
                            label: 'Value',
                            data: this.priceColumn,
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
            },

            column(name) {
                return this.history.columns.findIndex((element) => (element === name));
            }
        },

        computed: {
            priceColumn() {
                return _.zip.apply(_, this.timeSeries)[this.column('Close')];
            },

            dateColumn() {
                let dates = _.zip.apply(_, this.timeSeries)[this.column('Date')];
                let copy = [];

                dates.forEach( (element) => {
                    copy.push((new Date(element)).toLocaleDateString());
                });

                return copy;
            },

            timeSeries() {
                return _.reverse(_.take(this.history.data, this.length));
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