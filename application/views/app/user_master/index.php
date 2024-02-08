<?php $this->load->view("app/includes/header"); ?>

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

        <?php
            $addParam = "{'modal_id' : 'ModalBasic', 'controller' : 'userMaster','call_function':'addUser', 'form_id' : 'userForm', 'title' : 'Add Kariger'}";
        ?>
        <a href="#" class="button fs-px-40 text-success" onclick="modalAction(<?=$addParam?>);">
            <ion-icon name="add-outline"></ion-icon>
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
            <ul class="nav nav-tabs lined" role="tablist">
                <li class="nav-item">
                    <button class="nav-link text-success active" id="active_user" onclick="tabLoading('<?=base_url('app/userMaster/getDTRows/1')?>');" role="tab">
                        Active
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link text-danger" id="inactive_user" onclick="tabLoading('<?=base_url('app/userMaster/getDTRows/0')?>');" role="tab">
                        In-Active
                    </button>
                </li>
            </ul>
        </div>        
    </div>

    <div class="section m-t-80">
        <div class="transactions" id="transactions" data-url="<?=base_url("app/userMaster/getDTRows/1")?>">
        </div>

        <div id="transactionLoader" class="text-center  m-b-20" style="display:none;">
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
            
            // Create a div with class "item"
            var itemDiv = $('<div class="item mb-2"></div>');

            // Create a div with class "detail"
            var detailDiv = $('<div class="detail"></div>');

            // Create an image element with src attribute
            var imgElement = $('<img src="'+row.user_image+'" alt="img" class="image-block imaged w48">');

            // Create a div with a strong tag containing text
            var details = $('<div></div>');
            var userName = $("<strong></strong>").html(row.user_name);
            var userCode = $("<small></small>").html("Code : "+row.user_code+"<br>");
            var userMobile = $("<small></small>").html("Contact No. : "+row.mobile_no);

            // Append the image and name div to the detail div
            detailDiv.append(imgElement, details);

            // Append Listing Details
            details.append(userName, userCode, userMobile);

            // Create a div with class "right"
            var rightDiv = $('<div class="right"></div>');

            // Create a div with class "card-button dropdown"
            var cardButtonDiv = $('<div class="card-button dropdown"></div>');

            // Create a button with data-bs-toggle attribute
            var buttonElement = $('<button type="button" class="btn btn-link btn-icon" data-bs-toggle="dropdown"><ion-icon name="ellipsis-horizontal"></ion-icon></button>');

            // Create a div with class "dropdown-menu dropdown-menu-end"
            var dropdownMenu = $('<div class="dropdown-menu dropdown-menu-end"></div>');

            // JSON object
            var editJsonData = actionBtnJson({postData: {id: row.id}, modal_id : 'ModalBasic', controller : 'userMaster', call_function:'edit', form_id : 'userForm', title : 'Add Kariger'});
            var deleteJsonData = actionBtnJson({postData: {id: row.id},'message' : 'Kariger'});
            var statusJsonData = actionBtnJson({postData: {id: row.id,is_active:((row.is_active == 1)?0:1)},controller : 'userMaster', fnsave:'changeStatus','message' : 'Are you sure want to '+((row.is_active == 1)?'In-Active':'Active')+' this Kariger?'});

            // Create anchor tag with onclick attribute
            var editLink = $('<a class="dropdown-item" href="#" onclick="modalAction(' + editJsonData + ');"><ion-icon name="pencil-outline"></ion-icon>Edit</a>');

            var removeLink = $('<a class="dropdown-item" href="#" onclick="trash(' + deleteJsonData + ');"><ion-icon name="trash"></ion-icon>Remove</a>');

            if(row.is_active == 1){ editLink,removeLink = ""; }

            var statusIcon = (row.is_active == 1)?'<ion-icon name="close-circle-outline"></ion-icon>In-Active':'<ion-icon name="checkmark-circle-outline"></ion-icon>Active';
            var statusLink = $('<a class="dropdown-item" href="#" onclick="confirmStore(' + statusJsonData + ');">'+statusIcon+'</a>');
            
            // Append anchor tags to the dropdown menu
            dropdownMenu.append(editLink, removeLink, statusLink);

            // Append the button and dropdown menu to the card-button div
            cardButtonDiv.append(buttonElement, dropdownMenu);

            // Append detail div and right div to the item div
            itemDiv.append(detailDiv, rightDiv.append(cardButtonDiv));

            // Append the generated HTML to the container
            $('#transactions').append(itemDiv);
        });
    }else{
        if(totalRecords <= 0){
            $("#transactions").html('<div class="text-center">No data available</div>');
        }
    }
}
</script>