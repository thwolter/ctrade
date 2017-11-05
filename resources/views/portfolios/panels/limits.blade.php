<div class="card border-0 rounded-0 g-mb-40">

    <!-- Panel Header -->
    <div class="card-header d-flex align-items-center justify-content-between g-bg-gray-light-v5 border-0 g-mb-15">
        <h3 class="h6 mb-0">Limite</h3>
        <div class="dropdown g-mb-10 g-mb-0--md">
            <span class="d-block g-color-primary--hover g-cursor-pointer g-mr-minus-5 g-pa-5"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-options-vertical g-pos-rel g-top-1"></i>
            </span>
            <div class="dropdown-menu dropdown-menu-right rounded-0 g-mt-10">

                <a class="dropdown-item g-px-10" href="#modal1" data-modal-target="#modal1" data-modal-effect="fadein">
                    <i class="icon-layers g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i> Limit hinzufügen
                </a>

                <!-- Modal window -->
                <div id="modal1" class="text-left g-max-width-600 g-bg-white g-overflow-y-auto g-pa-20"
                     style="display: none;">
                    <button type="button" class="close" onclick="Custombox.modal.close();">
                        <i class="hs-icon hs-icon-close"></i>
                    </button>

                    <create-limit
                        :portfolio-id="{{ $portfolio->id }}">
                    </create-limit>

                </div>


                <div class="dropdown-divider"></div>

                <a class="dropdown-item g-px-10" href="#">
                    <i class="icon-plus g-font-size-12 g-color-gray-dark-v5 g-mr-5"></i> View More
                </a>
            </div>
        </div>
    </div>

    <!-- Panel Body -->
    <div class="card-block u-info-v1-1 g-pa-0">

        <div class="container g-height-150">
            <div class="row border">

                <div class="col-md-3 g-height-150 g-bg-gray-light-v5">
                    <span class="u-icon-v1 g-mb-10">
                        <a href="#"><i class="et-icon-edit"></i></a>
                    </span>
                    <h2>Absolutes Limit</h2>
                </div>
                <div class="col-md-9">
                    Text
                </div>

            </div>
        </div>

        <button href="#" class="btn btn-md u-btn-outline-bluegray g-mr-10 g-mb-15 g-mt-15"> Limite einrichten</button>

    </div>
</div>

