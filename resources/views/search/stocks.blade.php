<div class="modal-dialog inline-template">
    <div class="modal-content">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="modal-title">Suche</h3>
        </div> <!-- /.modal-header -->

        <div class="modal-body">

            <!-- Search input -->
            <form @submit.prevent="onSubmit">

                @include('partials.errors')
                @include('search.partials.noresults')

                <div class="row">

                    <!-- search form input -->
                    <div class="form-group row">
                        <label for="query" class="control-label col-sm-2 col-sm-offset-1">Suchen</label>
                        <div class="col-sm-8">
                            <input type="text" placeholder="Name, WKN, ISIN, ..." class="form-control">
                            <span class="help-block">
                                Suche nach Namen oder Branche
                            </span>
                        </div>
                    </div>

                    <!-- submit button -->
                    <div class="col-sm-offset-3">
                        <button class="btn btn-primary">Suchen</button>
                    </div>

                </div>

                <!-- Search results -->
                @include('search.partials.results')

            </div>
        </div>
    </div>
</div>





