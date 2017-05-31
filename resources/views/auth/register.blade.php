@extends('layouts.master')

@section('content')

    <section id="content-region-3" class="padding-40 page-tree-bg">
        <div class="container">
            <h3 class="page-tree-text">
                Account erstellen
            </h3>
        </div>
    </section><!--page-tree end here-->
    <div class="space-70"></div>
    
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
