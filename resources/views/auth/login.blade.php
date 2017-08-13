@extends('layouts.master')

@section('content')

    <div class="account-wrapper">

    <div class="account-body">
        <h3>Willkommen bei ctrade.</h3>
        <h5>Bitte melde dich an.</h5>
        <br>
        <div class="row">

            <!-- Facebook login -->
            <div class="col-sm-8 col-sm-offset-2">
                <a href="{{ route('social.login', ['facebook']) }}" class="btn btn-facebook btn-block">
                    <i class="fa fa-facebook"></i>
                    &nbsp;&nbsp;Mit Facebook anmelden
                </a>
            </div> <!-- /.col -->

        </div> <!-- /.row -->

        <span class="account-or-social text-muted">ODER</span>

        <form class="form account-form" method="POST" action="{{ route('login') }}">

            {{ csrf_field() }}
            
            @include('partials.errors')

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="placeholder-hidden">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Email" tabindex="1">
            </div> <!-- /.form-group -->

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="placeholder-hidden">Passwort</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Passwort" tabindex="2">
            </div> <!-- /.form-group -->

            <div class="form-group clearfix">
                <div class="pull-left">
                    <label class="checkbox-inline">
                        <input type="checkbox" class="" {{ old('remember') ? 'checked' : '' }} tabindex="3"> <small>Remember me</small>
                    </label>
                </div>

                <div class="pull-right">
                    <small><a href="{{ route('password.request') }}">Passwort vergessen?</a></small>
                </div>
            </div> <!-- /.form-group -->

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block" tabindex="4">Einloggen &nbsp; <i class="fa fa-play-circle"></i></button>
            </div> <!-- /.form-group -->

        </form>

    </div> <!-- /.account-body -->

    <div class="account-footer">
        <p>
            Noch keinen Account? &nbsp;
            <a href="{{ route('register') }}" class="">Account erstellen!</a>
        </p>
    </div> <!-- /.account-footer -->

</div> <!-- /.account-wrapper -->

@endsection

@section('scripts.footer')

@endsection
