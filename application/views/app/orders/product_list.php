<?php $this->load->view("app/includes/header"); ?>
<style>
    .cart-item {
    background: #ffffff;
    border-radius: 10px;
    display: flex;
    align-items: center;
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
<div id="appCapsule" class="orderPage">
    <div class="card lazy-load-tab">
        <div class="card-body pt-0">
            <ul class="nav nav-tabs lined m-t-5 m-b-5" role="tablist">
                <li class="nav-item filter" style="border-right:1px solid #DCDCE9">
                    <a href="javascript:void(0)" class="button fs-px-35 text-success" id="filter-btn">
                        <ion-icon name="filter-outline"></ion-icon>
                    </a>          
                </li>
                <li class="nav-item">
                    <a href="javascript:void(0)" class="button fs-px-35 text-success m-l-10" id="view-cart-btn">
                        <ion-icon name="cart-outline"></ion-icon>
                        <span class="badge badge-danger">0</span>
                    </a>
                </li>
            </ul>
        </div>        
    </div>

    <div class="section m-t-45" align="center">
        <div class="transactions col-12 row" id="lazy-load-trans" data-url="<?=base_url("app/orders/getProductListDTRows")?>" data-filter_page_name="orders" align="center">
        </div>

        <div id="lazyLoader" class="text-center  m-b-20" style="display:none;">
            <img src="<?=base_url("assets/dist/img/infinity-rb.gif")?>" width="80" alt="Loader">
        </div>
    </div>
</div>
<!-- * App Capsule -->

<?php 
    $this->load->view("app/includes/footer"); 
    $this->load->view("app/orders/filter_form");
    $this->load->view("app/orders/view_cart");
?>

<div id="item-detail-html"></div>

<script>
$(document).ready(function(){
    loadTransaction();
    //$("#view-cart").modal("show");
    $(document).on('click','.filter',function(){
        $("#filter-modal").modal("show");
        $("#filter-modal .select2").select2(); 
        setInputEvent();
    });

    $(document).on('click','#addItem',function(){
        $(this).prop('disabled',true);
        //item_detail
        var form = $('#item_detail')[0], formData = {}; 
        var fd = new FormData(form);
        $.ajax({ 
            url: base_url + controller + '/formatCartItemData',   
            data:fd,
			type: "POST",
			processData:false,
			contentType:false,
            dataType:"json"
        }).done(function(response){
            console.log(response);
        });
    });

    $(document).on('click','#cancelItem',function(){
        $("#item-details-modal").modal("hide");
        $("#item-detail-html").html("");
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
            var addToCart = $('<span class="btn btn-warning '+row.id+row.group_id+'" onclick="itemDetail('+row.id+');">Add to Cart</span>');

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

function itemDetail(id=""){
    if(id){
        $.ajax({ 
            type: "POST",   
            url: base_url + controller + '/getItemDetail',   
            data: {id:id},
        }).done(function(response){
            $("#item-detail-html").html("");
            $("#item-detail-html").html(response);
            $("#item-details-modal").modal("show");
        });
    }
}
</script>