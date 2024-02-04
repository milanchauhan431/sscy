<?php $this->load->view("app/includes/header"); ?>

<!-- App Header -->
<div class="appHeader">
    <div class="left">
        <a href="#" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle"><?=(isset($headData->pageName)) ? $headData->pageName : '' ?></div>
    <div class="right">
        <a href="#" class="headerButton toggle-searchbox">
            <ion-icon name="search-outline"></ion-icon>
        </a>

        <a href="#" class="button" data-bs-toggle="modal" data-bs-target="#depositActionSheet">
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
    </div>
</div>
<!-- * App Capsule -->

<?php $this->load->view("app/includes/footer"); ?>

<script>
$(document).ready(function(){
    loadTransaction();
});

function dataListing(response){
    var dataList = response.data;
    var totalRecords = response.recordsTotal
    if(dataList.length > 0){
        $.each(dataList,function(key,row){
            
            // Create a div with class "item"
            var itemDiv = $('<div class="item mb-2"></div>');

            // Create a div with class "detail"
            var detailDiv = $('<div class="detail"></div>');

            // Create an image element with src attribute
            var imgElement = $('<img src="'+row.user_image+'" alt="img" class="image-block imaged w48">');

            // Create a div with a strong tag containing text
            var nameDiv = $('<div></div>').html("<strong>"+row.user_name+"</strong><small>Code : "+row.user_code+"</small><br><small>Contact No. : "+row.mobile_no+"</small>");

            // Append the image and name div to the detail div
            detailDiv.append(imgElement, nameDiv);

            // Create a div with class "right"
            var rightDiv = $('<div class="right"></div>');

            // Create a div with class "card-button dropdown"
            var cardButtonDiv = $('<div class="card-button dropdown"></div>');

            // Create a button with data-bs-toggle attribute
            var buttonElement = $('<button type="button" class="btn btn-link btn-icon" data-bs-toggle="dropdown"><ion-icon name="ellipsis-horizontal"></ion-icon></button>');

            // Create a div with class "dropdown-menu dropdown-menu-end"
            var dropdownMenu = $('<div class="dropdown-menu dropdown-menu-end"></div>');

            // JSON object
            var jsonData = actionBtnJson({postData: {id: row.id}, controller: 'userMaster'});

            // Create anchor tag with onclick attribute
            var editLink = $('<a class="dropdown-item" href="#" onclick="edit(' + jsonData + ');"><ion-icon name="pencil-outline"></ion-icon>Edit</a>');

            var removeLink = $('<a class="dropdown-item" href="#"><ion-icon name="close-outline"></ion-icon>Remove</a>');

            // Append anchor tags to the dropdown menu
            dropdownMenu.append(editLink, removeLink);

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

function edit(data){
    console.log(data);
}
</script>