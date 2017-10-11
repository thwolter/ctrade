@extends('layouts.master')

@section('content')

    <div class="g-brd-bottom g-brd-gray-light-v4"></div>

        <section class="container g-py-100">
        <div class="row justify-content-center">
            <div class="col-sm-9 col-md-7 col-lg-5">
                <div class="g-brd-around g-brd-gray-light-v3 g-bg-white rounded g-px-30 g-py-50 mb-4">
                    <header class="text-center mb-4">
                        <h1 class="h4 g-color-black g-font-weight-400">Passwort zurücksetzen</h1>
                    </header>

                    <!-- Form -->
                    <form class="g-pt-15" role="form" method="POST" action="/password/reset">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-4 {{ $errors->has('email') ? 'u-has-error-v1-2' : '' }}">
                            <div class="input-group g-rounded-left-5">
                                 <span class="input-group-addon g-width-45 g-brd-gray-light-v3 g-color-gray-dark-v5">
                                  <i class="icon-communication-025 u-line-icon-pro"></i>
                                </span>
                                <input class="form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v3 g-rounded-left-0 g-rounded-right-5 g-py-15 g-px-15"
                                        id="email" type="email" name="email" value="{{ $email or old('email') }}"
                                        placeholder="Email-Adresse">
                            </div>
                            <small class="form-control-feedback">{{ $errors->first('email') }}</small>
                        </div>

                        <div class="mb-4 {{ $errors->has('password') ? 'u-has-error-v1-2' : '' }}">
                            <div class="input-group g-rounded-left-5">
                                 <span class="input-group-addon g-width-45 g-brd-gray-light-v3 g-color-gray-dark-v5">
                                  <i class="icon-lock u-line-icon-pro"></i>
                                </span>
                                <input class="form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v3 g-rounded-left-0 g-rounded-right-5 g-py-15 g-px-15"
                                        id="password" type="password" name="password" placeholder="Passwort" required>
                            </div>
                            <small class="form-control-feedback">{{ $errors->first('password') }}</small>
                        </div>

                        <div class="mb-4 {{ $errors->has('password_confirmation') ? 'u-has-error-v1-2' : '' }}">
                            <div class="input-group g-rounded-left-5">
                                 <span class="input-group-addon g-width-45 g-brd-gray-light-v3 g-color-gray-dark-v5">
                                  <i class="icon-lock u-line-icon-pro"></i>
                                </span>
                                <input class="form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v3 g-rounded-left-0 g-rounded-right-5 g-py-15 g-px-15"
                                       id="password-confirm" type="password" name="password_confirmation" placeholder="Passwort bestätigen" required>
                            </div>
                            <small class="form-control-feedback">{{ $errors->first('password_confirmation') }}</small>
                        </div>

                        <button class="btn btn-block u-btn-primary g-font-size-12 text-uppercase g-py-15 g-px-25"
                                type="submit">Passwort zurücksetzen
                        </button>
                    </form>
                    <!-- End Form -->
                </div>
            </div>
        </div>
    </section>

@endsection
