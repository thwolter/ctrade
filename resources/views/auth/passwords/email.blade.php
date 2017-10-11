@extends('layouts.master')

@section('content')

    <div class="g-brd-bottom g-brd-gray-light-v4"></div>

    <!-- Email -->
    <section class="container g-py-100">
        <div class="row justify-content-center">
            <div class="col-sm-9 col-md-7 col-lg-5">
                <div class="g-brd-around g-brd-gray-light-v3 g-bg-white rounded g-px-30 g-py-50 mb-4">

                    @if (session('status'))
                        <div class="alert alert-info" role="alert">{{ session('status') }}</div>
                    @endif

                    <header class="text-center mb-4">
                        <h1 class="h4 g-color-black g-font-weight-400">Passwort vergessen?</h1>
                        <p>Gib deine Email-Adresse ein.</p>
                    </header>

                    <!-- Form -->
                    <form class="g-py-15" role="form" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="mb-4 {{ $errors->has('email') ? ' u-has-error-v1-2' : '' }}">
                            <div class="input-group g-rounded-left-5">
                                <span class="input-group-addon g-width-45 g-brd-gray-light-v3 g-color-gray-dark-v5">
                                  <i class="icon-finance-067 u-line-icon-pro"></i>
                                </span>
                                <input class="form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v3 g-rounded-left-0 g-rounded-right-5 g-py-15 g-px-15"
                                       type="email" name="email" value="{{ old('email') }}" placeholder="Email-Adresse">
                            </div>
                            @if ($errors->has('email'))
                                <small class="form-control-feedback">{{ $errors->first('email') }}</small>
                            @endif
                        </div>

                        <button class="btn btn-block u-btn-primary g-font-size-12 text-uppercase g-py-15 g-px-25"
                                type="submit">Passwort zurücksetzen
                        </button>
                    </form>
                    <!-- End Form -->
                </div>

                <div class="row justify-content-between mb-5">
                    <div class="col align-self-center text-center">
                        <p class="g-font-size-13">Keine Email erhalten? <a href="#">Hier klicken</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
