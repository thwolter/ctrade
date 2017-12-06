@extends('layouts.master')

@section('content')

    <!-- Signup -->
    <section class="g-bg-gray-light-v5">
        <div class="container container g-pb-100 g-pt-170">
            <div class="row justify-content-center">
                <div class="col-sm-10 col-md-9 col-lg-6">
                    <div class="u-shadow-v21 g-bg-white rounded g-py-40 g-px-30">
                        <header class="text-center mb-4">
                            <h2 class="h2 g-color-black g-font-weight-600">Kostenlosen Account erstellen</h2>
                        </header>

                        <!-- Form -->
                        <form class="g-py-15" method="POST" action="{{ route('register') }}">

                            {{ csrf_field() }}

                            @if ($errors->any())
                                <div class="alert alert-dismissible fade show g-bg-red g-color-white rounded-0"
                                     role="alert">
                                    <button type="button" class="close u-alert-close--light" data-dismiss="alert"
                                            aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>

                                    <div class="media">
                                        <span class="d-flex g-mr-10 g-mt-5">
                                            <i class="icon-ban g-font-size-25"></i>
                                        </span>
                                        <span class="media-body align-self-center">
                                            <strong>Eingaben unvollständig!</strong> Bitte korrigiere deine Eingaben und versuche es erneut.
                                        </span>
                                    </div>
                                </div>
                                <!-- End Red Alert -->
                            @endif

                            <div class="row">

                                <!-- first name -->
                                <div class="col-xs-12 col-sm-6 mb-4 {{ $errors->has('firstName') ? ' u-has-error-v1' : '' }}">
                                    <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Vorname:</label>
                                    <input class="form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15"
                                           type="text" placeholder="Vorname" value="{{ old('firstName') }}"
                                           name="firstName">
                                    <small class="form-control-feedback">{{ $errors->first('firstName') }}</small>
                                </div>

                                <!-- last name -->
                                <div class="col-xs-12 col-sm-6 mb-4 {{ $errors->has('lastName') ? ' u-has-error-v1' : '' }}">
                                    <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Name:</label>
                                    <input class="form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15"
                                           type="text" placeholder="Nachname" value="{{ old('lastName') }}"
                                           name="lastName">
                                    <small class="form-control-feedback">{{ $errors->first('lastName') }}</small>
                                </div>
                            </div>

                            <!-- email -->
                            <div class="mb-4 {{ $errors->has('email') ? ' u-has-error-v1' : '' }}">
                                <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Email:</label>
                                <input class="form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15"
                                       type="email" placeholder="Email" value="{{ old('email') }}" name="email">
                                <small class="form-control-feedback">{{ $errors->first('email') }}</small>
                            </div>

                            <div class="row">

                                <!-- password -->
                                <div class="col-xs-12 col-sm-6 mb-4 {{ $errors->has('password') ? ' u-has-error-v1' : '' }}">
                                    <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Passwort:</label>
                                    <input class="form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15"
                                           type="password" placeholder="Passwort" name="password">
                                    <small class="form-control-feedback">{{ $errors->first('password') }}</small>
                                </div>

                                <!-- password confirm -->
                                <div class="col-xs-12 col-sm-6 mb-4">
                                    <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Passwort
                                        bestätigen:</label>
                                    <input class="form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15"
                                           type="password" placeholder="Passwort" name="password_confirmation">
                                </div>
                            </div>


                            <!-- accept policy -->
                            <div class="row justify-content-between mb-5">
                                <div class="col-8 align-self-center {{ $errors->has('policy') ? ' u-has-error-v1' : '' }}">
                                    <label class="form-check-inline u-check g-color-gray-dark-v5 g-font-size-13 g-pl-25">
                                        <input class="g-hidden-xs-up g-pos-abs g-top-0 g-left-0"
                                               type="checkbox" name="policy"
                                               value="1" {{ old('policy') ? 'checked' : '' }}>
                                        <div class="u-check-icon-checkbox-v6 g-absolute-centered--y g-left-0">
                                            <i class="fa" data-check-icon="&#xf00c"></i>
                                        </div>
                                        Ich akzeptiere die <a href="{{ route('home.policy') }}">Nutzungsbedingungen</a>
                                    </label>
                                    <p><small class="form-control-feedback">{{ $errors->first('policy') }}</small></p>

                                </div>
                                <div class="col-4 align-self-center text-right">
                                    <button class="btn btn-md u-btn-primary rounded g-py-13 g-px-25" type="submit">
                                        Anmelden
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!-- End Form -->

                        <footer class="text-center">
                            <p class="g-color-gray-dark-v5 g-font-size-13 mb-0">Du hast schon einen Account?
                                <a class="g-font-weight-600" href="{{ route('login') }}">Login</a>
                            </p>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

