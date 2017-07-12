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

                                    <p v-if="noResult" class="error-text">
                                        Keine Ergebnisse gefunden.
                                    </p>
                                </div>
                            </div>

                            <!-- submit button -->
                            <div class="col-sm-offset-3 col-sm-8">
                                <button class="btn btn-primary">Suchen</button>
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
                                <th>WKN</th>
                                <th>ISIN</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr v-for="(item, index) in results">
                                <td class="align-middle"> {{ parseInt(index)+1 }}</td>
                                <td class="align-middle">
                                     <span style="display:block">
                                         <a href="#" @click.prevent="onClickLink(item.id)">{{ item.name }}</a>
                                     </span>
                                    <span>{{ item.sector }}</span>
                                </td>
                                <td>{{ item.wkn }}</td>
                                <td>{{ item.isin }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div v-else>
                    <add-stock :id="id" :pid="pid" :cash="cash" :store="store"></add-stock>
                </div>


            </div> <!-- /.modal-content -->
        </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
</template>

<script>
    export default {

        props: ['store', 'cash', 'pid'],

        data() {
            return {
                route: '/api/search',
                type: 'App/Entities/Stock',

                query: null,
                results: [],
                error: false,

                doSearch: true,
                id: null
            }
        },

        methods: {
            onSubmit() {
                axios.get(this.route, {
                    params: {
                        query: this.query,
                        type: this.type
                    }
                })
                    .then(data => this.assign(data.data));
            },

            onRefresh() {
                this.error = false;
                if (this.query === '') {
                    this.assign([]);
                } else {
                    this.onSubmit();
                }
            },

            onClickLink(id) {
                this.id = id;
                this.doSearch = false;
            },

            assign(data) {
                this.results = data;
                this.error = (this.result.length === 0);
            },

            reset() {
                this.query = null;
                this.results = [];
                this.doSearch = true;
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
            })
        }
    }
</script>