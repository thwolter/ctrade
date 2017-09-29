@extends('layouts.master')

@section('content')

    <div class="account-container">

        <div class="row vcenter" style="margin: 0;">
            <div class="col-sm-6 text-center">
                <h1 class="brand-name">CapMyRisk</h1>

            </div>

            <div class="col-sm-6">
                <div class="account-wrapper">

                    <div class="account-body">

                        <div class="row">

                            <!-- Facebook login -->
                            <div class="text-center">
                                <a href="{{ route('social.login', ['facebook']) }}" class="btn btn-facebook">
                                    <i class="fa fa-facebook"></i>
                                    &nbsp;&nbsp;Mit Facebook anmelden
                                </a>

                            </div>

                            <div class="account-social-line col-xs-10 col-xs-offset-1">
                                <span class="account-or-social"></span>
                            </div>

                        </div>

                        <form class="form account-form" method="POST" action="{{ route('login') }}">

                            {{ csrf_field() }}

                            @include('partials.errors')

                            <div class="form-group">
                                <label for="email" class="placeholder-hidden">Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email"
                                       tabindex="1">
                            </div> <!-- /.form-group -->

                            <div class="form-group">
                                <label for="password" class="placeholder-hidden">Passwort</label>
                                <input type="password" class="form-control" name="password" id="password"
                                       placeholder="Passwort"
                                       tabindex="2">
                            </div> <!-- /.form-group -->

                            <div class="form-group clearfix">
                                <div class="account-remember">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" class=""
                                               {{ old('remember') ? 'checked' : '' }} tabindex="3">
                                        <small class="account-text">Eingeloggt bleiben</small>
                                    </label>
                                </div>

                                <div class="account-forget-pwd">
                                    <small><a href="{{ route('password.request') }}" class="account-link">Passwort
                                            vergessen?</a></small>
                                </div>
                            </div> <!-- /.form-group -->

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block" tabindex="4">Einloggen &nbsp; <i
                                            class="fa fa-play-circle"></i></button>
                            </div> <!-- /.form-group -->

                        </form>

                    </div> <!-- /.account-body -->
                    <div class="account-footer">
                        <p>
                            Noch keinen Account? &nbsp;
                            <a href="{{ route('register') }}" class="account-link">Account erstellen!</a>
                        </p>
                    </div> <!-- /.account-footer -->

                </div>
            </div>
        </div>

    </div>



@endsection
