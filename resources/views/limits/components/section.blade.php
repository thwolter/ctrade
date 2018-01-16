
<div id="transaction" class="card border-0 rounded-0 g-mb-60" role="tablist" aria-multiselectable="true">

    <!-- Header -->
    <div id="{{ $limit->id }}-heading" role="tab"
         class="align-items-center card-header d-flex g-bg-primary-opacity-0_1 g-brd-primary-bottom justify-content-between">
        <h5 class="g-my-0">
            {{ $limit->present()->type() }}
        </h5>

        <div class="dropdown g-mb-10 g-mb-0--md">
            <span class="d-block g-color-primary--hover g-cursor-pointer g-mr-minus-5 g-pa-5"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-options-vertical g-pos-rel g-top-1"></i>
            </span>
            <div class="dropdown-menu dropdown-menu-right rounded-0 g-mt-10">
                <a-limit cls="dropdown-item g-px-10" event="showLimitUpdate" :id="{{ $limit->id }}">
                    <i class="icon-layers g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i> Anpassen
                </a-limit>
                <a class="dropdown-item g-px-10" href="#">
                    <i class="icon-layers g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i> Optimieren
                </a>

                <div class="dropdown-divider"></div>
                <a class="dropdown-item g-px-10" href="#delete_{{ $limit->id }}"
                   data-modal-target="#delete_{{ $limit->id }}" data-modal-effect="fadein">
                    <i class="fa fa-trash-o g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i> Löschen
                </a>

                <!-- Delete -->
                <div id="delete_{{ $limit->id }}" style="display: none;"
                     class="text-left g-max-width-600 g-bg-white g-overflow-y-auto g-pa-20">
                    <div class="g-brd-bottom g-brd-gray-light-v4 g-mb-20">
                        <button type="button" class="close" onclick="Custombox.modal.close();">
                            <i class="hs-icon hs-icon-close"></i>
                        </button>
                        <h4 class="g-mb-20">Limit löschen</h4>
                    </div>
                    <div>
                        <p class="justified-content">Bitte bestätige die Löschung des Limits:</p>
                        <p class="font-weight-bold">{{ $limit->present()->type() }} {{ $limit->present()->value() }}</p>
                    </div>

                    <div class="g-brd-gray-light-v4 g-brd-top g-mt-20 g-pt-20">
                        {!! Form::open(['route' => 'limits.destroy', 'method' => 'delete',
                            'class' => 'd-flex justify-content-end']) !!}

                        <input type="hidden" name="id" value="{{ $limit->id }}">
                        <input type="hidden" name="portfolio" value="{{ $limit->portfolio->slug }}">

                        <button type="button" class="btn u-btn-outline-lightgray" onclick="Custombox.modal.close();">
                            Abbrechen
                        </button>
                        <button type="submit" class="btn btn-default u-btn-primary g-ml-10">Löschen</button>
                        {!! Form::close() !!}
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Body -->
    <div id="{{ $limit->id }}-body" class="g-pa-10" role="tabpanel"
         aria-labelledby="{{ $limit->id }}-heading">

        {{ $slot }}

    </div>
</div>
