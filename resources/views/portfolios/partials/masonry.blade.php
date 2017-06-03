<div class="mas-boxes-inner col-md-4 col-sm-6">
    <div class="news-sec wow animated bounceIn" data-wow-delay="{{ $bounceIn }}">
        <div class="news-thumnail">
            <a href="blog-post.html">
                <img src="{{ $example->img_url }}" class="img-fluid" alt="">
            </a>
        </div>
        <div class="news-desc">
            <h3 class="blog-post-title">
                <a href="blog-post.html" class="hover-color">{{ $example->name  }}</a>
            </h3>
            <span class="news-post-cat">{{ $example->category->name }}</span>
            <p>
                {{ $example->description }}
            </p>
            <a href="#" class="mas-link">Portfolio ansehen <i class="ion-ios-arrow-right"></i></a>
        </div>
    </div>
</div>

