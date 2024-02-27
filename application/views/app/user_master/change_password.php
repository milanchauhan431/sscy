<form data-confirm_message="Are you sure to change password?">
    <div class="col-md-12">
        <div class="row">
            <div class="form-group basic animated">
                <div class="input-wrapper">
                    <label class="label" for="old_password">Old Password</label>
                    <input type="password" class="form-control" name="old_password" id="old_password" placeholder="Enter Old Password" value="">
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                </div>
                <div class="error old_password"></div>
            </div>

            <div class="form-group basic animated">
                <div class="input-wrapper">
                    <label class="label" for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" value="">
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                </div>
                <div class="error password"></div>
            </div>

            <div class="form-group basic animated">
                <div class="input-wrapper">
                    <label class="label" for="pass_code">Confirm Password</label>
                    <input type="text" class="form-control" name="pass_code" id="pass_code" placeholder="Enter Confirm Password" value="">
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                </div>
                <div class="error pass_code"></div>
            </div>
        </div>
    </div>
</form>