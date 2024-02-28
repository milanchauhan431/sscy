<div class="modal fade dialogbox" id="item-details-modal" data-bs-backdrop="static" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="max-width: 375px;">
            <div class="p-3 text-center">
                <img src="<?=$dataRow->item_image?>" alt="image" class="item-detail-img mb-1">
            </div>
            <div class="modal-header">
                <h5 class="modal-title"><?=$dataRow->item_name?></h5>
            </div>
            <div class="modal-body text-left custom-scrollbar">
                <div class="scrollbar">
                    <form id="item_detail">
                        <div class="hiddenInputs">
                            <input type="hidden" name="item_id" id="item_id" value="<?=$dataRow->id?>">
                            <input type="hidden" name="item_image" id="item_image" value="<?=$dataRow->item_image?>">
                            <input type="hidden" name="item_name" id="item_name" value="<?=$dataRow->item_name?>">
                            <input type="hidden" name="item_code" id="item_code" value="<?=$dataRow->item_code?>">
                            <input type="hidden" name="group_id" id="group_id" value="<?=$dataRow->group_id?>">
                            <input type="hidden" name="group_name" id="group_name" value="<?=$dataRow->group_name?>">
                            <input type="hidden" name="price" id="price" value="<?=$dataRow->price?>">
                            <input type="hidden" name="party_id" id="party_id" value="<?=$dataRow->created_by?>">
                        </div>

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    Code : <?=$dataRow->item_code?>
                                </div>
                                <div class="col-md-12">
                                    Group : <?=$dataRow->group_name?>
                                </div>
                                <div class="col-md-12">
                                    Price : <?=$dataRow->price?>
                                </div>
                                <hr>
                                <div class="col-md-12 form-group">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-left" style="width:70%;">Category</th>
                                                    <th scope="col" class="text-right" style="width:30%;">Qty</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach($dataRow->categoryList as $row):
                                                        echo '<tr>
                                                            <td style="width:70%;vertical-align: middle;">
                                                                '.$row->category_name.'
                                                                <input type="hidden" name="category_id['.$row->id.']" value="'.$row->id.'">
                                                                <input type="hidden" name="category_name['.$row->id.']" value="'.$row->category_name.'">
                                                            </td>
                                                            <td class="text-right" style="width:30%;">
                                                                <div class="qty-input float-end">
                                                                    <button class="qty-count qty-count--minus" data-action="minus" type="button">-</button>
                                                                    <input class="product-qty numericOnly" type="number" name="category_qty['.$row->id.']" min="0" max="10000" value="0" step="1" pattern="[0-9]*">
                                                                    <button class="qty-count qty-count--add" data-action="add" type="button">+</button>
                                                                </div>
                                                            </td>
                                                        </tr>';
                                                    endforeach;
                                                ?>                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-inline">
                    <span id="cancelItem" class="btn btn-text-secondary">Cancel</span>
                    <span id="addItem" class="btn btn-text-success">Add</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    var QtyInput = (function () {
        var $qtyInputs = $(".qty-input");

        if(!$qtyInputs.length) {
            return;
        }

        var $inputs = $qtyInputs.find(".product-qty");
        var $countBtn = $qtyInputs.find(".qty-count");
        var qtyMin = parseInt($inputs.attr("min"));
        var qtyMax = parseInt($inputs.attr("max"));

        $inputs.change(function () {
            var $this = $(this);
            var $minusBtn = $this.siblings(".qty-count--minus");
            var $addBtn = $this.siblings(".qty-count--add");
            var qty = parseInt($this.val());

            if (isNaN(qty) || qty <= qtyMin) {
                $this.val(qtyMin);
                $minusBtn.attr("disabled", true);
            } else {
                $minusBtn.attr("disabled", false);

                if (qty >= qtyMax) {
                    $this.val(qtyMax);
                    $addBtn.attr("disabled", true);
                } else {
                    $this.val(qty);
                    $addBtn.attr("disabled", false);
                }
            }
        });

        $countBtn.click(function () {
            var operator = this.dataset.action;
            var $this = $(this);
            var $input = $this.siblings(".product-qty");
            var qty = parseInt($input.val());

            if (operator == "add") {
                qty += 1;
                if (qty >= qtyMin + 1) {
                    $this.siblings(".qty-count--minus").attr("disabled", false);
                }

                if (qty >= qtyMax) {
                    $this.attr("disabled", true);
                }
            } else {
                qty = qty <= qtyMin ? qtyMin : (qty -= 1);

                if (qty == qtyMin) {
                    $this.attr("disabled", true);
                }

                if (qty < qtyMax) {
                    $this.siblings(".qty-count--add").attr("disabled", false);
                }
            }

            $input.val(qty);
        });
    })();
});
</script>