<!-- Search container for algolio usage -->
<div id="searchStocks" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">Wertpapier hinzufügen</h3>
            </div> <!-- /.modal-header -->

            <div class="modal-body">


                <!-- Search input -->
                <div class="row">
                    <form>

                        <div class="form-group">
                            <label for="query" class="control-label col-sm-2 col-sm-offset-1">Suchen</label>
                            <div class="col-sm-8">

                                <ais-index app-id="{{ env('ALGOLIA_APP_ID') }}"
                                           api-key="{{ env('ALOGLIA_SEARCH') }}"
                                           index-name="stocks">

                                    <ais-input placeholder="Search contacts..."></ais-input>
                                    <span class="help-block">
                                            Suche nach Namen oder Branche
                                        </span>

                                    <ais-results>
                                        <template scope="{ result }">

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
                                                <tr>
                                                    <td class="align-middle"> </td>
                                                    <td class="align-middle">
                                                        <span style="display:block">
                                                            <a href="#"</a>
                                                        </span>
                                                        <span></span>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                </tbody>
                                            </table>

                                        </template>

                                    </ais-results>

                                </ais-index>

                            </div>
                        </div>

                        <!-- submit button -->
                        <div>
                            <div class="col-sm-offset-3 col-sm-8">
                                <button class="btn btn-primary">Suchen</button>
                                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">
                                    Abbrechen
                                </button>
                            </div>
                        </div>

                    </form>
                </div> <!-- /search input -->

            </div> <!-- /.modal-content -->
        </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
</div>