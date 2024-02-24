<form>
    <div class="col-md-12">
        <div class="row">
            <input type="hidden" name="id" id="id" value="<?=(!empty($dataRow->id))?$dataRow->id:""?>">
            <input type="hidden" name="user_role" id="user_role" value="2">

            <div class="form-group basic animated">
                <div class="input-wrapper">
                    <label class="label" for="user_code">Kariger Code</label>
                    <input type="text" class="form-control" name="user_code" id="user_code" placeholder="Enter Kariger Code" value="<?=(!empty($dataRow->user_code))?$dataRow->user_code:""?>" <?=(!empty($dataRow->user_code))?"readonly":""?>>

                    <?php if(empty($dataRow)): ?>
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                    <?php endif; ?>
                </div>
                <div class="error user_code"></div>
            </div>

            <div class="form-group basic animated">
                <div class="input-wrapper">
                    <label class="label" for="user_name">Kariger Name</label>
                    <input type="text" class="form-control" name="user_name" id="user_name" placeholder="Enter Kariger Name" value="<?=(!empty($dataRow->user_name))?$dataRow->user_name:""?>">
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                </div>
                <div class="error user_name"></div>
            </div>

            <div class="form-group basic animated">
                <div class="input-wrapper">
                    <label class="label" for="mobile_no">Mobile No.</label>
                    <input type="number" class="form-control numericOnly" name="mobile_no" id="mobile_no" placeholder="Enter Mobile No." value="<?=(!empty($dataRow->mobile_no))?$dataRow->mobile_no:""?>">
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                </div>
                <div class="error mobile_no"></div>
            </div>

            <div class="form-group basic animated">
                <div class="input-wrapper">
                    <label class="label" for="city">City</label>
                    <input type="text" class="form-control" name="city" id="city" placeholder="Enter City" value="<?=(!empty($dataRow->city))?$dataRow->city:""?>">
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                </div>
                <div class="error city"></div>
            </div>

            <?php if(empty($dataRow->id)): ?>
            <div class="form-group basic animated">
                <div class="input-wrapper">
                    <label class="label" for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" value="<?=(!empty($dataRow->password))?$dataRow->password:""?>">
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                </div>
                <div class="error password"></div>
            </div>

            <div class="form-group basic animated">
                <div class="input-wrapper">
                    <label class="label" for="pass_code">Confirm Password</label>
                    <input type="text" class="form-control" name="pass_code" id="pass_code" placeholder="Enter Confirm Password" value="<?=(!empty($dataRow->pass_code))?$dataRow->pass_code:""?>">
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                </div>
                <div class="error pass_code"></div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</form>