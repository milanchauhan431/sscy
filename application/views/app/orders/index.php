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
    padding: 10px 20px;
    margin-bottom: 0px;
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
    loadTransaction();
});

async function dataListing(response){
    var dataList = response.data;
    var totalRecords = response.recordsFiltered;
    if(dataList.length > 0){
        $.each(dataList,function(key,row){
            
            // Create a new div with the specified class and id
            var newDiv = $('<div>', {
                class: 'section mt-2 mb-2',
            });

            // Create the card element
            var card = $('<div>', {
                class: 'card'
            });

            // Create the card header
            var cardHeader = $('<div>', {
                class: 'card-header'
            });

            // Create the divs within the card header
            var orderNo = $('<small>', {
                class: 'float-start',
                text: "Ord. No. : "+row.trans_number
            });

            var orderDate = $('<small>', {
                class: 'float-end',
                text: "Date : "+row.trans_date
            });

            // Append the float-start and float-end divs to the card header
            cardHeader.append(orderNo, orderDate);

            // Create the card body
            var cardBody = $('<div>', {
                class: 'card-body item'
            });

            // Create the detail div
            var cardDetail = $('<div>', {
                class: 'detail'
            });

            // Create the image block
            var itemImage = $('<img>', {
                src: row.item_image,
                alt: 'img',
                class: 'image-block imaged w48'
            });

            // Create the div with product information
            var itemInfo = $('<div>').html(`
                <strong>`+row.item_name+`</strong>
                <small>Code : `+row.item_code+`</small><br>
                <small>Group : `+row.group_name+`</small><br>
                <small>Category : `+row.category_name+`</small><br>
                <small>Qty. : `+row.qty+`</small><br>
                <small>Amt. : `+row.amount+`</small><br>
                <small class="text-warning">Note : `+row.remark+`</small><br>
            `);

            // Append the image and information to the detail div
            cardDetail.append(itemImage, itemInfo);

            // Append the detail and card-button dropdown to the card body
            cardBody.append(cardDetail);

            <?php if($this->userRole <= 1): ?>

                // Create the action div
                var actionDiv = $('<div>', {
                    class: 'right text-right'
                });

                if(row.trans_status == 0){
                    // Create the card-button dropdown
                    var cardButton = $('<div>', {
                        class: 'card-button dropdown'
                    });

                    // Create the ellipsis button
                    var actionButton = $('<button>', {
                        type: 'button',
                        class: 'btn btn-link btn-icon',
                        'data-bs-toggle': 'dropdown'
                    }).html('<ion-icon name="ellipsis-horizontal" role="img" class="md hydrated" aria-label="ellipsis horizontal"></ion-icon>');

                    // Create the dropdown menu
                    var actionDropdown = $('<div>', {
                        class: 'dropdown-menu dropdown-menu-end'
                    });

                    //Button JSON object
                    var statusJsonData = actionBtnJson({postData: {id: row.id,trans_status:3},controller : 'orders', fnsave:'changeOrderStatus','message' : 'Are you sure want to cancel this Order?'});
                    var statusButton = $('<span class="dropdown-item" href="javascript:void(0)" onclick="confirmStore(' + statusJsonData + ');"><ion-icon name="close-circle-outline"></ion-icon> Cancel Order</span>');

                    // Append anchor tags to the dropdown menu
                    actionDropdown.append(statusButton);

                    // Append the button and dropdown menu to the card-button dropdown
                    cardButton.append(actionButton, actionDropdown);                    
                }else{
                    var cardButton = $('<small>', {
                        class : "text-dark",
                        html : "Rec. Qty. : "+row.dispatch_qty+"<br>"+"Amt. : "+(parseFloat(parseFloat(row.dispatch_qty) * parseFloat(row.price)).toFixed(2))
                    });                    
                }

                // Append the detail and card-button dropdown to the card body
                cardBody.append(actionDiv.append(cardButton));
                
            <?php else: ?>
                // Create the action div
                var actionDiv = $('<div>', {
                    class: 'right text-right'
                });

                if($.inArray(row.trans_status,['0','1']) !== -1){                    

                    // Create the card-button dropdown
                    var cardButton = $('<div>', {
                        class: 'card-button dropdown'
                    });

                    // Create the ellipsis button
                    var actionButton = $('<button>', {
                        type: 'button',
                        class: 'btn btn-link btn-icon',
                        'data-bs-toggle': 'dropdown'
                    }).html('<ion-icon name="ellipsis-horizontal" role="img" class="md hydrated" aria-label="ellipsis horizontal"></ion-icon>');

                    // Create the dropdown menu
                    var actionDropdown = $('<div>', {
                        class: 'dropdown-menu dropdown-menu-end'
                    });

                    //Button JSON object 
                    var rejectJsonData = actionBtnJson({postData: {id: row.id,trans_status:4},controller : 'orders', fnsave:'changeOrderStatus','message' : 'Are you sure want to cancel this Order?'});
                    var rejectButton = $('<span class="dropdown-item" href="javascript:void(0)" onclick="confirmStore(' + rejectJsonData + ');"><ion-icon name="close-circle-outline"></ion-icon> Reject Order</span>');

                    /* var acceptJsonData = actionBtnJson({postData: {id: row.id,trans_status:1},modal_id:'dialogbox-sm',call_function:'acceptOrder',controller : 'orders', fnsave:'changeOrderStatus', form_id : 'acceptOrder',js_store_fn:'confirmStore',title:'Accept Order [Ord No. : '+row.trans_number+']'});
                    var acceptButton = $('<span class="dropdown-item" href="javascript:void(0)" onclick="modalAction(' + acceptJsonData + ');"><ion-icon name="checkmark-circle-outline"></ion-icon> Accept Order</span>'); */

                    var acceptJsonData = actionBtnJson({postData: {id: row.id,trans_status:1},controller : 'orders', fnsave:'changeOrderStatus','message' : 'Are you sure want to Accept this Order?'});
                    var acceptButton = $('<span class="dropdown-item" href="javascript:void(0)" onclick="confirmStore(' + acceptJsonData + ');"><ion-icon name="checkmark-circle-outline"></ion-icon> Accept Order</span>');

                    
                    var disptchButton = "";
                    if(row.trans_status == 1){
                        acceptButton = rejectButton = "";

                        var disptchJsonData = actionBtnJson({postData: {id: row.id,trans_status:2},modal_id:'dialogbox-sm',call_function:'dispatchOrder',controller : 'orders', fnsave:'changeOrderStatus', form_id : 'dispatchOrder',js_store_fn:'confirmStore',title:'Dispatch Order [Ord No. : '+row.trans_number+']'});

                        disptchButton = $('<span class="dropdown-item" href="javascript:void(0)" onclick="modalAction(' + disptchJsonData + ');"><ion-icon name="checkmark-circle-outline"></ion-icon> Diaptch Order</span>');
                    }

                    if(row.trans_status == 2){ disptchButton = acceptButton = rejectButton = ""; }

                    // Append anchor tags to the dropdown menu
                    actionDropdown.append(acceptButton,rejectButton,disptchButton);

                    // Append the button and dropdown menu to the card-button dropdown
                    cardButton.append(actionButton, actionDropdown);                    
                }else{
                    var cardButton = $('<small>', {
                        class : "text-dark",
                        html : "Disp. Qty. : "+row.dispatch_qty+"<br>"+"Amt. : "+(parseFloat(parseFloat(row.dispatch_qty) * parseFloat(row.price)).toFixed(2))
                    });
                }

                // Append the detail and card-button dropdown to the card body
                cardBody.append(actionDiv.append(cardButton));
            <?php endif; ?>           

            // Create the card footer
            var cardFooter = $('<div>', {
                class: 'card-footer text-center'
            });

            // Create the status badge
            var bage_class = "";
            if(row.trans_status == 0){ bage_class = "badge-warning"; }
            if(row.trans_status == 1){ bage_class = "badge-primary"; }
            if(row.trans_status == 2){ bage_class = "badge-success"; }
            if(row.trans_status == 3){ bage_class = "badge-dark"; }
            if(row.trans_status == 4){ bage_class = "badge-danger"; }
            var orderStatus = $('<span>', {
                class: 'badge '+bage_class+' p-15',
                style: 'border-radius: 10px',
                text: row.order_status
            });

            // Append the status badge to the card footer
            cardFooter.append(orderStatus);

            // Append the card header, card body, and card footer to the card
            card.append(cardHeader, cardBody, cardFooter);

            // Append the card to the new div
            newDiv.append(card);

            // Append the generated HTML to the container
            $('#lazy-load-trans').append(newDiv);
        });
    }else{
        if(totalRecords <= 0){
            $("#lazy-load-trans").html('<div class="text-center">No data available</div>');
        }
    }
}
</script>