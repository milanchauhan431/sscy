<form data-confirm_message="Are you sure to dispatch this order?">
    <div class="col-md-12">
        <div class="row">
            <input type="hidden" name="id" value="<?=$dataRow->id?>">
            <input type="hidden" name="trans_status" value="2">

            <div class="form-group basic animated">
                <div class="input-wrapper">
                    <label class="label" for="dispatch_qty">Dispatch Qty.</label>
                    <input type="number" class="form-control" name="dispatch_qty" id="dispatch_qty" placeholder="Enter Dispatch Qty." min="1" value="<?=$dataRow->qty?>">
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                </div>
                <div class="error dispatch_qty"></div>
            </div>

        </div>
    </div>
</form>