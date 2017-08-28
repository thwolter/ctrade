@extends('layouts.master')

@section('content')

    <div class="content">
        <div class="container">

            <div class="page-header">
                <h3 class="page-title">Frequently Asked Questions</h3>

                <ol class="breadcrumb">
                    <li><a href="./">Dashboard</a></li>
                    <li><a href="#">Demo Pages</a></li>
                    <li class="active">Frequently Asked Questions</li>
                </ol>
            </div> <!-- /.page-header -->

            <div class="row">

                <div class="col-sm-4 col-sm-push-8">

                    <div class="portlet portlet-boxed">

                        <div class="portlet-body">

                            <div class="well text-center">
                                <p><i class="fa fa-question-circle fa-5x text-muted"></i></p>
                                <h5>Have a Question?</h5>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                <a href="javascript:;" class="btn btn-secondary">Get it Answered!</a>
                            </div> <!-- /.well -->

                            <br>

                            <h5>Categories</h5>

                            <div class="list-group">

                                <a href="javascript:;" class="list-group-item">
                                    Account Settings
                                    <i class="fa fa-chevron-right list-group-chevron"></i>
                                    <span class="badge badge-secondary">6</span>
                                </a>

                                <a href="javascript:;" class="list-group-item">
                                    API Questions
                                    <i class="fa fa-chevron-right list-group-chevron"></i>
                                    <span class="badge badge-secondary">5</span>
                                </a>

                                <a href="javascript:;" class="list-group-item">
                                    Billing
                                    <i class="fa fa-chevron-right list-group-chevron"></i>
                                    <span class="badge badge-secondary">12</span>
                                </a>

                                <a href="javascript:;" class="list-group-item">
                                    Copyright &amp; Legal
                                    <i class="fa fa-chevron-right list-group-chevron"></i>
                                    <span class="badge badge-secondary">4</span>
                                </a>
                            </div> <!-- /.list-group -->
                        </div> <!-- /.portlet-body -->

                    </div> <!-- /.portlet -->

                </div> <!-- /.col -->


                <div id="faq-questions" class="col-sm-8 col-sm-pull-4">

                    <div class="portlet portlet-boxed">
                        <div class="portlet-body">

                            @foreach ($types as $type)
                                <h5>{{ $type->name }}</h5>

                                <div id="accordion-{{ $type->name }}" class="panel-group accordion-simple">

                                    @foreach ($type->faqs as $faq)
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a class="accordion-toggle" data-toggle="collapse"
                                                       data-parent="#accordion-{{ $type->name }}" href="#faq-general-{{ $faq->id }}">
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

        </div> <!-- /.container -->
    </div> <!-- .content -->


@endsection