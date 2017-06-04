@php ($route = route('portfolios.show', ['id' => $portfolio->id]))

<div class="mas-boxes-inner col-md-4 col-sm-6">
    <div class="news-sec wow animated bounceIn" data-wow-delay="{{ $bounceIn }}">
        <div class="news-thumnail">
            <a href="{{ $route }}">
                @php ($img = $portfolio->imageUrl)
                @if (!is_null($img))
                    <img src="{{ asset('storage/'.$portfolio->imageUrl) }}" class="img-fluid" alt="">
                @endif
            </a>
        </div>
        <div class="news-desc">
            <h3 class="blog-post-title">
                <a href="{{ $route }}" class="hover-color">{{ $portfolio->name  }}</a>
            </h3>
            <span class="news-post-cat">{{ $portfolio->categoryName }}</span>
            <p>
                {{ $portfolio->description }}
            </p>
            <a href="{{ $route }}" class="mas-link">Portfolio ansehen <i class="ion-ios-arrow-right"></i></a>
        </div>
    </div>
</div>

