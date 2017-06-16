@extends('layouts.master')

@section('content')

    <section id="content-region-3" class="padding-40 page-tree-bg">
        <div class="container">
            <h3 class="page-tree-text">
                Login into your account
            </h3>
        </div>
    </section><!--page-tree end here-->
    <div class="space-70"></div>

    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="panel panel-default">
                    <div class="my-login-form">

                        <form role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                            <h4 class="text-uppercase">Login</h4><hr>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <input id="email" type="email" class="form-control" name="email" placeholder="Email.." value="{{ old('email') }} " required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                                <input id="password" type="password" class="form-control" name="password" placeholder="Password.." required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Eingeloggt bleiben
                                    </label>
                                </div>
                            </div>

                            <div class="text-right">
                                <button type="submit" class="btn theme-btn-color">Login</button>
                            </div>
                            <hr>

                            <div class="form-btm-link text-center">
                                <a class="btn btn-link" href="{{ route('password.request') }}">Passwort vergessen?</a>
                                <span>oder</span>
                                <a class="btn btn-link" href="{{ route('register') }}">Account erstellen</a>
                            </div>

                        </form><!--login form end-->
                    </div>
                </div>
            </div>
            <div class="space-70"></div>
            <div class="space-70"></div>
        </div>
    </div>
@endsection
