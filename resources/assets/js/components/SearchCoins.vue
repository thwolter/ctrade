<template>
    <div class="d-flex justify-content-center">
        <div class="g-width-600">
            <form @submit.prevent="onSubmit" class="">
                <div class="row justify-content-center g-height-300 g-mb-30">

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
                                <tr v-for="(item) in results.slice(0, maxResults)"
                                    @click.prevent="onClick(item.Symbol, item.FullName)"
                                    style="cursor: pointer"
                                    class="g-bg-primary-opacity-0_2--hover">
                                    <td class="border-0">{{ item.FullName }}</td>
                                </tr>
                                <tr>
                                    <td v-if="exceedMax" class="border-0">...</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Amount -->
                    <div class="col-4">
                        <label class="g-mb-10" for="inputGroup1_1">Amount</label>
                        <div class="input-group g-brd-primary--focus">
                            <input v-model="form.amount"
                                   class="form-control form-control-md rounded-0 pr-0"
                                   type="text"
                                   placeholder="787"
                                   @keyup="onKeyup">
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn u-btn-black pull-right" :disabled="!validCoin">
                    Save
                </button>

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
                rquired: true
            },
            maxResults: {
                type: Number,
                required: false,
                default: 5
            },
            delay: {
                type: Number,
                required: false,
                default: 300
            }
        },


        data() {
            return {

                query: '',
                timeout: null,
                submitting: false,

                results: {},

                form: new Form({
                    symbol: '',
                    amount: 0,
                    user: this.portfolio.user_id,
                    portfolio: this.portfolio.slug
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
                }, this.delay);
            },

            search(query) {
                query = _.toLower(query);

                let filtered = _.filter(this.coinlist, function(coin) {
                    return _.includes(_.toLower(coin.FullName), query);
                });

                if (_.size(filtered) > 0 ) {
                    this.results = filtered;
                }

                if (_.size(filtered) === 1 && query === filtered[0].FullName) {
                    this.reset();
                }
            },

            onClick(symbol, fullName) {
                this.query = fullName;
                this.form.symbol = symbol;
                this.reset();
            },

            reset() {
                this.results = {};
            },

            onSubmit() {
                this.submitting = true;

                this.form.post(this.route)
                    .then(data => {
                        window.location = data.redirect;
                    })
                    .catch(data => {
                        alert(data);
                    })
            },
        },

        computed: {
            hasResult() {
                return this.results.length;
            },

            exceedMax() {
                return _.size(this.results) > this.maxResults;
            },

            validCoin() {
                return _.toArray(_.filter(this.coinlist, {FullName: this.query})).length === 1;
            }
        }
    }
</script>