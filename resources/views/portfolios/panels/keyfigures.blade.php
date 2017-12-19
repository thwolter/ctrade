<!-- Key figures -->
<div class="card border-0 rounded-0 g-mb-40">

    <!-- Panel Header -->
    <div class="card-header d-flex align-items-center justify-content-between g-bg-gray-light-v5 border-0 g-mb-15">
        <h3 class="h6 mb-0">Kennzahlen</h3>
        <div class="dropdown g-mb-10 g-mb-0--md">
                  <span class="d-block g-color-primary--hover g-cursor-pointer g-mr-minus-5 g-pa-5"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="icon-options-vertical g-pos-rel g-top-1"></i>
                    </span>
            <div class="dropdown-menu dropdown-menu-right rounded-0 g-mt-10">
                <a class="dropdown-item g-px-10" href="#">
                    <i class="icon-layers g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i> Projects
                </a>
                <a class="dropdown-item g-px-10" href="#">
                    <i class="icon-wallet g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i> Wallets
                </a>
                <a class="dropdown-item g-px-10" href="#">
                    <i class="icon-fire g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i> Reports
                </a>
                <a class="dropdown-item g-px-10" href="#">
                    <i class="icon-settings g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i> Users Setting
                </a>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item g-px-10" href="#">
                    <i class="icon-plus g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i> View More
                </a>
            </div>
        </div>
    </div>

    <!-- Panel Body -->
    <div class="card-block u-info-v1-1 g-pa-0">
        <div class="row text-center text-uppercase">
            <div class="col-lg-3 col-sm-6 g-mb-50">
                <span class="u-label g-bg-bluegray g-mr-10 g-mb-15">Portfoliowert</span>
                <div class="g-font-size-35 g-font-weight-300 g-mb-7">
                    {{ $portfolio->present()->value() }}
                </div>
                <p> {{ $portfolio->present()->updatedValue() }}</p>
            </div>

            <div class="col-lg-3 col-sm-6 g-mb-50">
                <span class="u-label g-bg-bluegray g-mr-10 g-mb-15">Barbestand</span>
                <div class="js-counter g-font-size-35 g-font-weight-300 g-mb-7">
                    {{ $portfolio->present()->cash() }}
                </div>
                <p>{{ $portfolio->present()->updatedToday() }}</p>
            </div>

            <div class="col-lg-3 col-sm-6 g-mb-50">
                <span class="u-label g-bg-bluegray g-mr-10 g-mb-15">Gewinn/Verlust</span>
                <div class="js-counter g-font-size-35 g-font-weight-300 g-mb-7">
                    {{  $portfolio->present()->profit() }}
                </div>
                <p>{{ $portfolio->present()->updatedValue() }}</p>

            </div>

            <div class="col-lg-3 col-sm-6 g-mb-50">
                <span class="u-label g-bg-bluegray g-mr-10 g-mb-15">Risiko</span>
                <div class="js-counter g-font-size-35 g-font-weight-300 g-mb-7">
                    {{ $portfolio->present()->risk() }}
                </div>
                <p>{{ $portfolio->present()->updatedRisk() }}</p>
            </div>
        </div>
        <p>Gemäß deiner Einstellungen wird die Rendite auf Basis der Historie von
            {{ $portfolio->settings()->human()->get('returnPeriod') }} angezeigt. Das
            Risiko ist berechnet für einen zukünftigen Zeitraum von
            {{ $portfolio->settings()->human()->get('period') }}.
        </p>
    </div>
</div>