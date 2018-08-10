<a class="btn u-btn-primary" href="#addcoin" data-modal-target="#addcoin" data-modal-effect="fadein">
    Add Coin
</a>

<div id="addcoin" class="text-left g-max-width-600 g-bg-white g-overflow-y-auto g-pa-20" style="display: none;">
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <i class="hs-icon hs-icon-close"></i>
    </button>
    <h4 class="g-mb-20">Add coin</h4>

    <search-coins
            :portfolio="{{ $portfolio }}"
            :coinlist="{{ $coinlist }}"
            route="{{ route('positions.store') }}">
    </search-coins>
</div>