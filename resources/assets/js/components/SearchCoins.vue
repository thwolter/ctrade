<template>
    <div class="d-flex justify-content-center">
        <div class="g-width-600">
            <form class="g-brd-around g-brd-gray-light-v4 g-pa-30 g-mb-30">
                <div class="row justify-content-center g-mb-30">

                    <!-- Input -->
                    <div class="col-8">
                        <!-- Query Input -->
                        <label class="g-mb-10" for="inputGroup1_1">Add coin</label>
                        <div class="input-group g-brd-primary--focus">
                            <input v-model="query"
                                   class="form-control form-control-md rounded-0 pr-0"
                                   type="text"
                                   placeholder="Search ..."
                                   @keyup="onKeyup">
                        </div>

                        <!-- Search Results -->
                        <div v-if="hasResult" class="g-brd-none g-color-black g-py-12">
                            <table class="table table-hover u-table--v1">
                                <tbody>
                                <tr v-for="(item, index) in results"
                                    @click.prevent="onClick(item.base, item.slug)"
                                    style="cursor: pointer"
                                    class="g-bg-primary-opacity-0_2--hover">
                                    <td class="border-0">{{ item.name }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Amount -->
                    <div class="col-4">
                        <label class="g-mb-10" for="inputGroup1_1">Amount</label>
                        <div class="input-group g-brd-primary--focus">
                            <input v-model="query"
                                   class="form-control form-control-md rounded-0 pr-0"
                                   type="text"
                                   placeholder="787"
                                   @keyup="onKeyup">
                        </div>
                    </div>

                </div>
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
            coinlist: {
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
        },

        computed: {
            hasResult() {
                return this.results.length;
            }
        }
    }
</script>