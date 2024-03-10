<?php $this->load->view("app/includes/header"); ?>
<style>
.item{
    color: #958d9e !important;
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
        <a href="#" class="headerButton toggle-searchbox text-gold">
            <ion-icon name="search-outline"></ion-icon>
        </a>

        <a href="javascript:void(0)" class="button fs-px-35 text-dark filter" id="filter-btn">
            <ion-icon name="filter-outline"></ion-icon>
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
        <div class="transactions" id="lazy-load-trans" data-url="<?=base_url("app/report/getLedgerList")?>" data-filter_page_name="ledger">
        </div>

        <div id="lazyLoader" class="text-center  m-b-20" style="display:none;">
            <img src="<?=base_url("assets/dist/img/infinity-rb.gif")?>" width="80" alt="Loader">
        </div>
    </div>
</div>
<!-- * App Capsule -->

<?php 
    $this->load->view("app/includes/footer"); 
    $this->load->view("app/report/ledger_filter_form");
?>
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
            var itemDiv = $('<a href="'+base_url+'report/ledgerDetail/'+row.id+'" class="item mb-2"></a>');

            // Create a div with class "detail"
            var detailDiv = $('<div class="detail"></div>');

            // Create a div with a strong tag containing text
            var details = $('<div></div>');
            var userName = $("<strong></strong>").html(row.user_name);
            var userCode = $("<span></span>").html("code : "+row.user_code);

            // Append the image and name div to the detail div
            detailDiv.append(details);

            // Append Listing Details
            details.append(userName, userCode);

            // Create a div with class "right"
            var rightDiv = $('<div class="right"></div>');

            var balance = $("<strong></strong>").html(row.cl_balance+" "+row.balance_type);

            // Append detail div and right div to the item div
            itemDiv.append(detailDiv, rightDiv.append(balance));

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