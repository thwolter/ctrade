<template>
    <div class="d-flex justify-content-center">
        <div class="g-width-600">
            <form class="mx-auto w-100 g-pa-20">
                <div class="form-group g-mb-20 g-max-width-570">

                    <!-- Query Input -->
                    <div class="input-group u-shadow-v25 rounded">
                        <input v-model="query"
                               class="form-control form-control-md g-brd-white g-font-size-16 border-right-0 pr-0 g-py-15"
                               type="text"
                               placeholder="Welche Aktie möchtest du hinzufügen?"
                               @keyup="onKeyup">

                        <div class="input-group-addon d-flex align-items-center g-bg-white g-brd-white g-color-gray-light-v1 g-pa-2">
                            <div class="g-font-size-16 g-py-15 g-px-20">
                                <i class="icon-magnifier g-pos-rel g-top-1"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Search Results -->
                    <div v-if="hasResult"
                         class="g-bg-white sticky-top u-shadow-v25 g-bg-lightblue-opacity-0_1 g-px-20 g-pt-10">

                        <table class="table table-hover table-responsive u-table--v1">
                            <tbody>
                                <tr v-for="(item, index) in results"
                                    @click.prevent="onClick(item.base, item.slug)"
                                    style="cursor: pointer"
                                    class="g-bg-primary-opacity-0_2--hover">
                                    <td class="font-weight-bold border-0">{{ item.name }}</td>
                                    <td class="g-color-orange border-0">{{ item.industry }}</td>
                                    <td class="g-color-orange border-0">{{ item.isin }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <p>Suche Aktien der Börsen XETRA und Suttgart.</p>

            </form>
        </div>
    </div>
</template>


<script>
    export default {

        props: {
            portfolio: {
                type: Object,
                required: true
            },
            route: {
                type: String,
                required: true
            }
        },


        data() {
            return {
                searchRoute: '/api/search',

                query: null,
                timeout: null,

                results: [],

                form: new Form({
                    instrumentType: this.instrumentType,
                    instrumentId: null,
                })
            }
        },

        methods: {
            onKeyup() {
                let self = this;
                clearTimeout(this.timeout);

                this.timeout = setTimeout(function () {
                    if (self.query !== '') {
                        self.search(self.query);
                    } else {
                        self.reset();
                    }
                }, 500);
            },

            search(query) {
                axios.get(this.searchRoute, {
                        params: {
                            query: this.query
                        }
                    })
                    .then(data => {
                        this.results = data.data;
                    });
            },

            onClick(type, slug) {
                window.location = this.route
                    .replace('%entity%', type)
                    .replace('%instrument%', slug);
            },

            reset() {
                this.results = [];
            },

            join(industry, sector) {
                let sep = (industry && sector) ? ' | ' : '';
                return _.join([industry, sector], sep);
            }
        },

        computed: {
            hasResult() {
                return this.results.length;
            }
        }
    }
</script>