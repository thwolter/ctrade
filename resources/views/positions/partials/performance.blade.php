<div class="row">
    <div class="col-md-4 g-mb-30">
        <ul class="list-unstyled g-color-text">
            <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                <span>Name</span>
                <span class="float-right g-color-black">{{ $stock->name }}</span>
            </li>
            <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                <span>ISIN/WKN</span>
                <span class="float-right g-color-black">{{ $stock->isin }} / {{ $stock->wkn }}</span>
            </li>
            <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                <span>Sector</span>
                <span class="float-right g-color-black">{{ $stock->sector }}</span>
            </li>
            <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                <span>Industry</span>
                <span class="float-right g-color-black">{{ $stock->industry }}</span>
            </li>
        </ul>
    </div>

    @php( $prices = $data->priceHistory($stock, ['count' => 2]) )

    <div class="col-md-4 g-mb-30">
        <ul class="list-unstyled g-color-text">
            <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                <span>Kurs</span>
                <span class="float-right g-color-black">{{ array_first($prices) }}</span>
            </li>
            <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                <span>Kursdatum</span>
                <span class="float-right g-color-black">{{ array_first(array_keys($prices)) }}</span>
            </li>
            <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                <span>Vortag</span>
                <span class="float-right g-color-black">{{ array_last($prices) }}</span>
            </li>
            <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                <span>Volume</span>
                <span class="float-right g-color-black"></span>
            </li>
        </ul>
    </div>

    @php( $statistics = $data->statistics($stock, ['exchange' => $exchange, 'count' => 250]) )

    <div class="col-md-4 g-mb-30">
        <ul class="list-unstyled g-color-text">
            <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                <span>High/Low</span>
                <span class="float-right g-color-black">
                    {{ array_get($statistics, 'high') }} / {{ array_get($statistics, 'low')  }}
                </span>
            </li>
            <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                <span>52 Wo. hoch</span>
                <span class="float-right g-color-black">
                    {{ array_get($statistics, 'yearHigh') }}
                </span>
            </li>
            <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                <span>52 Wo. tief</span>
                <span class="float-right g-color-black">
                    {{ array_get($statistics, 'yearLow') }}
                </span>
            </li>
            <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                <span>52 Wo. perf.</span>
                <span class="float-right g-color-black">
                    {{ array_get($statistics, 'yearReturn') }}
                </span>
            </li>
        </ul>
    </div>