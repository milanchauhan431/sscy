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
                <li class="nav-item view-cart-btn">
                    <a href="javascript:void(0)" class="button fs-px-35 text-success m-l-10" >
                        <ion-icon name="cart-outline"></ion-icon>
                        <span class="badge badge-danger" id="cart-item-count">0</span>
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
    countCartItems();
    
    $(document).on('click','.filter',function(){
        $("#filter-modal").modal("show");
        $("#filter-modal .select2").select2(); 
        setInputEvent();
    });

    //localStorage.removeItem("cartItems");    
    $(document).on('click','#addItem',function(){
        $(this).prop('disabled',true);
        //item_detail
        var form = $('#item_detail')[0], formData = {}; 
        var fd = new FormData(form);
        $.ajax({ 
            url: base_url + controller + '/formatCartItemData',   
            data:fd,
			type:"POST",
            async:true,
			processData:false,
			contentType:false,
            dataType:"json"
        }).done(function(response){
            $("#item-details-modal").modal("hide");
            $("#item-detail-html").html("");
            
            //Add item in cart local storage
            var cartItems = localStorage.getItem("cartItems");
            cartItems = $.extend({}, JSON.parse(cartItems), response);
            localStorage.setItem("cartItems",JSON.stringify(cartItems));
            countCartItems();            
        });
    });    

    $(document).on('click','#cancelItem',function(){
        $("#item-details-modal").modal("hide");
        $("#item-detail-html").html("");
    });

    $(document).on('click','.view-cart-btn',function(){
        $("#view-cart-modal").modal("show");        
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

            var count_cart_item = $("."+row.id+row.group_id).length;
            //Create a card footer div
            var footerDiv = $('<div class="card-footer text-center" id="action-btn-'+row.id+row.group_id+'"></div>');
            if(count_cart_item > 0){
                var addToCart = $('<span class="btn btn-warning btn-cart-view view-cart-btn" >View Cart ('+count_cart_item+')</span>');
            }else{
                var addToCart = $('<span class="btn btn-warning btn-cart" onclick="itemDetail('+row.id+');">Add to Cart</span>');
            }

            //Append Card Footer Button
            footerDiv.append(addToCart);

            //Append Card Footer
            detailDiv.append(footerDiv);

            // Append detail div and right div to the item div
            itemDiv.append(detailDiv);

            // Append the generated HTML to the container
            $('#lazy-load-trans').append(itemDiv);
        });

        countCartItems();
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

