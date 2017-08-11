<div class="tab-pane fade in {{ active_tab('password') }}" id="password">

    <div class="heading-block">
        <h3>
            Change Password
        </h3>
    </div> <!-- /.heading-block -->

    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula
        eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient
        montes.</p>

    <br><br>

    <form action="./page-settings.html" class="form-horizontal">

        <div class="form-group">

            <label class="col-md-3 control-label">Old Password</label>

            <div class="col-md-7">
                <input type="password" name="old-password" class="form-control"/>
            </div> <!-- /.col -->

        </div> <!-- /.form-group -->


        <hr>


        <div class="form-group">

            <label class="col-md-3 control-label">New Password</label>

            <div class="col-md-7">
                <input type="password" name="new-password-1" class="form-control"/>
            </div> <!-- /.col -->

        </div> <!-- /.form-group -->


        <div class="form-group">

            <label class="col-md-3 control-label">New Password Confirm</label>

            <div class="col-md-7">
                <input type="password" name="new-password-2" class="form-control"/>
            </div> <!-- /.col -->

        </div> <!-- /.form-group -->


        <div class="form-group">

            <div class="col-md-7 col-md-push-3">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                &nbsp;
                <button type="reset" class="btn btn-default">Cancel</button>
            </div> <!-- /.col -->

        </div> <!-- /.form-group -->

    </form>

</div> <!-- /.tab-pane -->