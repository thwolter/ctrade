@extends('layouts.master')

@section('content')

    <div class="content">
        <div class="container">

            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            <div class="page-header">
                <h3 class="page-title">@lang('user.title')</h3>
            </div> <!-- /.page-header -->

            <div class="portlet portlet-boxed">
                <div class="portlet-body">
                    <div class="layout layout-main-right layout-stack-sm">

                        <div class="col-md-3 col-sm-4 layout-sidebar">

                            <div class="nav-layout-sidebar-skip">
                                <br class="xs-20 visible-xs"/>
                                <strong>Tab Navigation</strong> / <a href="#settings-content">Skip to Content</a>
                            </div>

                            <ul id="myTab" class="nav nav-layout-sidebar nav-stacked">

                                <li role="presentation" class="{{ active_tab('profile') }}">
                                    <a href="#profile" data-toggle="tab" role="tab">
                                        <i class="fa fa-user"></i>
                                        &nbsp;&nbsp;@lang('user.profile.title')
                                    </a>
                                </li>

                                <li role="presentation" class="{{ active_tab('password') }}">
                                    <a href="#password" data-toggle="tab" role="tab">
                                        <i class="fa fa-lock"></i>
                                        &nbsp;&nbsp;@lang('user.password.title')
                                    </a>
                                </li>

                              {{--  <li role="presentation" class="{{ active_tab('messaging') }}">
                                    <a href="#messaging" data-toggle="tab" role="tab">
                                        <i class="fa fa-bullhorn"></i>
                                        &nbsp;&nbsp;Benachrichtigungen
                                    </a>
                                </li>--}}

                            </ul>

                        </div> <!-- /.col -->


                        <div class="col-md-9 col-sm-8 layout-main">

                            <div id="settings-content" class="tab-content stacked-content">

                                @include('users.edit.profile')

                                @include('users.edit.password')

                               {{-- @include('users.edit.messaging')--}}

                            </div> <!-- /.tab-content -->

                        </div> <!-- /.col -->
                    </div> <!-- /.row -->
                </div> <!-- /.portlet-body -->
            </div> <!-- /.portlet -->
        </div> <!-- /.container -->
    </div> <!-- .content -->

@endsection
