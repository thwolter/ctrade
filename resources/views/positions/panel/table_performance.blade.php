<!-- Performance Table -->
<div class="card border-0 rounded-0 g-mb-40">

    <!-- Panel Header -->
    <div class="card-header d-flex align-items-center justify-content-between g-bg-gray-light-v5 border-0 g-mb-15">
        <h3 class="h6 mb-0">Wertentwicklung</h3>
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

        <stock-performance
                :exchanges="{{ json_encode($exchanges) }}"
                :history="{{ json_encode($history) }}"
                :stock="{{ json_encode($stock) }}"
                locale="de-DE">
        </stock-performance>

    </div>
    <!-- End Panel Body -->
</div>