@if (session('status') === 'password_changed')
    @component('layouts.alerts.success')
        Dein Passwort wurde geändert.
    @endcomponent
@endif

<div class="g-pb-40">
    <h2 class="h4 g-font-weight-300">@lang('user.password.title')</h2>
    <p class="g-mb-25">Setze dein Passwort zurück.</p>
</div>

{!! Form::open(['route' => 'users.password', 'method' => 'PUT', 'class' => 'form form-horizontal']) !!}

<input type="hidden" name="active_tab" value="password">

@if($user->hasPassword())
    <!-- Old Password -->
    <div class="form-group row g-mb-25 {{ $errors->has('oldpassword') ? ' u-has-error-v1-2' : '' }}">
        <label class="col-sm-3 col-form-label g-color-gray-dark-v2 g-font-weight-700 text-sm-right g-mb-10">
            Aktuelles Passwort
        </label>
        <div class="col-sm-9">
            <div class="input-group g-brd-primary--focus">
                <input type="password" name="oldpassword" placeholder="aktuelles Passwort"
                       class="form-control form-control-md border-right-0 rounded-0 g-py-13 pr-0"/>
                <div class="input-group-addon d-flex align-items-center g-bg-white g-color-gray-light-v1 rounded-0">
                    <i class="icon-user"></i>
                </div>
            </div>
            <small class="form-control-feedback">{{ $errors->first('oldpassword') }}</small>
        </div>
    </div>

@endif

<!-- New Password -->
<div class="form-group row g-mb-25 {{ $errors->has('password') ? ' u-has-error-v1-2' : '' }}">
    <label class="col-sm-3 col-form-label g-color-gray-dark-v2 g-font-weight-700 text-sm-right g-mb-10">Neues
        Passwort</label>
    <div class="col-sm-9">
        <div class="input-group g-brd-primary--focus">
            <input type="password" name="password" placeholder="Passwort"
                   class="form-control form-control-md border-right-0 rounded-0 g-py-13 pr-0"/>
            <div class="input-group-addon d-flex align-items-center g-bg-white g-color-gray-light-v1 rounded-0">
                <i class="icon-user"></i>
            </div>
        </div>
        <small class="form-control-feedback">{{ $errors->first('password') }}</small>
    </div>
</div>


<!-- Confirm Password -->
<div class="form-group row g-mb-25 {{ $errors->has('password_confirmation') ? ' u-has-error-v1-2' : '' }}">
    <label class="col-sm-3 col-form-label g-color-gray-dark-v2 g-font-weight-700 text-sm-right g-mb-10">Password
        bestätigen</label>
    <div class="col-sm-9">
        <div class="input-group g-brd-primary--focus">
            <input type="password" name="password_confirmation" placeholder="Passwort bestätigen"
                   class="form-control form-control-md border-right-0 rounded-0 g-py-13 pr-0"/>
            <div class="input-group-addon d-flex align-items-center g-bg-white g-color-gray-light-v1 rounded-0">
                <i class="icon-user"></i>
            </div>
        </div>
        <small class="form-control-feedback">{{ $errors->first('password_confirmation') }}</small>
    </div>
</div>


<div class="text-sm-right g-pt-30">
    <button class="btn u-btn-primary rounded-0 g-py-12 g-px-25" type="submit">Speichern</button>
</div>

{!! Form::close() !!}


