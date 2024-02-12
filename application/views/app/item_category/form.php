<form>
    <div class="col-md-12">
        <div class="row">
            <input type="hidden" name="id" id="id" value="<?=(!empty($dataRow->id))?$dataRow->id:""?>">

            <div class="form-group basic animated">
                <div class="input-wrapper">
                    <label class="label" for="category_name">Category Name</label>
                    <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Enter Category Name" value="<?=(!empty($dataRow->category_name))?$dataRow->category_name:""?>">
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                </div>
                <div class="error category_name"></div>
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