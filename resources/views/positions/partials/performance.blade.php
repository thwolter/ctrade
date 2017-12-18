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

    <div class="col-md-4 g-mb-30">
        <ul class="list-unstyled g-color-text">
            <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                <span>Kurs</span>
                <span class="float-right g-color-black">{{ $stock->present()->price() }}</span>
            </li>
            <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                <span>Kursdatum</span>
                <span class="float-right g-color-black">{{ $stock->present()->priceDate() }}</span>
            </li>
            <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                <span>Vortag</span>
                <span class="float-right g-color-black">{{ $stock->present()->previousPrice() }}</span>
            </li>
            <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                <span>Volume</span>
                <span class="float-right g-color-black"></span>
            </li>
        </ul>
    </div>


    <div class="col-md-4 g-mb-30">
        <ul class="list-unstyled g-color-text">
            <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                <span>Low/High</span>
                <span class="float-right g-color-black">
                    {{ $stock->present()->lowPrice($exchange) }} / {{ $stock->present()->highPrice($exchange) }}
                </span>
            </li>
            <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                <span>52 Wo. hoch</span>
                <span class="float-right g-color-black">
                    {{ $stock->present()->periodHigh($exchange, 250) }}
                </span>
            </li>
            <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                <span>52 Wo. tief</span>
                <span class="float-right g-color-black">
                    {{ $stock->present()->periodLow($exchange, 250) }}
                </span>
            </li>
            <li class="g-brd-bottom g-brd-gray-light-v3 pt-1 mb-3">
                <span>52 Wo. perf.</span>
                <span class="float-right g-color-black">
                    {{ $stock->present()->periodReturn($exchange, 250) }}
                </span>
            </li>
        </ul>
    </div>