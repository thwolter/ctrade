<div class="d-flex justify-content-between g-mt-40 g-mb-5">
    <span class="">{{ $limit->present()->title() }}</span>
    <span class="">{{ $limit->present()->value(0) }}</span>
</div>

<div class="progress g-height-20 rounded-0 g-overflow-visible g-mb-10">
    <div class="progress-bar g-pos-rel" role="progressbar"
         style="width: {{ $limit->present()->utilisationNumber() * 100 }}%;"
         aria-valuenow="{{ $limit->present()->utilisationNumber() * 100 }}"
         aria-valuemin="0"
         aria-valuemax="100">
        <div class="pull-right g-font-size-11 g-px-5">
            {{ $limit->present()->utilisation() }}
        </div>
    </div>
</div>
