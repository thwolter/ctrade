@php ($route = route('portfolios.show', ['id' => $portfolio->id]))

<div class="col-md-6 col-sm-6">
    <div class="portfolio">
        <div class="portfolio-img">
            <a href="{{ $route }}">
                @php ($img = $portfolio->imageUrl)
                @if (!is_null($img))
                    <img src="{{ asset('storage/'.$portfolio->imageUrl) }}" class="img-fluid" alt="">
                @endif
            </a>
        </div>
        <div class="portfolio-desc">
            <h3 class="portfolio-title">
                <a href="{{ $route }}" class="hover-color">{{ $portfolio->name  }}</a>
            </h3>
            <span class="portfolio-category">{{ $portfolio->categoryName }}</span>
            <p>
                {{ $portfolio->description }}
            </p>
            <a href="{{ $route }}">Portfolio ansehen <i class="ion-ios-arrow-right"></i></a>
        </div>
    </div>
</div>

