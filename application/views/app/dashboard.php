<?php $this->load->view("app/includes/header"); ?>
<?php $this->load->view("app/includes/topbar"); ?>
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

.card .card-footer {
    border: 0;
    border-top: 1px solid #DCDCE9;
    padding: 0;
    display: block;
    text-align: right;
}
.card .card-footer .btn-inline {
    display: flex;
    margin: 0;
    background: #DCDCE9;
    border-radius: 0 0 16px 16px !important;
}
.card .card-footer .btn-inline .btn:first-child {
    border-radius: 0 0 0 16px !important;
}
.card .card-footer .btn-inline .btn:last-child {
    margin-right: 0;
    border-radius: 0 0 16px 0 !important;
}
.card .card-footer .btn-inline .btn {
    box-sizing: content-box;
    height: 1em;
    opacity: 1;
    padding: 0;
}
.card .card-footer .btn-inline .btn {
    width: 100%;
    border-radius: 0;
    min-height: 58px;
    border: 0 !important;
    font-size: 15px;
    margin-right: 1px;
    background: #FFF;
}
</style>
<!-- App Capsule -->
<div id="appCapsule">
    <div class="section mt-2">
        <div class="section-heading">
            <h2 class="title"><?=($this->loginId <= 1)?"Top 10 Items You Orderd":"New Orders"?></h2>
            <a href="<?=base_url("app/myOrders")?>" class="link">View All</a>
        </div>
        <div class="transactions" id="dasboardData">            
        </div>
    </div>
</div>
<!-- * App Capsule -->

<?php $this->load->view("app/includes/footer"); ?>
<?php if($this->loginId <= 1): ?>
<script>
$(document).ready(function(){
    getTopOrderItems();
});

function getTopOrderItems(){
    $.ajax({
        url: base_url + controller + '/getTopOrderItems',
        data: {},
        type: "POST",
        dataType:"json",
    }).done(function(response){
        var dataList = response.topItemList;
        if(dataList.length > 0){
            $("#dasboardData").html('');
            $.each(dataList,function(key,row){
                // Create the HTML structure using jQuery
                var item = $('<div>').addClass('item mb-1 mt-1');
                var detailDiv = $('<div>').addClass('detail');
                var image = $('<img>').attr('src', row.item_image).attr('alt', 'img').addClass('image-block imaged w48');
                var details = $('<div>').append(
                    $('<strong>').text(row.item_name),
                    $('<p>').text('Code: ' + row.item_code),
                    $('<p>').text('Group: ' + row.group_name),
                    $('<p>').text('Category: ' + row.category_name)
                );
                var rightDiv = $('<div>').addClass('right');
                var priceDiv = $('<div>').addClass('price text-center').html('Ord. Qty <br>' + row.qty);

                // Append the elements
                detailDiv.append(image, details);
                rightDiv.append(priceDiv);
                item.append(detailDiv, rightDiv);
                $('#dasboardData').append(item);
            });
        }else{
            $("#dasboardData").html('<div class="text-center">No data available</div>');
        }
    });
}
</script>
<?php else: ?>
<script>
$(document).ready(function(){
    getPendingOrderList();
});

function getPendingOrderList(){
    $.ajax({
        url: base_url + controller + '/getPendingOrderList',
        data: {},
        type: "POST",
        dataType:"json",
    }).done(function(response){
        var dataList = response.pendingOrderList;
        if(dataList.length > 0){
            $("#dasboardData").html('');
            $.each(dataList,function(key,row){
                console.log(row);
                // Create the HTML structure using jQuery
                var newOrder = $('<div>').addClass('section mt-2 mb-2');
                var cardDiv = $('<div>').addClass('card');
                var cardHeader = $('<div>').addClass('card-header').append(
                    $('<small>').addClass('float-start').text('Ord. No. : ' + row.trans_number),
                    $('<small>').addClass('float-end').text('Date : ' + row.trans_date)
                );
                var cardBody = $('<div>').addClass('card-body item');
                var detailDiv = $('<div>').addClass('detail');
                var productImage = $('<img>').attr('src', row.item_image).attr('alt', 'img').addClass('image-block imaged w48');
                var details = $('<div>').append(
                    $('<strong>').text(row.item_name),
                    $('<small>').text('Code : ' + row.item_code),
                    $('<small>').text('Group : ' + row.group_name),
                    $('<small>').text('Category : ' + row.category_name),
                    $('<small>').text('Qty. : ' + row.quantity),
                    $('<small>').text('Amt. : ' + row.amount)
                );
                var rightDiv = $('<div>').addClass('right text-right').append(
                    $('<span>').addClass('badge badge-warning p-15').css('border-radius', '10px').text(row.status)
                );
                var cardFooter = $('<div>').addClass('card-footer');
                var btnInline = $('<div>').addClass('btn-inline');
                
                //Button JSON object 
                var rejectJsonData = actionBtnJson({postData: {id: row.id,trans_status:4},controller : 'orders', fnsave:'changeOrderStatus',message : 'Are you sure want to cancel this Order?',res_function:'resOrderStatus'});
                var rejectBtn = $('<span class="btn btn-text-danger" href="javascript:void(0)" onclick="confirmStore(' + rejectJsonData + ');"><ion-icon name="close-circle-outline"></ion-icon> Reject Order</span>');
                
                var acceptJsonData = actionBtnJson({postData: {id: row.id,trans_status:1},controller : 'orders', fnsave:'changeOrderStatus',message : 'Are you sure want to Accept this Order?',res_function:'resOrderStatus'});
                var acceptBtn = $('<span class="btn btn-text-success" href="javascript:void(0)" onclick="confirmStore(' + acceptJsonData + ');"><ion-icon name="checkmark-circle-outline"></ion-icon> Accept Order</span>');

                btnInline.append(rejectBtn, acceptBtn);
                cardFooter.append(btnInline);

                // Append the elements
                detailDiv.append(productImage, details);
                cardBody.append(detailDiv, rightDiv);
                cardDiv.append(cardHeader, cardBody, cardFooter);
                newOrder.append(cardDiv);
                $('#dasboardData').append(newOrder);
            });
        }else{
            $("#dasboardData").html('<div class="text-center">No data available</div>');
        }
    });
}

function resOrderStatus(response){
    if(response.status==0){
        getPendingOrderList();
        toastbox('error',response.message, 3000);
    }else{
        getPendingOrderList();
        toastbox('success',response.message, 3000);
    }	
}
</script>
<?php endif; ?>