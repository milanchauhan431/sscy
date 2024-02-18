<form enctype="multipart/form-data">
    <div class="col-md-12">
        <div class="row">
            <input type="hidden" name="id" id="id" value="<?=(!empty($dataRow->id))?$dataRow->id:""?>">

            <div class="form-group basic animated">
                <div class="input-wrapper">
                    <label class="label" for="item_code">Kariger Code</label>
                    <input type="text" class="form-control" name="item_code" id="item_code" placeholder="Enter Kariger Code" value="<?=(!empty($dataRow->item_code))?$dataRow->item_code:$this->userCode?>" readonly />
                    <!-- <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i> -->
                </div>
                <div class="error item_code"></div>
            </div>

            <div class="form-group basic animated">
                <div class="input-wrapper">
                    <label class="label" for="item_name">Product Name</label>
                    <input type="text" class="form-control" name="item_name" id="item_name" placeholder="Enter Product Name" value="<?=(!empty($dataRow->item_name))?$dataRow->item_name:""?>">
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                </div>
                <div class="error item_name"></div>
            </div>

            <div class="form-group basic animated">
                <div class="input-wrapper">
                    <label class="label" for="group_id">Group</label>
                    <select name="group_id" id="group_id" class="form-control selectBox select2">
                        <option value="">Select Group</option>
                        <?php
                            foreach($itemGroupList as $row):
                                $selected = (!empty($dataRow->group_id) && $dataRow->group_id == $row->id)?"selected":"";
                                echo '<option value="'.$row->id.'" '.$selected.'>'.$row->group_name.'</option>';
                            endforeach;
                        ?>
                    </select>
                </div>
                <div class="error group_id"></div>
            </div>

            <div class="form-group basic animated">
                <div class="input-wrapper">
                    <label class="label" for="category_id">Category</label>
                    <select  id="category" data-input_id="category_id" data-placeholder="Select Category" class="form-control multiSelectBox multiselect" multiple="multiple">
                        <?php
                            foreach($itemCategoryList as $row):
                                $selected = (!empty($dataRow->category_id) && $dataRow->category_id == $row->id)?"selected":"";
                                echo '<option value="'.$row->id.'" '.$selected.'>'.$row->category_name.'</option>';
                            endforeach;
                        ?>
                    </select>
                    <input type="hidden" name="category_id" id="category_id" value="<?=(!empty($dataRow->category_id))?$dataRow->category_id:""?>">
                </div>
                <div class="error category_id"></div>
            </div>

            <div class="form-group basic animated">
                <div class="input-wrapper">
                    <label class="label" for="price">Price</label>
                    <input type="tel" class="form-control numericOnly" name="price" id="price" placeholder="Enter Price" value="<?=(!empty($dataRow->price))?$dataRow->price:""?>">
                    <i class="clear-input">
                        <ion-icon name="close-circle"></ion-icon>
                    </i>
                </div>
                <div class="error price"></div>
            </div>

            <div class="custom-file-upload m-t-10" id="fileUpload1">
                <input type="file" name="item_imgae" id="item_imgae" accept=".png, .jpg, .jpeg">
                <label for="item_imgae" style="background-image: url('<?=(!empty($dataRow->item_image))?base_url("assets/uploads/products/".$dataRow->item_image):""?>');" class="<?=(!empty($dataRow->item_image))?"file-uploaded":""?>">
                    <span>
                        <?php if(!empty($dataRow->item_image)): ?>
                            <?=$dataRow->item_image?>
                        <?php else: ?>
                        <strong>
                            <ion-icon name="arrow-up-circle-outline"></ion-icon>
                            <i>Upload a Photo</i>
                        </strong>
                        <?php endif; ?>
                    </span>
                </label>
                <div class="error item_imgae_error"></div>
            </div>
        </div>
    </div>
</form>