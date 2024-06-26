<?php $this->load->view("app/includes/header"); ?>
<style>
.bottom-balance{
    position: fixed !important;
    min-width: 100% !important;
    z-index: 999 !important;
    border-radius: 0;
    bottom: 57px;    
}
.appHeader .left .icon, .appHeader .left ion-icon, .appHeader .right .icon, .appHeader .right ion-icon {
    font-size: 25px !important;
}
</style>
<!-- App Header -->
<div class="appHeader">
    <div class="left">
        <a href="<?=base_url("app/karigerLedger")?>" class="headerButton goBack1 text-dark">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle"><?=(isset($headData->pageName)) ? $headData->pageName : '' ?></div>
    <div class="right">
        <a href="#" class="headerButton toggle-searchbox text-gold" style="padding: 0px;">
            <ion-icon name="search-outline"></ion-icon>
        </a>

        <a href="javascript:void(0)" class="headerButton text-dark filter" id="filter-btn" style="padding: 0px;">
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
    <div class="card lazy-load-tab">
        <div class="card-body" style="padding:0px;">
            <ul class="nav nav-tabs lined m-t-5 m-b-5 text-dark" role="tablist">
                <li class="nav-item" style="border-right:1px solid #DCDCE9">
                    <div class="float-start text-center">
                        Op. Balance<br>
                        <span id="op_balance">0</span>
                    </div>        
                </li>
                <li class="nav-item" style="border-right:1px solid #DCDCE9">
                    <div class="float-end text-center" id="op_balance">
                        Cl. Balance<br>
                        <span id="cl_balance">0</span>
                    </div>
                </li>
                <li class="nav-item" style="width:20%;">
                    <span id="print-dialog" class="button fs-px-35 text-gold">
                        <ion-icon name="print-outline"></ion-icon>
                    </span>   
                </li>
            </ul>
        </div>        
    </div>

    <div class="section m-t-70 m-b-40">
        <div class="transactions" id="lazy-load-trans" data-url="<?=base_url("app/report/getLedgerDetail/".$userData->id)?>" data-filter_page_name="ledgerDetail">
            <!-- <div class="card m-t-10 m-b-10">
                <div class="card-body">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6 text-dark">No. : #1</div>
                            <div class="col-6 text-right text-dark">Date : 28-02-2024</div>
                            <div class="col-12 text-dark">Amount : 100</div>
                            <div class="col-12">Remark : abc</div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>

        <div id="lazyLoader" class="text-center  m-b-20" style="display:none;">
            <img src="<?=base_url("assets/dist/img/infinity-rb.gif")?>" width="80" alt="Loader">
        </div>
    </div>
</div>
<!-- * App Capsule -->

<?php 
    $this->load->view("app/includes/footer"); 
    $this->load->view("app/report/ledger_detail_filter_form");
    $this->load->view("app/report/ledger_detail_print_form");
?>

<script>
$(document).ready(function(){
    loadTransaction();

    $(document).on('click','.filter',function(){
        $("#filter-modal").modal("show");
        $("#filter-modal .select2").select2(); 
        setInputEvent();
    });

    $(document).on('click','#print-dialog',function(){
        $("#print-modal").modal("show");
        $("#print-modal .select2").select2(); 
        setInputEvent();
    });
});

async function dataListing(response){
    var dataList = response.data;
    var totalRecords = response.recordsFiltered;
    var ledgerData = response.ledgerData;

    $("#op_balance").html("0");
    $("#cl_balance").html("0");

    $("#op_balance").html(ledgerData.op_balance+" "+ledgerData.op_balance_type);
    $("#cl_balance").html(ledgerData.cl_balance+" "+ledgerData.cl_balance_type);

    if(dataList.length > 0){
        $.each(dataList,function(key,row){            
            // Use jQuery to dynamically create HTML elements
            var cardDiv = $('<div>').addClass('card m-t-10 m-b-10');
            var cardBodyDiv = $('<div>').addClass('card-body');
            var col12Div = $('<div>').addClass('col-12');
            var rowDiv = $('<div>').addClass('row');
            
            // Populate data
            rowDiv.append($('<div>').addClass('col-6 text-dark').text('No. : '+row.trans_number));
            rowDiv.append($('<div>').addClass('col-6 text-right text-dark').text('Date : '+row.trans_date));
            rowDiv.append($('<div>').addClass('col-6 text-dark').text(row.entry_name));
            rowDiv.append($('<div>').addClass('col-6 text-right text-dark').text('Amount : '+row.net_amount+' '+row.c_or_d));
            rowDiv.append($('<div>').addClass('col-12').text('Remark : '+row.remark));

            // Build the structure
            col12Div.append(rowDiv);
            cardBodyDiv.append(col12Div);
            cardDiv.append(cardBodyDiv);

            // Append the generated HTML to the container
            $('#lazy-load-trans').append(cardDiv);
        });
    }else{
        if(totalRecords <= 0){
            $("#lazy-load-trans").html('<div class="text-center">No data available</div>');
        }
    }
}
</script>