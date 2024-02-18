<form>
    <div class="col-md-12">
        <div class="row">
            <input type="hidden" name="id" id="id" value="<?=(!empty($dataRow->id))?$dataRow->id:""?>">

            <div class="form-group basic animated">
                <div class="input-wrapper">
                    <label class="label" for="group_name">Group Name</label>
                    <input type="text" class="form-control" name="group_name" id="group_name" placeholder="Enter Group Name" value="<?=(!empty($dataRow->group_name))?$dataRow->group_name:""?>">
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                </div>
                <div class="error group_name"></div>
            </div>

            <div class="form-group basic animated">
                <div class="input-wrapper">
                    <label class="label" for="remark">Remark</label>
                    <input type="text" class="form-control" name="remark" id="remark" placeholder="Enter Remark" value="<?=(!empty($dataRow->remark))?$dataRow->remark:""?>">
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                </div>
                <div class="error remark"></div>
            </div>

        </div>
    </div>
</form>