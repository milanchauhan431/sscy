<form>
    <div class="col-md-12">
        <div class="row">
            <input type="hidden" name="id" id="id" value="<?=(!empty($dataRow->id))?$dataRow->id:""?>">

            <div class="form-group basic animated">
                <div class="input-wrapper">
                    <label class="label" for="trans_date">Vou. Date</label>
                    <input type="date" class="form-control" name="trans_date" id="trans_date" placeholder="Enter Vou. Date" value="<?=(!empty($dataRow->trans_date))?$dataRow->trans_date:date("Y-m-d")?>">
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                </div>
                <div class="error trans_date"></div>
            </div>

            <div class="form-group basic animated">
                <div class="input-wrapper">
                    <label class="label" for="amount">Vou. Amount</label>
                    <input type="number" class="form-control floatOnly" name="amount" id="amount" placeholder="Enter Vou. Amount" value="<?=(!empty($dataRow->amount))?$dataRow->amount:""?>">
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                </div>
                <div class="error amount"></div>
            </div>

            <div class="form-group basic animated">
                <div class="input-wrapper">
                    <label class="label" for="remark">Vou. Remark</label>
                    <input type="text" class="form-control" name="remark" id="remark" placeholder="Enter Vou. Remark" value="<?=(!empty($dataRow->remark))?$dataRow->remark:""?>">
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                </div>
                <div class="error remark"></div>
            </div>
        </div>
    </div>
</form>