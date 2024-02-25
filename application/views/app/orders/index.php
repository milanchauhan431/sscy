<?php $this->load->view("app/includes/header"); ?>
<style>
.imaged.w48 {
    width: 100px !important;
    height: 100px; /* Adjust the height as per your requirement */
    object-fit: cover; /* This property ensures the image maintains its aspect ratio */
    margin-left: -12px !important;
    border: 1px solid #000000;
}

.transactions .item {
    background: #ffffff;
    box-shadow: none;
    border-radius: 10px;
    padding: 20px 24px;
    margin-bottom: 10px;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
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
    <div class="section m-t-10">
        <div class="transactions" id="lazy-load-trans" data-url="<?=base_url("app/orders/getMyOrdersDTRows")?>">

            <div class="section mt-2" id="div11">
                <div class="card">
                    <div class="card-header">
                        <div class="float-start">#1</div>
                        <div class="float-end">26-02-2023</div>
                    </div>
                    <div class="card-body item mb-2">
                        <div class="detail">
                            <img src="<?=base_url("assets/uploads/products/1708527366_PRD_17085273524479168839729157033747_jpg.jpg")?>" alt="img" class="image-block imaged w48">

                            <div>
                                <strong>Product 5</strong>
                                <small>Code : M001</small><br>
                                <small>Group : Test Group 3</small><br>
                                <small>Category : Category 1</small><br>
                                <small>Qty. : 1.00</small><br>
                                <small>Amt. : 200.00</small><br>                                
                            </div>
                        </div>

                        <div class="right">
                            <div class="card-button dropdown">
                                <button type="button" class="btn btn-link btn-icon" data-bs-toggle="dropdown">
                                    <ion-icon name="ellipsis-horizontal" role="img" class="md hydrated" aria-label="ellipsis horizontal"></ion-icon>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end"></div>
                            </div>
                        </div>                        
                    </div>
                    <div class="card-footer text-center">
                        <span>Status : <span class="badge badge-dark">Pending</span></span>
                    </div>
                </div>
            </div>

        </div>

        <div id="lazyLoader" class="text-center  m-b-20" style="display:none;">
            <img src="<?=base_url("assets/dist/img/infinity-rb.gif")?>" width="80" alt="Loader">
        </div>
    </div>
</div>
<!-- * App Capsule -->

<?php $this->load->view("app/includes/footer"); ?>

<script>
$(document).ready(function(){
    //loadTransaction();
});

async function dataListing(response){
    var dataList = response.data;
    var totalRecords = response.recordsFiltered;
    if(dataList.length > 0){
        $.each(dataList,function(key,row){
            
            // Create a div with class "item"
            var itemDiv = $('<div class="item mb-2"></div>');

            // Create a div with class "detail"
            var detailDiv = $('<div class="detail"></div>');

            // Create an image element with src attribute
            var imgElement = $('<img src="'+row.item_image+'" alt="img" class="image-block imaged w48">');

            // Create a div with a strong tag containing text
            var details = $('<div></div>');
            var itemName = $("<strong></strong>").html(row.item_name);
            var itemCode = $("<small></small>").html("Code : "+row.item_code);
            var groupName = $("<small></small>").html("Group : "+row.group_name);
            var categoryName = $("<small></small>").html("Category : "+row.category_name);
            var qty = $("<small></small>").html("Qty. : "+row.qty);
            var amount = $("<small></small>").html("Amt. : "+row.amount);
            var ordStatus = $("<small></small>").html("Status : "+row.order_status);

            // Append the image and name div to the detail div
            detailDiv.append(imgElement, details);

            // Append Listing Details
            details.append(itemName, itemCode, "<br>", groupName, "<br>", categoryName, "<br>", qty, "<br>", amount, "<br>", ordStatus);

            // Create a div with class "right"
            var rightDiv = $('<div class="right"></div>');

            // Create a div with class "card-button dropdown"
            var cardButtonDiv = $('<div class="card-button dropdown"></div>');

            // Create a button with data-bs-toggle attribute
            var buttonElement = $('<button type="button" class="btn btn-link btn-icon" data-bs-toggle="dropdown"><ion-icon name="ellipsis-horizontal"></ion-icon></button>');

            // Create a div with class "dropdown-menu dropdown-menu-end"
            var dropdownMenu = $('<div class="dropdown-menu dropdown-menu-end"></div>');

            // JSON object
            //var editJsonData = actionBtnJson({postData: {id: row.id}, modal_id : 'ModalBasic', controller : 'itemMaster', call_function:'edit', form_id : 'itemForm', title : 'Update Product'});
            //var deleteJsonData = actionBtnJson({postData: {id: row.id},'message' : 'Product'});

            // Create anchor tag with onclick attribute
            var editLink = '';//$('<span class="dropdown-item" href="javascript:void(0)" onclick="modalAction(' + editJsonData + ');"><ion-icon name="pencil-outline"></ion-icon>Edit</span>');

            var removeLink = '';//$('<span class="dropdown-item" href="javascript:void(0)" onclick="trash(' + deleteJsonData + ');"><ion-icon name="trash"></ion-icon>Remove</span>');
            
            // Append anchor tags to the dropdown menu
            dropdownMenu.append(editLink, removeLink);

            // Append the button and dropdown menu to the card-button div
            cardButtonDiv.append(buttonElement, dropdownMenu);

            // Append detail div and right div to the item div
            itemDiv.append(detailDiv, rightDiv.append(cardButtonDiv));

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