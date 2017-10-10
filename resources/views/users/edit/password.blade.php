<div class="tab-pane fade" id="nav-1-1-default-hor-left-underline--2" role="tabpanel">
    <h2 class="h4 g-font-weight-300">Security Settings</h2>
    <p class="g-mb-25">Reset your password, change verifications and so on.</p>

    <form>
        <!-- Current Password -->
        <div class="form-group row g-mb-25">
            <label class="col-sm-3 col-form-label g-color-gray-dark-v2 g-font-weight-700 text-sm-right g-mb-10">Current password</label>
            <div class="col-sm-9">
                <div class="input-group g-brd-primary--focus">
                    <input class="form-control form-control-md border-right-0 rounded-0 g-py-13 pr-0" type="password" placeholder="Current password">
                    <div class="input-group-addon d-flex align-items-center g-bg-white g-color-gray-light-v1 rounded-0">
                        <i class="icon-lock"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Current Password -->

        <!-- New Password -->
        <div class="form-group row g-mb-25">
            <label class="col-sm-3 col-form-label g-color-gray-dark-v2 g-font-weight-700 text-sm-right g-mb-10">New password</label>
            <div class="col-sm-9">
                <div class="input-group g-brd-primary--focus">
                    <input class="form-control form-control-md border-right-0 rounded-0 g-py-13 pr-0" type="password" placeholder="New password">
                    <div class="input-group-addon d-flex align-items-center g-bg-white g-color-gray-light-v1 rounded-0">
                        <i class="icon-lock"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- End New Password -->

        <!-- Verify Password -->
        <div class="form-group row g-mb-25">
            <label class="col-sm-3 col-form-label g-color-gray-dark-v2 g-font-weight-700 text-sm-right g-mb-10">Verify password</label>
            <div class="col-sm-9">
                <div class="input-group g-brd-primary--focus">
                    <input class="form-control form-control-md border-right-0 rounded-0 g-py-13 pr-0" type="password" placeholder="Verify password">
                    <div class="input-group-addon d-flex align-items-center g-bg-white g-color-gray-light-v1 rounded-0">
                        <i class="icon-lock"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Verify Password -->


        <hr class="g-brd-gray-light-v4 g-my-25">

        <div class="text-sm-right">
            <a class="btn u-btn-darkgray rounded-0 g-py-12 g-px-25 g-mr-10" href="#">Cancel</a>
            <a class="btn u-btn-primary rounded-0 g-py-12 g-px-25" href="#">Save Changes</a>
        </div>
    </form>
</div>


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