function countCartItems(){
    var cartItemList = localStorage.getItem("cartItems");

    //Append Cart Items
    if(cartItemList != null){
        $("#view-cart-modal #cartItemList").html("");
        cartItemList = JSON.parse(cartItemList);
        $("#cart-item-count").html(Object.keys(cartItemList).length);
        $.each(cartItemList,function(key,row){
            
            // Create a new div with the specified class and id
            var itemDiv = $('<div>', {
                class: 'section mt-2 '+row.item_id+row.group_id,
                id: key
            });

            // Create the card element
            var card = $('<div>', {
                class: 'card'
            });

            // Create the card body
            var cardBody = $('<div>', {
                class: 'card-body'
            });

            // Create the cart item
            var cartItem = $('<div>', {
                class: 'cart-item'
            });

            // Create the detail div
            var itemDetail = $('<div>', {
                class: 'detail'
            });

            // Create the image block
            var itemImage = $('<img>', {
                src: row.item_image,
                alt: 'img',
                class: 'image-block cart-imaged w75'
            });

            // Create the div with name, code, and contact information
            var itemInfo = $('<div>').html(`
                <strong>`+row.item_name+`</strong><br>
                <small>Code : `+row.item_code+`</small><br>
                <small>Group : `+row.group_name+`</small><br>
                <small>Category : `+row.category_name+`</small><br>
            `);

            // Append the image and information to the detail div
            itemDetail.append(itemImage, itemInfo);

            // Create the right div
            var rightDiv = $('<div>', {
                class: 'right'
            });

            // Create the quantity input div
            var qtyInput = $('<div>', {
                class: 'qty-input float-end'
            });

            // Create the buttons and input for quantity
            var qtyMinusBtn = $('<button>', {
                class: 'qty-count qty-count--minus',
                'data-action': 'minus',
                type: 'button',
                text: '-'
            });

            var qtyInputField = $('<input>', {
                class: 'product-qty numericOnly',
                type: 'number',
                name: 'order_item['+key+'][qty]',
                min: '1',
                max: '10000',
                value: row.qty,
                step: '1',
                pattern: '[0-9]*',
                'data-append_key' : 'amount_'+key,
                'data-price' : row.price
            });

            var qtyAddBtn = $('<button>', {
                class: 'qty-count qty-count--add',
                'data-action': 'add',
                type: 'button',
                text: '+'
            });

            var amountDiv = $('<div class="float-end text-center text-black">').html('Amt. : <span id="amount_'+key+'">'+row.amount+'</span>')

            // Append buttons and input to the quantity input div
            qtyInput.append(qtyMinusBtn, qtyInputField, qtyAddBtn);

            // Append the detail and quantity input div to the cart item
            cartItem.append(itemDetail, rightDiv.append(qtyInput,"<br><br>",amountDiv));

            // Create the card footer
            var cardFooter = $('<div>', {
                class: 'card-footer text-center',
                click: function() {
                    removeCartItem(key);
                }
            });

            // Create the remove span
            var removeBtn = $('<span>', {
                class: 'text-danger'                    
            }).html('<ion-icon name="trash"></ion-icon> Remove');

            // Append the remove span to the card footer
            cardFooter.append(removeBtn);

            // Append the card body and card footer to the card
            card.append(cardBody.append(cartItem), cardFooter);

            var itemIdInput = $('<input>',{type : 'hidden', name : 'order_item['+key+'][item_id]', value : row.item_id});
            var groupIdInput = $('<input>',{type : 'hidden', name : 'order_item['+key+'][group_id]', value : row.group_id});
            var categoryIdInput = $('<input>',{type : 'hidden', name : 'order_item['+key+'][category_id]', value : row.category_id});
            var priceIdInput = $('<input>',{type : 'hidden', name : 'order_item['+key+'][price]', value : row.price});
            var partyIdInput = $('<input>',{type : 'hidden', name : 'order_item['+key+'][party_id]', value : row.party_id});

            // Append the card to the new div
            itemDiv.append(card,itemIdInput,groupIdInput,categoryIdInput,priceIdInput,partyIdInput);

            // Append the new div to the body or any other element you want
            $('#view-cart-modal #cartItemList').append(itemDiv);            
            
            var count_cart_item = $("."+row.item_id+row.group_id).length;
            if(count_cart_item > 0){
                var addToCart = $('<span class="btn btn-warning btn-cart-view view-cart-btn" >View Cart ('+count_cart_item+')</span>');
            }else{
                var addToCart = $('<span class="btn btn-warning btn-cart" onclick="itemDetail('+row.item_id+');">Add to Cart</span>');
            }
            $('#lazy-load-trans #action-btn-'+row.item_id+row.group_id).html(addToCart);
        });
        calculateCartQty();
    }else{
        $("#cart-item-count").html('0');
        $("#view-cart-modal #cartItemList").html('<div class="text-center">Your cart is empty.</div>');
    }
}

function removeCartItem(keyToRemove){
    //Remove Item From Local Storage
    var cartItemList = localStorage.getItem("cartItems");
    cartItemList = JSON.parse(cartItemList);
    var item = cartItemList[keyToRemove];
    delete cartItemList[keyToRemove];
    
    //Reset cart local storage
    if(Object.keys(cartItemList).length == 0){
        localStorage.removeItem("cartItems");
    }else{
        localStorage.setItem("cartItems",JSON.stringify(cartItemList));
    }
    
    //Remove Html
    $("#"+keyToRemove).remove();
    countCartItems();

    var count_cart_item = $("."+item.item_id+item.group_id).length;
    if(count_cart_item > 0){
        var addToCart = $('<span class="btn btn-warning btn-cart-view view-cart-btn" >View Cart ('+count_cart_item+')</span>');
    }else{
        var addToCart = $('<span class="btn btn-warning btn-cart" onclick="itemDetail('+item.item_id+');">Add to Cart</span>');
    }
    $('#lazy-load-trans #action-btn-'+item.item_id+item.group_id).html(addToCart);
}

function calculateCartQty(){
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

            var price = $this.data('price') || 0;
            var appendKey = $this.data('append_key');
            var amount = parseFloat(parseFloat(qty) * parseFloat(price)).toFixed(2);
            $("#"+appendKey).html(amount);
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
            var price = $input.data('price') || 0;
            var appendKey = $input.data('append_key');
            var amount = parseFloat(parseFloat(qty) * parseFloat(price)).toFixed(2);
            $("#"+appendKey).html(amount);
        });
    })();
}

function resSaveOrder(response,formId){
    if(response.status==1){
        reloadTransaction(); $("#view-cart-modal").modal("hide");
        localStorage.removeItem("cartItems");countCartItems();
        toastbox('success',response.message, 3000);
    }else{
        if(typeof response.message === "object"){
            $(".error").html("");
            $.each( response.message, function( key, value ) {$("."+key).html(value);});
        }else{
            $("#view-cart-modal").modal("hide");
            toastbox('error',response.message, 3000);
        }			
    }
}
</script>