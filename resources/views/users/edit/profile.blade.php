<div class="tab-pane fade in {{ active_tab('profile') }}" id="profile">

    <div class="heading-block">
        <h3>
            Mein Profil
        </h3>
    </div> <!-- /.heading-block -->

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @include('partials.errors')


    <p>Hier kannst du deinen Namen und deine Email-Adresse ändern. Zur Bestätigung deiner neuen
        Email-Adresse senden wir dir einen Bestätigungslink an deine neue Email.</p>

    <br><br>

    {!! Form::open(['route' => ['users.update'], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}

    <input type="hidden" name="tab" value="profile">
    <input type="hidden" name="id" value="{{ $user->id }}">

        <div class="form-group">

            <label class="col-md-3 control-label">Name</label>

            <div class="col-md-7">
                <input type="text" name="name" value="{{ $user->name }}"
                       class="form-control"/>
            </div> <!-- /.col -->

        </div> <!-- /.form-group -->


        @php($email = (session('email_new')) ? $user->email_new : $user->email)

        <div class="form-group">

            <label class="col-md-3 control-label">Email Addresse</label>

            <div class="col-md-7">
                <input type="text" name="email" value="{{ $email}}"
                       class="form-control"/>
            </div> <!-- /.col -->

        </div> <!-- /.form-group -->

        <div class="form-group">
            <div class="col-md-7 col-md-push-3">
                <button type="submit" class="btn btn-primary">Speichern</button>
                &nbsp;
                <button type="reset" class="btn btn-default">Abbrechen</button>
            </div> <!-- /.col -->
        </div> <!-- /.form-group -->

    {!! Form::close() !!}


</div> <!-- /.tab-pane -->