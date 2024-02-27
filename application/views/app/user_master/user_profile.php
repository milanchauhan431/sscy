<?php $this->load->view("app/includes/header"); ?>
<!-- App Header -->
<div class="appHeader">
    <div class="left">
        <a href="<?=base_url("app/dashboard")?>" class="headerButton goBack1 text-dark">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">
        <?=(isset($headData->pageName)) ? $headData->pageName : '' ?>
    </div>
    <div class="right">
        <!-- <a href="app-notifications.html" class="headerButton">
            <ion-icon class="icon" name="notifications-outline"></ion-icon>
            <span class="badge badge-danger">4</span>
        </a> -->
    </div>
</div>
<!-- * App Header -->

<!-- App Capsule -->
<div id="appCapsule">

    <div class="section mt-3 text-center">
        <form id="profileForm" action="POST" enctype="multipart/form-data">
            <div class="profile-pic-wrapper">
                <div class="pic-holder">
                    <!-- uploaded pic shown here -->
                    <img id="profilePic" class="pic" src="<?=$dataRow->user_image?>">
                    <input class="uploadProfileInput" type="file" name="user_image" id="newProfilePhoto" accept="image/*" style="opacity: 0;" />
                    <label for="newProfilePhoto" class="upload-file-block">
                        <div class="text-center">
                            <div class="mb-2"><i class="fa fa-camera fa-2x"></i></div>
                            <div class="text-uppercase">Update <br /> Profile Photo</div>
                        </div>
                    </label>
                    <input type="hidden" name="id" id="id" value="<?=(!empty($dataRow->id))?$dataRow->id:""; ?>" />
                </div>
            </div>
        </form>
    </div>

    <div class="listview-title mt-1">Theme</div>
    <ul class="listview image-listview text inset no-line">
        <li>
            <div class="item">
                <div class="in">
                    <div>
                        Dark Mode
                    </div>
                    <div class="form-check form-switch  ms-2">
                        <input class="form-check-input dark-mode-switch" type="checkbox" id="darkmodeSwitch" style="display:block;">
                        <label class="form-check-label" for="darkmodeSwitch" style="display:none;"></label>
                    </div>
                </div>
            </div>
        </li>
    </ul>

    <div class="listview-title mt-1">Profile Details</div>
    <ul class="listview image-listview text inset">
        <li>
            <div class="item">
                <div class="in">
                    <div>Code : <?=$dataRow->user_code?></div>
                </div>
            </div>
        </li>
        <li>
            <div class="item">
                <div class="in">
                    <div>Name : <?=$dataRow->user_name?></div>
                </div>
            </div>
        </li>
        <li>
            <div class="item">
                <div class="in">
                    <div>Mobile No. : <?=$dataRow->mobile_no?></div>
                </div>
            </div>
        </li>
        <li>
            <div class="item">
                <div class="in">
                    <div>City : <?=$dataRow->city?></div>
                </div>
            </div>
        </li>
    </ul>

    <div class="listview-title mt-1">Security</div>
    <ul class="listview image-listview text mb-2 inset">
        <li>
            <?php
                $changePswParam = "{'modal_id' : 'dialogbox-sm', 'controller' : 'userMaster','call_function':'changePassword', 'fnsave':'saveChangePassword', 'form_id' : 'changePassword', 'title' : 'Change Password','js_store_fn':'confirmStore','res_function':'resChangePassword'}";
            ?>
            <a href="javascript:void(0)" class="item" onclick="modalAction(<?=$changePswParam?>);">
                <div class="in">
                    <div>Change Password</div>
                </div>
            </a>
        </li>
    </ul>
</div>
<!-- * App Capsule -->
<?php $this->load->view("app/includes/footer"); ?>

<script>
$(document).ready(function(){
    $(document).on("change", ".uploadProfileInput", function () {
        var triggerInput = this;
        var currentImg = $(this).closest(".pic-holder").find(".pic").attr("src");
        var holder = $(this).closest(".pic-holder");
        var wrapper = $(this).closest(".profile-pic-wrapper");
        $(wrapper).find('[role="alert"]').remove();
        triggerInput.blur();
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) {return;}
        var id = $("#profileForm #id").val();
        if (/^image/.test(files[0].type)) {
            // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file

            reader.onloadend = function () {
                $(holder).addClass("uploadInProgress");
                $(holder).find(".pic").attr("src", this.result);
                $(holder).append('<div class="upload-loader"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>');
                
                var fd = new FormData();
                var files_pics = $('#newProfilePhoto')[0].files;
                if(files_pics.length > 0 ){
                    fd.append('user_image',files_pics[0]);
                    fd.append('id',id);
                    fd.append('form_type',"updateProfilePic");
                    $.ajax({
                        url: base_url + 'userMaster/uploadProfile',
                        data:fd,
                        type: "POST",
                        processData:false,
                        contentType:false,
                        cache: false,
                        global:false,
                        dataType:"json",
                    }).done(function(data){
                        if(data.status==0){
                            toastbox('error',data.message, 3000);
                            window.location.reload();
                        }else if(data.status==1){ 
                            toastbox('success',"Profile Photo updated successfully.", 3000);
                        }
                        $(holder).removeClass("uploadInProgress");
                        $(holder).find(".upload-loader").remove();
                        $(triggerInput).val("");
                    });
                }
            };
        }
        else{
            toastbox('error',"Please choose the valid image.", 3000);
            $(wrapper).find('role="alert"').remove();
        }
    });
});

function resChangePassword(response,formId){
    if(response.status==1){
        $('#'+formId)[0].reset(); closeModal(formId);
        toastbox('success',response.message, 3000);
    }else{
        if(typeof response.message === "object"){
            $(".error").html("");
            $.each( response.message, function( key, value ) {$("."+key).html(value);});
        }else{
            toastbox('error',response.message, 3000);
        }			
    }
}
</script>