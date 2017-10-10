@extends('layouts.master')

@section('content')

    <section class="g-color-white g-bg-black-opacity-0_8 g-pa-40">
        <div class="container">
            <div class="row">
                <div class="col-md-8 align-self-center">
                    <h2 class="h3 text-uppercase g-font-weight-300 g-mb-20 g-mb-0--md">
                        Benutzer <strong>Einstellungen</strong>
                    </h2>
                </div>
            </div>
        </div>
    </section>

    <section class="g-mb-100 g-pt-100">
        <div class="container">
            <div class="row">

                <!-- Profile Sidebar -->
                <div class="col-lg-3 g-mb-50 g-mb-0--lg">

                    @include('layouts.sidebar.user_image')

                    @include('layouts.sidebar.navigation')

                </div>

                <!-- Profle Content -->
                <div class="col-lg-9">
                    <!-- Nav tabs -->
                    <ul class="nav nav-justified u-nav-v1-1 u-nav-primary g-brd-bottom--md g-brd-bottom-2 g-brd-primary g-mb-20"
                        role="tablist" data-target="nav-1-1-default-hor-left-underline"
                        data-tabs-mobile-type="slide-up-down"
                        data-btn-classes="btn btn-md btn-block rounded-0 u-btn-outline-primary g-mb-20">
                        <li class="nav-item">
                            <a class="nav-link g-py-10 active" data-toggle="tab"
                               href="#nav-1-1-default-hor-left-underline--1" role="tab">
                                @lang('user.profile.title')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link g-py-10" data-toggle="tab" href="#nav-1-1-default-hor-left-underline--2"
                               role="tab">
                                @lang('user.password.title')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link g-py-10" data-toggle="tab" href="#nav-1-1-default-hor-left-underline--3"
                               role="tab">
                                @lang('user.messaging.title')
                            </a>
                        </li>

                    </ul>
                    <!-- End Nav tabs -->

                    <!-- Tab panes -->
                    <div id="nav-1-1-default-hor-left-underline" class="tab-content">
                        <!-- Edit Profile -->
                    @include('users.edit.profile')

                    <!-- Security Settings -->
                    @include('users.edit.password')
                    <!-- End Security Settings -->

                        <!-- Notification Settings -->
                    @include('users.edit.messaging')
                    <!-- End Payment Options -->

                    </div>
                    <!-- End Tab panes -->
                </div>

            </div>
        </div>
    </section>

@endsection
