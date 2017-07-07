@if (isset($suggest) and count($suggest) == 0)
    <div class="row">
        <div>
            <div class="alert alert-warning alert-dismissable" role="alert">

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <strong>Leider keine Ergebnisse gefunden.</strong>
                <p>Versuche es mit der WKN oder der ISIN oder gib
                    nur einen Teil des Namens ein.</p>
            </div>
        </div>
    </div>
@endif