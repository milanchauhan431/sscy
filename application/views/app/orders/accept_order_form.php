<form data-confirm_message="Are you sure to accept this order?">
    <div class="col-md-12">
        <div class="row">
            <input type="hidden" name="id" value="<?=$postData->id?>">
            <input type="hidden" name="trans_status" value="<?=$postData->trans_status?>">

            <div class="form-group basic animated">
                <div class="input-wrapper">
                    <label class="label" for="delivery_date">Est. Delivery Date</label>
                    <input type="date" class="form-control" name="delivery_date" id="delivery_date" placeholder="Enter Est. Delivery Date" min="<?=date("Y-m-d")?>" value="<?=date("Y-m-d")?>">
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                </div>
                <div class="error delivery_date"></div>
            </div>

        </div>
    </div>
</form>