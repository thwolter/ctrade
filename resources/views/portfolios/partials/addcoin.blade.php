<a class="btn u-btn-primary" href="#addcoin" data-modal-target="#addcoin" data-modal-effect="fadein">
    Add Coin
</a>

<div id="addcoin" class="text-left g-max-width-600 g-bg-white g-overflow-y-auto g-pa-20" style="display: none;">
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <i class="hs-icon hs-icon-close"></i>
    </button>
    <h4 class="g-mb-20">Modal title</h4>

    <search-instrument
            :portfolio="{{ $portfolio }}"
            route="{{ route('positions.show', [$portfolio->slug, '%entity%', '%instrument%'], false) }}">
    </search-instrument>

</div>