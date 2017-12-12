@if (session('status') === 'profile_updated')
    @component('layouts.alerts.success')
        Dein Profil wurde erfolgreich angepasst.
    @endcomponent
@endif

<div class="g-pb-40">
    <h2 class="h4 g-font-weight-300">@lang('user.profile.title')</h2>
    <p>Ändere hier deinen Namen und deine Email-Adresse.</p>
</div>


@if ($user->newEmailRequiresVerification())
    <div class="alert alert-dismissible fade show g-bg-yellow rounded-0 g-my-30" role="alert">
        <button type="button" class="close u-alert-close--light" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <h4 class="h5">
            <i class="icon-info"></i>
            Neue Email Adresse!
        </h4>
        <p class="g-mb-10">
            Bitte bestätige deiner neue Email Adresse
            <strong>{{ $user->email_new }}</strong>. Einen Link dazu findest du in deinem Postfach.
        </p>
        <p>

            <a href="{{ route('users.emailCancel') }}" class="btn u-btn-outline-darkgray btn-xs rounded-0">
                <i class="fa fa-minus-circle g-mr-2"></i>
                Nicht ändern
            </a>

            <a href="{{ route('users.emailLink') }}" class="btn u-btn-darkgray btn-xs rounded-0">
                <i class="fa fa-check-circle g-mr-2"></i>
                Link erneut senden
            </a>

        </p>


    </div>
@endif

{!! Form::open(['route' => ['users.update'], 'method' => 'PUT', 'class' => '']) !!}

<input type="hidden" name="active_tab" value="profile">

<!-- First name -->
<div class="form-group row g-mb-25 {{ $errors->has('first_name') ? ' u-has-error-v1-2' : '' }}">
    <label class="col-sm-3 col-form-label g-color-gray-dark-v2 g-font-weight-700 text-sm-right g-mb-10">Vorname</label>
    <div class="col-sm-9">
        <div class="input-group g-brd-primary--focus">
            <input type="text" name="first_name" value="{{ $user->first_name }}"
                   class="form-control form-control-md border-right-0 rounded-0 g-py-13 pr-0"/>
            <div class="input-group-addon d-flex align-items-center g-bg-white g-color-gray-light-v1 rounded-0">
                <i class="icon-user"></i>
            </div>
        </div>
        <small class="form-control-feedback">{{ $errors->first('first_name') }}</small>
    </div>
</div>

<!-- Last name -->
<div class="form-group row g-mb-25 {{ $errors->has('last_name') ? ' u-has-error-v1-2' : '' }}">
    <label class="col-sm-3 col-form-label g-color-gray-dark-v2 g-font-weight-700 text-sm-right g-mb-10">Nachname</label>
    <div class="col-sm-9">
        <div class="input-group g-brd-primary--focus">
            <input type="text" name="last_name" value="{{ $user->last_name }}"
                   class="form-control form-control-md border-right-0 rounded-0 g-py-13 pr-0"/>
            <div class="input-group-addon d-flex align-items-center g-bg-white g-color-gray-light-v1 rounded-0">
                <i class="icon-user"></i>
            </div>
        </div>
        <small class="form-control-feedback">{{ $errors->first('last_name') }}</small>
    </div>
</div>

<!-- Current email -->
<div class="form-group row g-mb-25 u-has-disabled-v1">
    <label class="col-sm-3 col-form-label g-color-gray-dark-v2 g-font-weight-700 text-sm-right g-mb-10">Email
        Addresse</label>
    <div class="col-sm-9">
        <div class="input-group g-brd-primary--focus">
            <input type="text" name="email" value="{{ $user->email }}"
                   class="form-control form-control-md border-right-0 rounded-0 g-py-13 pr-0"/>
            <div class="input-group-addon d-flex align-items-center g-bg-white g-color-gray-light-v1 rounded-0">
                <i class="icon-communication-025 u-line-icon-pro"></i>
            </div>
        </div>
    </div>
</div>

<!-- New email -->
<div class="form-group row g-mb-25 {{ $errors->has('email_new') ? ' u-has-error-v1-2' : '' }}">
    <label class="col-sm-3 col-form-label g-color-gray-dark-v2 g-font-weight-700 text-sm-right g-mb-10">
        Neue Email
    </label>
    <div class="col-sm-9">
        <div class="input-group g-brd-primary--focus">
            <input type="text" name="email_new" value="{{ $user->email_new}}"
                   class="form-control form-control-md border-right-0 rounded-0 g-py-13 pr-0"/>
            <div class="input-group-addon d-flex align-items-center g-bg-white g-color-gray-light-v1 rounded-0">
                <i class="icon-communication-025 u-line-icon-pro"></i>
            </div>
        </div>
        <small class="form-control-feedback">{{ $errors->first('email_new') }}</small>
        <small class="form-text text-muted g-font-size-default g-mt-10">
            Wir schicken dir einen Bestätigungslink an deine neue Email Adresse.
        </small>
    </div>
</div>

<div class="text-sm-right g-pt-30">
    <button class="btn u-btn-primary rounded-0 g-py-12 g-px-25" type="submit">Speichern</button>
</div>

{!! Form::close() !!}

