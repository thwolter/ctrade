<div class="tab-pane fade in {{ active_tab('password') }}" id="password">

    <div class="heading-block">
        <h3>@lang('user.password.title')</h3>
    </div> <!-- /.heading-block -->

    @include('partials.errors')

    <br><br>

    {!! Form::open(['route' => 'users.password', 'method' => 'PUT', 'class' => 'form form-horizontal']) !!}

    <input type="hidden" name="active_tab" value="password">
    <input type="hidden" name="id" value="{{ $user->id }}">

        @if($user->hasPassword())
            <div class="form-group">

                <label class="col-md-3 control-label">Password</label>

                <div class="col-md-7">
                    <input type="password" name="oldpassword" class="form-control"
                    placeholder="akutelles Passwort"/>
                </div> <!-- /.col -->

            </div> <!-- /.form-group -->


            <hr>
        @endif


        <div class="form-group">

            <label class="col-md-3 control-label">Neues Password</label>

            <div class="col-md-7">
                <input type="password" name="password" class="form-control" placeholder="Passwort" />
            </div> <!-- /.col -->

        </div> <!-- /.form-group -->


        <div class="form-group">

            <label class="col-md-3 control-label">Password bestätigen</label>

            <div class="col-md-7">
                <input type="password" name="password_confirmation" class="form-control"
                       placeholder="Passwort bestätigen" />
            </div> <!-- /.col -->

        </div> <!-- /.form-group -->


        <div class="form-group">

            <div class="col-md-7 col-md-push-3">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <button type="reset" class="btn btn-default">Cancel</button>
            </div> <!-- /.col -->

        </div> <!-- /.form-group -->

    {!! Form::close() !!}


</div> <!-- /.tab-pane -->