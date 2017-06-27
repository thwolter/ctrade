@extends('layouts.master')


@section('content')

   @include('auth.partials.header')

    <div class="account-wrapper">
        <div class="account-body">
            <h3>Kostenlosen Account einrichten.</h3>
            <h5>Anmeldung in nur 30 Sekunden.</h5>
            <form class="form account-form" method="POST" action="{{ route('register') }}">

                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="placeholder-hidden">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Name" tabindex="1">

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div> <!-- /.form-group -->

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="placeholder-hidden">Email</label>
                    <input type="text" class="form-control" id="email" placeholder="Email" tabindex="2">

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div> <!-- /.form-group -->

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="placeholder-hidden">Passwort</label>
                    <input type="password" class="form-control" id="password" placeholder="Passwort" tabindex="3">

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div> <!-- /.form-group -->

                <div class="form-group">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                           placeholder="Passwort bestätigen" tabindex="4">
                </div>

                <div class="form-group">
                    <label class="checkbox-inline">
                        <input type="checkbox" class="" value="" tabindex="5"> I agree to the <a href="javascript:;" target="_blank">Terms of Service</a> &amp; <a href="javascript:;" target="_blank">Privacy Policy</a>
                    </label>
                </div> <!-- /.form-group -->

                <div class="form-group">
                    <button type="submit" class="btn btn-secondary btn-block btn-lg" tabindex="6">
                        Account erstellen &nbsp; <i class="fa fa-play-circle"></i>
                    </button>
                </div> <!-- /.form-group -->

            </form>

        </div> <!-- /.account-body -->

        <div class="account-footer">
            <p>
                Du hast schon einen Account? &nbsp;
                <a href="{{ route('login') }}" class="">Hier Einloggen!</a>
            </p>
        </div> <!-- /.account-footer -->
        @endsection

@section('content')
    
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="panel panel-default">
                    <div class="my-login-form">
                        
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}
                            
                            <h4 class="text-uppercase">Registrieren</h4><hr>
    
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <input id="name" type="text" class="form-control" name="name" placeholder="Name.." value="{{ old('name') }}" required autofocus>
    
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
    
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <input id="email" type="email" class="form-control" name="email" placeholder="Email.." value="{{ old('email') }}" required>
    
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
    
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <input id="password" type="password" class="form-control" name="password" placeholder="Passwort.." required>
    
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
    
                            <div class="form-group">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Passwort bestätigen.." required>
                            </div>
    
                            <div class="text-right">
                                <button type="submit" class="btn theme-btn-color">
                                    Registrieren
                                </button>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
