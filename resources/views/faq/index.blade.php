@extends('layouts.master')

@section('content')


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