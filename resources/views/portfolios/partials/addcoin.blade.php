@inject('data', 'App\Services\DataService)

<a class="btn u-btn-primary" href="#addcoin" data-modal-target="#addcoin" data-modal-effect="fadein">
    Add Coin
</a>

<div id="addcoin" class="text-left g-max-width-300 g-bg-white g-overflow-y-auto g-pa-20" style="display: none;">
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <i class="hs-icon hs-icon-close"></i>
    </button>
    <h4 class="g-mb-20">Add coin</h4>
    <hr>

    <search-coins
            :portfolio="{{ $portfolio }}"
            :coinlist="{{ collect($data->coinList()) }}"
            route="{{ route('asset.store') }}">
    </search-coins>
</div>