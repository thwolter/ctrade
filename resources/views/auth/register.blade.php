@extends('layouts.master')

@section('content')

    <div class="account-wrapper">
        <div class="account-body">
            
            <h3>Kostenlosen Account erstellen.</h3>
           
            <form class="form account-form" role="form" method="POST" action="{{ route('register') }}">

                {{ csrf_field() }}
                
                @include('partials.errors')

                <!-- name input-->
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="placeholder-hidden">Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Name"
                           tabindex="1" value="{{ old('name') }}" required autofocus>
                </div> <!-- /name input-->

                <!-- email input -->
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="placeholder-hidden">Email</label>
                    <input type="text" name="email" class="form-control" id="email" placeholder="Email"
                           tabindex="2" value="{{ old('email') }}" required>
                </div> <!-- /email input -->

                <!-- password input -->
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="placeholder-hidden">Passwort</label>
                    <input type="password" name="password" class="form-control" id="password"
                           placeholder="Passwort" tabindex="3" required>
                </div> <!-- /password input -->

                <!-- password confirmation -->
                <div class="form-group">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                           placeholder="Passwort bestätigen" tabindex="4" required>
                </div> <!--/password confirmation -->

                <!-- checkbox -->
                <div class="form-group">
                    <label class="checkbox-inline">
                        <input type="checkbox" id="agree" name="checkbox" class="" tabindex="5"
                               value="true" {{ old('checkbox') ? 'checked' : '' }}>
                        Ich akzeptiere <a href="javascript:;" target="_blank">Terms of Service</a> &amp; <a href="javascript:;" target="_blank">Privacy Policy</a>
                    </label>
                </div> <!-- /checkbox -->

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block btn-lg" tabindex="6">
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
        
    </div> <!-- /.account-wrapper -->
@endsection

