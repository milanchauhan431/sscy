<form>
    <div class="col-md-12">
        <div class="row">
            <input type="hidden" name="id" id="id" value="<?=(!empty($dataRow->id))?$dataRow->id:""?>">

            <div class="form-group basic">
                <div class="input-wrapper">
                    <label class="label" for="user_code">Kariger Code</label>
                    <input type="text" class="form-control" name="user_code" id="user_code" placeholder="Enter Kariger Code">
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                </div>
            </div>

            <div class="form-group basic">
                <div class="input-wrapper">
                    <label class="label" for="user_name">Kariger Name</label>
                    <input type="text" class="form-control" name="user_name" id="user_name" placeholder="Enter Kariger Name">
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                </div>
            </div>

        </div>
    </div>
</form>