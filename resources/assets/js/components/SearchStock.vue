<template>
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">Wertpapier hinzufügen</h3>
            </div> <!-- /.modal-header -->

            <div class="modal-body">

                <!-- initiate search dialog -->
                <div v-if="doSearch">
                    <!-- Search input -->
                    <div class="row">
                        <form @submit.prevent="onSubmit">

                            <!-- search form input -->
                            <div class="form-group">
                                <label for="query" class="control-label col-sm-2 col-sm-offset-1">Suchen</label>
                                <div class="col-sm-8">

                                    <input type="text" class="form-control" v-model="query" @keyup="onRefresh"
                                           placeholder="Name, WKN, ISIN, ...">
                                    <span class="help-block">
                                        Suche nach Namen oder Branche
                                    </span>
                                </div>
                            </div>

                        </form>
                    </div> <!-- /.row -->

                    <!-- Search results -->
                    <div v-if="isResult">
                        <table class="table table-striped table-hover positions-table">
                            <thead>
                            <tr>
                                <th>Nr.</th>
                                <th>Name/Sektor</th>
                                <th>ISIN</th>
                                <th>Währung</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr v-for="(item, index) in results">
                                <td class="align-middle"> {{ parseInt(index)+1 }}</td>
                                <td class="align-middle">
                                     <span style="display:block">
                                         <a href="#" @click.prevent="onClickLink(item.slug)">{{ item.name }}</a>
                                     </span>
                                    <span>{{ join(item.industry, item.sector) }}</span>

                                </td>
                                <td>{{ item.isin }}</td>
                                <td>{{ item.currency }}</td>
                            </tr>

                            </tbody>
                        </table>
                    </div>

                    <div v-if="showNoResults">
                        <p>Keine Ergebniss gefunden.</p>
                    </div>
                </div>

            </div> <!-- /.modal-content -->
        </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
</template>

<script>
    export default {

        props: [
            'portfolioId',
            'instrumentType',
            'createRoute',
            'cash'
        ],

        data() {
            return {
                searchRoute: '/api/search',

                query: null,
                results: [],
                error: false,

                doSearch: true,
                instrumentId: null,

                timeout: null,

                form: new Form({
                    instrumentType: this.instrumentType,
                    instrumentId: null,
                }),

                showNoResults: false
            }
        },

        methods: {
            onSubmit() {
                axios.get(this.searchRoute, {
                    params: {
                        query: this.query,
                        instrumentType: this.instrumentType
                    }
                })
                    .then(data => this.assign(data.data));
            },

            onRefresh() {
                let self = this;
                clearTimeout(this.timeout);

                this.timeout = setTimeout(function () {
                    this.error = false;
                    if (this.query === '') {
                        self.assign([]);
                    } else {
                        self.onSubmit();
                    }
                }, 500);
            },

            onClickLink(slug) {
                let instrumentType = this.instrumentType.substr(this.instrumentType.lastIndexOf('\\') + 1).toLowerCase();
                window.location = this.createRoute+'/'+instrumentType+'/'+slug;
            },

            assign(data) {
                this.results = data;
                this.showNoResults = (this.results.length === 0) && this.query;
            },

            reset() {
                this.query = null;
                this.results = [];
                this.doSearch = true;
            },

            join(industry, sector) {
                let sep = (industry && sector) ? ' | ' : '';
                return _.join([industry, sector], sep);
            }
        },

        computed: {
            isResult() {
                return (this.results.length !== 0)
            }
        },

        created() {
            Event.listen('resetSearch', () => {
                this.reset();
            });

            Event.listen('backToSearch', () => {
                this.doSearch = true;
            })
        }
    }
</script>