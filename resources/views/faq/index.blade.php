@extends('layouts.master')

@section('content')


    <!-- Promo Block -->
    <section class="container text-center g-pt-120 g-pb-30">
        <h2 class="g-color-black g-font-weight-600 g-font-size-50 g-mb-70">Frequently Asked Questions</h2>
        <ul class="list-inline mb-0">

            @foreach($categories as $category)
                <li class="list-inline-item g-brd-right g-brd-gray-light-v4 px-4 mx-0">
                    <a class="js-go-to g-color-gray-dark-v5 g-font-weight-600 text-uppercase g-text-underline--none--hover"
                       href="#" data-target="#purchase">
                        {{ $category->name }}
                    </a>
                </li>
            @endforeach

        </ul>
    </section>
    <!-- End Promo Block -->

    <!-- Accordion -->
    <section class="container g-pb-100">

    @foreach($categories as $category)

        <!-- Accordion -->
            <div id="purchase" class="u-shadow-v11 rounded g-py-100 g-mb-100">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <!-- Heading -->
                        <div class="text-center g-mb-60">
                            <h2 class="g-font-weight-600 text-uppercase mb-2">{{ $category->name }}</h2>
                        </div>
                        <!-- End Heading -->

                        <div id="accordion" class="u-accordion u-accordion-color-primary" role="tablist"
                             aria-multiselectable="true">

                        @foreach ($category->faqs as $faq)
                            <!-- Card -->
                                <div class="card g-brd-none rounded-0 g-mb-20">
                                    <div id="accordion-heading-01" class="g-brd-bottom g-brd-gray-light-v4 g-pa-0"
                                         role="tab">
                                        <h5 class="mb-0">
                                            <a class="collapsed d-flex justify-content-between g-color-main g-text-underline--none--hover rounded-0 g-px-30 g-py-20"
                                               href="#accordion-body-01" data-toggle="collapse" data-parent="#accordion"
                                               aria-expanded="false" aria-controls="accordion-body-01">
                                                {{ $faq->question }}
                                                <span class="u-accordion__control-icon">
                                                    <i class="fa fa-angle-down"></i>
                                                    <i class="fa fa-angle-up"></i>
                                                </span>
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="accordion-body-01" class="collapse" role="tabpanel"
                                         aria-labelledby="accordion-heading-01">
                                        <div class="u-accordion__body g-color-gray-dark-v4 g-pa-30">
                                            {{ $faq->answer }}
                                        </div>
                                    </div>
                                </div>
                                <!-- End Card -->
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
            <!-- End Accordion -->

        @endforeach


    </section>
    <!-- End Accordion -->

    <div class="page-header">
        <h3 class="page-title">@lang('faq.faq')</h3>

    </div> <!-- /.page-header -->

    <div class="row">

        <div class="col-sm-4 col-sm-push-8">

            <div class="portlet portlet-boxed">

                <div class="portlet-body">

                    <div class="well text-center">
                        <p><i class="fa fa-question-circle fa-5x text-muted"></i></p>
                        <h5>@lang('faq.hint.question')</h5>
                        <p>@lang('faq.hint.text')</p>
                        <a href="mailto:{{ $mail }}" class="btn btn-secondary">@lang('faq.hint.answer')</a>
                    </div> <!-- /.well -->

                    <br>

                    <h5>@lang('faq.categories')</h5>

                    <div class="list-group">

                        @foreach($categories as $category)

                            <a href="#category-{{ $category->id }}" class="list-group-item">
                                {{ $category->name }}
                                <i class="fa fa-chevron-right list-group-chevron"></i>
                                <span class="badge badge-secondary">{{ $category->faqs->count() }}</span>
                            </a>

                        @endforeach


                    </div> <!-- /.list-group -->
                </div> <!-- /.portlet-body -->

            </div> <!-- /.portlet -->

        </div> <!-- /.col -->


        <div id="faq-questions" class="col-sm-8 col-sm-pull-4">

            <div class="portlet portlet-boxed">
                <div class="portlet-body">

                    @foreach ($categories as $category)
                        <h5 id="category-{{ $category->id }}">{{ $category->name }}</h5>

                        <div id="accordion-{{ $category->id }}" class="panel-group accordion-simple">

                            @foreach ($category->faqs as $faq)
                                <div class="panel">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="accordion-toggle" data-toggle="collapse"
                                               data-parent="#accordion-{{ $category->id }}"
                                               href="#faq-general-{{ $faq->id }}">
                                                <i class="fa faq-accordion-caret"></i>{{ $faq->question }}
                                            </a>
                                        </h4>
                                    </div><!-- .panel-heading -->

                                    <div id="faq-general-{{ $faq->id }}" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <p>{{ $faq->answer }}</p>
                                        </div><!-- .panel-body -->
                                    </div> <!-- ./panel-collapse -->
                                </div><!-- .panel -->
                            @endforeach

                        </div> <!-- /.accordion -->

                        <br class="xs-20">
                    @endforeach


                </div> <!-- /.portlet-body -->

            </div> <!-- /.portlet -->

        </div> <!-- /.col -->

    </div> <!-- /.row -->

@endsection


@section('link.header')

@endsection


@section('script.footer')

@endsection
