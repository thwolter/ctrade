@extends('layouts.master')


@section('breadcrumbs')

    <div class="header-space"></div>

    <section class="container text-center g-py-80">
        <h2 class="h2 g-color-black g-font-weight-600">Blog grid modern 1</h2>

        <ul class="u-list-inline">
            <li class="list-inline-item g-mr-5">
                <a class="u-link-v5 g-color-gray-dark-v5 g-color-primary--hover" href="#!">Home</a>
                <i class="g-color-gray-light-v2 g-ml-5">/</i>
            </li>
            <li class="list-inline-item g-mr-5">
                <a class="u-link-v5 g-color-gray-dark-v5 g-color-primary--hover" href="#!">Blog</a>
                <i class="g-color-gray-light-v2 g-ml-5">/</i>
            </li>
            <li class="list-inline-item g-color-primary">
                <span>Blog grid modern 1</span>
            </li>
        </ul>
    </section>
    <!-- End Breadcrumbs -->
@endsection


@section('content')
    <!-- Blog Grid Blocks -->
    <div class="g-bg-gray-light-v5">
        <div class="container g-py-100">
            <div class="masonry-grid row g-mb-70">
                <div class="masonry-grid-sizer col-sm-1"></div>

                @foreach ($posts as $post)

                    @if ($loop->first)
                        <div class="masonry-grid-item col-sm-12 col-lg-8 g-mb-30">
                            <!-- Blog Grid Modern Blocks -->
                            <article
                                    class="row align-items-stretch no-gutters u-shadow-v21 u-shadow-v21--hover g-transition-0_3">
                                <div class="col-md-6 g-bg-white g-rounded-left-5">
                                    <div class="g-pa-60">
                                        <ul class="list-inline g-color-gray-dark-v4 g-font-weight-600 g-font-size-12">
                                            <li class="list-inline-item mr-0">{{ $post->present()->author() }}</li>
                                            <li class="list-inline-item mx-2">&#183;</li>
                                            <li class="list-inline-item">{{ $post->present()->date() }}</li>
                                        </ul>

                                        <h2 class="h5 g-color-black g-font-weight-600 mb-4">
                                            <a class="u-link-v5 g-color-black g-color-primary--hover g-cursor-pointer"
                                               href="{{ route('blog.show', [$post->post_name]) }}">{{ $post->present()->title() }}</a>
                                        </h2>
                                        <p class="g-color-gray-dark-v4 g-line-height-1_8 mb-4">
                                            {{ $post->present()->content() }}
                                        </p>

                                        <ul class="list-inline g-font-size-12 mb-0">
                                            @foreach($post->categories() as $category)
                                                <li class="list-inline-item g-mb-10">
                                                    <a class="u-tags-v1 g-color-lightred g-bg-lightred-opacity-0_1 g-bg-lightred--hover g-color-white--hover g-rounded-50 g-py-4 g-px-15"
                                                       href="#">{{ $category['name'] }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                @if ($post->hasThumbnail())
                                    <div class="col-md-6 g-bg-size-cover g-bg-pos-center g-min-height-300 g-rounded-right-5"
                                         data-bg-img-src="{{ $post->thumbnailUrl() }}">

                                    </div>
                                @endif
                            </article>
                            <!-- End Blog Grid Modern Blocks -->

                        </div>

                    @else

                        <div class="masonry-grid-item col-sm-6 col-lg-4 g-mb-30">
                            <!-- Blog Grid Modern Blocks -->
                            <article class="u-shadow-v21 u-shadow-v21--hover g-transition-0_3">
                                @if ($post->hasThumbnail())
                                    <img class="img-fluid w-100 g-rounded-top-5"
                                         src="{{ $post->thumbnailUrl() }}"
                                         alt="Image Description">
                                @endif
                                <div class="g-bg-white g-pa-30 g-rounded-bottom-5">
                                    <ul class="list-inline g-color-gray-dark-v4 g-font-weight-600 g-font-size-12">
                                        <li class="list-inline-item mr-0">{{ $post->present()->author() }}</li>
                                        <li class="list-inline-item mx-2">&#183;</li>
                                        <li class="list-inline-item">{{ $post->present()->date() }}</li>
                                    </ul>

                                    <h2 class="h5 g-color-black g-font-weight-600 mb-4">
                                        <a class="u-link-v5 g-color-black g-color-primary--hover g-cursor-pointer"
                                           href="{{ route('blog.show', [$post->post_name]) }}">{{ $post->present()->title() }}</a>
                                    </h2>

                                    <ul class="list-inline g-font-size-12 mb-0">
                                        @foreach($post->categories() as $category)
                                            <li class="list-inline-item g-mb-10">
                                                <a class="u-tags-v1 g-color-teal g-bg-teal-opacity-0_1 g-bg-teal--hover g-color-white--hover g-rounded-50 g-py-4 g-px-15"
                                                   href="#!">{{ $category['name'] }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </article>
                            <!-- End Blog Grid Modern Blocks -->
                        </div>

                    @endif
                @endforeach
            </div>


            <!-- Pagination -->
            <nav class="text-center" aria-label="Page Navigation">
                <ul class="list-inline">
                    <li class="list-inline-item float-left g-hidden-xs-down">
                        <a class="u-pagination-v1__item u-pagination-v1-4 g-brd-gray-light-v3 g-brd-primary--hover g-rounded-50 g-pa-7-16"
                           href="#!" aria-label="Previous">
                <span aria-hidden="true">
                  <i class="fa fa-angle-left g-mr-5"></i> Previous
                </span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a class="u-pagination-v1__item u-pagination-v1-4 u-pagination-v1-4--active g-rounded-50 g-pa-7-14"
                           href="#!">1</a>
                    </li>
                    <li class="list-inline-item">
                        <a class="u-pagination-v1__item u-pagination-v1-4 g-rounded-50 g-pa-7-14" href="#!">2</a>
                    </li>
                    <li class="list-inline-item float-right g-hidden-xs-down">
                        <a class="u-pagination-v1__item u-pagination-v1-4 g-brd-gray-light-v3 g-brd-primary--hover g-rounded-50 g-pa-7-16"
                           href="#!" aria-label="Next">
                <span aria-hidden="true">
                  Next <i class="fa fa-angle-right g-ml-5"></i>
                </span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- End Pagination -->
        </div>
    </div>
    <!-- End Blog Grid Blocks -->

@endsection



@section('script.footer')


    <!-- JS Implementing Plugins -->
    <script src="{{ asset('assets/vendor/masonry/dist/masonry.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>


    <script>

        $(document).on('ready', function () {

            // initialization of masonry
            $('.masonry-grid').imagesLoaded().then(function () {
                $('.masonry-grid').masonry({
                    columnWidth: '.masonry-grid-sizer',
                    itemSelector: '.masonry-grid-item',
                    percentPosition: true
                });
            });
        });
    </script>
@endsection