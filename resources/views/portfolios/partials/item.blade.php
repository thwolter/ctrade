@php ($route = route('portfolios.show', ['id' => $portfolio->id]))
<div class="col-md-3">
    <div class="thumbnail">
        <div class="thumbnail-view">
            <a href="{{ $route }}" class="thumbnail-view-hover thumbnail-view-hover-lg ui-lightbox">
                <i class="fa fa-plus"></i>
            </a>
            @if (!is_null($portfolio->imageUrl))
                <img src="{{ asset('storage/'.$portfolio->imageUrl) }}" style="width: 100%" alt="Gallery Image">
            @endif
        </div>

        <div class="caption">
            <h3>{{ $portfolio->name }}</h3>
            <p>{{ $portfolio->description }}</p>
            <p>
                <a href="{{ $route }}" class="btn btn-secondary btn-sm btn-sm">Öffnen</a>
            </p>
        </div>

        <div class="thumbnail-footer">
            <div class="pull-left">
                <a href="#">{{ $portfolio->categoryName }}</a>
            </div>
        </div>
    </div>
</div> <!-- /.col -->