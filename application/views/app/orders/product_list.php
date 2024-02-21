<?php $this->load->view("app/includes/header"); ?>
<style>
    .img-div{
        padding : 5px !important;
    }
    .card-img-top{
        border-radius: 10px !important;
        border: 1px solid #bcbcbc;
        height: 175px;
        object-fit: cover;    
    }
    .col-6 {
        display: flex !important;
        text-align: left;
    }
    .card{
        min-width: 100% !important;
    }
    .section {
        padding: 3px !important;
    }
    .lazy-load-tab .nav-item .badge{
        min-width: 16px;
        height: 16px;
        line-height: 9px !important;
        font-size: 10px;
        padding: 0 4px !important;
        position: absolute;
        top: 5px;
    }
    .lazy-load-tab .card-body {
        padding: 0px !important;
    }
</style>
<!-- App Header -->
<div class="appHeader">
    <div class="left">
        <a href="<?=base_url("app/dashboard")?>" class="headerButton goBack1 text-dark">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle"><?=(isset($headData->pageName)) ? $headData->pageName : '' ?></div>
    <div class="right">
        <a href="#" class="headerButton toggle-searchbox text-success">
            <ion-icon name="search-outline"></ion-icon>
        </a>       
    </div>
</div>
<!-- * App Header -->

<!-- Search Component -->
<div id="search" class="appHeader">
    <div class="form-group searchbox">
        <input type="text" class="form-control" id="commanSerach" placeholder="Search...">
        <i class="input-icon icon ion-ios-search"></i>
        <a href="#" class="ms-1 close toggle-searchbox" id="clearSerach"><i class="icon ion-ios-close-circle"></i></a>
    </div>
</div>
<!-- * Search Component -->

<!-- App Capsule -->
<div id="appCapsule">
    <div class="card lazy-load-tab">
        <div class="card-body pt-0">
            <ul class="nav nav-tabs lined m-t-5 m-b-5" role="tablist">
                <li class="nav-item filter" style="border-right:1px solid #DCDCE9">
                    <a href="javascript:void(0)" class="button fs-px-35 text-success">
                        <ion-icon name="filter-circle-outline"></ion-icon>
                    </a>          
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="button fs-px-35 text-success m-l-10">
                        <ion-icon name="cart-outline"></ion-icon>
                        <span class="badge badge-danger">4</span>
                    </a>
                </li>
            </ul>
        </div>        
    </div>

    <div class="section m-t-45" align="center">
        <div class="transactions col-12 row" id="lazy-load-trans" data-url="<?=base_url("app/orders/getProductListDTRows")?>" align="center">
        </div>

        <div id="lazyLoader" class="text-center  m-b-20" style="display:none;">
            <img src="<?=base_url("assets/dist/img/infinity-rb.gif")?>" width="80" alt="Loader">
        </div>
    </div>
</div>
<!-- * App Capsule -->

<div class="modal fade dialogbox" id="filter-modal" data-bs-backdrop="static" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filters</h5>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row">

                        <div class="form-group basic animated">
                            <div class="input-wrapper">
                                <label class="label" for="item_code">Code</label>
                                <select name="item_code" id="item_code" class="form-control selectBox select2">
                                    <option value="">Select Code</option>
                                    <?php
                                        /* foreach($itemGroupList as $row):
                                            $selected = (!empty($dataRow->group_id) && $dataRow->group_id == $row->id)?"selected":"";
                                            echo '<option value="'.$row->id.'" '.$selected.'>'.$row->group_name.'</option>';
                                        endforeach; */
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group basic animated">
                            <div class="input-wrapper">
                                <label class="label" for="group_id">Group</label>
                                <select name="group_id" id="group_id" class="form-control selectBox select2">
                                    <option value="">Select Group</option>
                                    <?php
                                        /* foreach($itemGroupList as $row):
                                            $selected = (!empty($dataRow->group_id) && $dataRow->group_id == $row->id)?"selected":"";
                                            echo '<option value="'.$row->id.'" '.$selected.'>'.$row->group_name.'</option>';
                                        endforeach; */
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group basic animated">
                            <div class="input-wrapper">
                                <label class="label" for="category_id">Category</label>
                                <select name="category_id" id="category_id" class="form-control selectBox select2">
                                    <option value="">Select Category</option>
                                    <?php
                                        /* foreach($itemGroupList as $row):
                                            $selected = (!empty($dataRow->group_id) && $dataRow->group_id == $row->id)?"selected":"";
                                            echo '<option value="'.$row->id.'" '.$selected.'>'.$row->group_name.'</option>';
                                        endforeach; */
                                    ?>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-inline">
                    <a href="#" class="btn btn-text-secondary" data-bs-dismiss="modal">CANCEL</a>
                    <a href="#" class="btn btn-text-success" data-bs-dismiss="modal">Apply</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view("app/includes/footer"); ?>

<script>
$(document).ready(function(){
    loadTransaction();
    $(document).on('click','.filter',function(){
        $("#filter-modal").modal("show");
        $("#filter-modal .select2").select2(); 
        setInputEvent();
    });
});

async function dataListing(response){
    var dataList = response.data;
    var totalRecords = response.recordsFiltered;
    if(dataList.length > 0){
        $.each(dataList,function(key,row){
            
            // Create a div with class "item"
            var itemDiv = $('<div class="col-6 section"></div>');

            // Create a div with class "detail"
            var detailDiv = $('<div class="card"></div>');

            // Create an image element with src attribute
            var imgElement = $('<div class="img-div"><img src="'+row.item_image+'" class="card-img-top" alt="image"></div>');

            // Create a div with a strong tag containing text
            var details = $('<div class="card-body"></div>');
            var itemName = $('<h5 class="card-title"></h5>').html(row.item_name);
            var itemCode = $('<h6 class="card-subtitle mb-1"></h6>').html("Code : "+row.item_code);
            var groupName = $('<h6 class="card-subtitle mb-1"></h6>').html("Group : "+row.group_name);
            var itemPrice = $('<h6 class="card-subtitle mb-1"></h6>').html("Price : "+row.price);    

            // Append the image and name div to the detail div
            detailDiv.append(imgElement, details);

            // Append Listing Details
            details.append(itemName, itemCode, groupName, itemPrice);

            //Create a card footer div
            var footerDiv = $('<div class="card-footer text-center"></div>');
            var addToCart = $('<span class="btn btn-warning">Add to Cart</span>');

            //Append Card Footer Button
            footerDiv.append(addToCart);

            //Append Card Footer
            detailDiv.append(footerDiv);

            // Append detail div and right div to the item div
            itemDiv.append(detailDiv);

            // Append the generated HTML to the container
            $('#lazy-load-trans').append(itemDiv);
        });
    }else{
        if(totalRecords <= 0){
            $("#lazy-load-trans").html('<div class="text-center">No data available</div>');
        }
    }
}
</script>