var zindex = 9000;
$(document).ready(function(){

	/*** Keep Selected Tab after page loading ***/
	var selectedTab = localStorage.getItem('selected_tab');
	if (selectedTab != null) { $("#"+selectedTab).trigger('click'); }
	$(document).on('click','.nav-tab',function(){
		var id = $(this).attr('id');
    	localStorage.setItem('selected_tab', id);
    });

	$(document).on("keypress",".numericOnly",function (e) {
		if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) return false;
	});	

	$(document).on("keypress",'.floatOnly',function(event) {
		if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {event.preventDefault();}
	});

	$(document).on('mouseenter', '.mainButton', function(e){
		e.preventDefault();
		$(this).addClass('open');
		$(this).addClass('showAction');
		$(this).children('.fa').removeClass('fa-cog');
		$(this).children('.fa').addClass('fa-times');
		$(this).parent().children('.btnDiv').css('z-index','9');
	});

	$(document).on('mouseleave', '.actionButtons', function(e){
		e.preventDefault();
		$('.mainButton').removeClass('open');
		$('.mainButton').removeClass('showAction');
		$('.mainButton').children('.fa').removeClass('fa-times');
		$('.mainButton').children('.fa').addClass('fa-cog');
		$('.mainButton').parent().children('.btnDiv').css('z-index','-1');
	});
	
	$(document).ajaxStart(function(){
		$('.ajaxModal').show();$('.centerImg').show();
		$(".error").html("");
		$('.btn-form').attr('disabled','disabled');
	});
	
	$(document).ajaxComplete(function(){
		$('.ajaxModal').hide();$('.centerImg').hide();
		$('.btn-form').removeAttr('disabled');
		/* checkPermission(); */
	});		

	$(document).on('click','.btn-close',function(){
		var modal_id = $(this).data('modal_id');
		var modal_class = $(this).data('modal_class');
		$("#"+modal_id).removeClass(modal_class);
		$("#"+modal_id+' .modal-body').html("");
		$(".modal").css({'overflow':'auto'});
		$("#"+modal_id+" .modal-footer .btn-close").attr('data-modal_id',"");
		$("#"+modal_id+" .modal-footer .btn-close").attr('data-modal_class',"");
		$(".select2").select2();
	});

	$(document).on('change','.custom-file-input',function(){
		var inputId = $(this).attr('id');
		if($('#'+inputId).hasClass("multifiles")){
			var files = $('#'+inputId).prop("files")
			var fileNames = $.map(files, function(val) { return val.name; });
			var fileName = fileNames.join(", ") || "Choose file";
		}else{
			var fileName = $('#'+inputId).val().split('\\').pop() || "Choose file";
		}
        $('label[for="' + inputId + '"]').html(fileName);
	});

	$(document).on('click','.removeImage',function(){
        $(this).parent('div').remove();
    });

	// on first focus (bubbles up to document), open the menu
	$(document).on('focus', '.select2-selection.select2-selection--single', function (e) {
		$(this).closest(".select2-container").siblings('select:enabled').select2('open');
	});
	
	// steal focus during close - only capture once and stop propogation
	$('select.select2').on('select2:closing', function (e) {
		$(e.target).data("select2").$selection.one('focus focusin', function (e) {
			e.stopPropagation();
		});
	});
});

$(window).on('pageshow', function() {
	$('form').off();
	/* checkPermission();setMinMaxDate(); */
});

function siteLogout(data){
	toastr.error(data.statusText, 'Error', { "showMethod": "slideDown", "hideMethod": "slideUp", "closeButton": true, positionClass: 'toastr toast-bottom-center', containerId: 'toast-bottom-center', "progressBar": true });
	console.log(data);
	if(data.status == 401){
		setTimeout(function(){ 
			localStorage.authToken = "";
			window.location.href = base_url;
		}, 2000);
	}	
}

function setPlaceHolder(){
	var label="";

	$('input').each(function () {
		if(!$(this).hasClass('combo-input') && $(this).attr("type")!="hidden" ){
			label="";
			inputElement = $(this).parent();
			if($(this).parent().hasClass('input-group')){inputElement = $(this).parent().parent();}else{inputElement = $(this).parent();}
			label = inputElement.children("label").text();
			label = label.replace('*','');
			label = $.trim(label);
			if($(this).hasClass('req')){inputElement.children("label").html(label + ' <strong class="text-danger">*</strong>');}
			if(!$(this).attr("placeholder")){if(label){$(this).attr("placeholder", label);}}
			$(this).attr("autocomplete", 'off');
			var errorClass="";
			var nm = $(this).attr('name');
			if($(this).attr('id')){errorClass=$(this).attr('id');}else{errorClass=$(this).attr('name');if(errorClass){errorClass = errorClass.replace("[]", "");}}
			/* if(inputElement.find('.'+errorClass).length <= 0){inputElement.append('<div class="error '+ errorClass +'"></div>');} */
		}
		else{$(this).attr("autocomplete", 'off');}
	});

	$('textarea').each(function () {
		label="";
		label = $(this).parent().children("label").text();
		label = label.replace('*','');
		label = $.trim(label);
		if($(this).hasClass('req')){$(this).parent().children("label").html(label + ' <strong class="text-danger">*</strong>');}
		if(label){$(this).attr("placeholder", label);}
		$(this).attr("autocomplete", 'off');
		var errorClass="";
		var nm = $(this).attr('name');
		if($(this).attr('id')){errorClass=$(this).attr('id');}else{errorClass=$(this).attr('name');}
		/* if($(this).parent().find('.'+errorClass).length <= 0){$(this).parent().append('<div class="error '+ errorClass +'"></div>');} */
	});

	$('select').each(function () {
		label="";
		var selectElement = $(this).parent();
		if($(this).hasClass('single-select')){selectElement = $(this).parent().parent();}
		label = selectElement.children("label").text();
		label = label.replace('*','');
		label = $.trim(label);
		if($(this).hasClass('req')){selectElement.children("label").html(label + ' <strong class="text-danger">*</strong>');}
		var errorClass="";
		var nm = $(this).attr('name');
		if($(this).attr('id')){errorClass=$(this).attr('id');}else{errorClass=$(this).attr('name');}
		/* if(selectElement.find('.'+errorClass).length <= 0){selectElement.append('<div class="error '+ errorClass +'"></div>');} */
	});
}

function initMultiSelect(){
	$('.multiselect').multiselect({
		includeSelectAllOption:false,
		enableFiltering:true,
        enableCaseInsensitiveFiltering: true,
		buttonWidth: '100%',
		onChange: function() {
			var inputId = this.$select.data('input_id');
			var selected = this.$select.val();$('#' + inputId).val(selected);
		}
	});
	$('.form-check-input').addClass('filled-in');
	$('.multiselect-filter i').removeClass('fas');
	$('.multiselect-filter i').removeClass('fa-sm');
	$('.multiselect-filter i').addClass('fa');
	$('.multiselect-container.dropdown-menu').addClass('scrollable');
	$('.multiselect-container.dropdown-menu').css('max-height','200px');
	OverlayScrollbars(document.querySelector('.scrollable'), {});
	//$('.scrollable').perfectScrollbar({wheelPropagation: !0});
}

function reInitMultiSelect(){
	$('.scrollable').multiselect('rebuild');
	$('.form-check-input').addClass('filled-in');
	$('.multiselect-filter i').removeClass('fas');
	$('.multiselect-filter i').removeClass('fa-sm');
	$('.multiselect-filter i').addClass('fa');
	$('.multiselect-container.dropdown-menu').addClass('scrollable');
	$('.multiselect-container.dropdown-menu').css('height','200px');
	OverlayScrollbars(document.querySelector('.scrollable'), {});
	//$('.scrollable').perfectScrollbar({wheelPropagation: !0});
}

function initModalPlugin(modalId){
	setTimeout(function(){ 
		setPlaceHolder();//setMinMaxDate();initMultiSelect();
	}, 5);
	setTimeout(function(){
		$('#'+modalId+' input[type="text"]:first').focus();
	},500);
	$("#"+modalId+" .select2").select2({with:null});	
}

function initTable(tableOptions,formData = {}){
	var tableOptions = tableOptions || {pageLength: 25,'stateSave':false};
	var dataSet = formData;
	ssDatatable($('.ssTable'),tableOptions,dataSet);
}

function modalAction(data){
	var call_function = data.call_function;
	if(call_function == "" || call_function == null){call_function="edit";}

	var fnsave = data.fnsave;
	if(fnsave == "" || fnsave == null){fnsave="save";}

	var controllerName = data.controller;
	if(controllerName == "" || controllerName == null){controllerName=controller;}	

	var callUrl = base_url + controllerName + '/' + call_function;
	if(data.api_slug != ""){
		callUrl = api_url + data.api_slug;
	}

	$.ajax({ 
		type: "POST",   
		url: callUrl,   
		data: data.postData,
	}).done(function(response){
		initModal(data,response);
	}).fail(function(xhr, err) { 
		siteLogout(xhr); 
	});
}

function initModal(postData,response){
	var button = postData.button || "both";
	var fnedit = postData.fnedit || "edit";
	var fnsave = postData.fnsave || "save";
	var controllerName = postData.controller || controller;
	var savebtn_text = postData.savebtn_text || '<i class="fa fa-check"></i> Save';
	var api_slug = postData.api_slug || "";
	var confirm_msg = postData.confirm_msg || "";

	var resFunction = postData.res_function || "";
	var jsStoreFn = postData.js_store_fn || 'store';

	var fnJson = "{'formId':'"+postData.form_id+"','fnsave':'"+fnsave+"','controller':'"+controllerName+"','api_slug':'"+api_slug+"','confirm_msg':'"+confirm_msg+"'}";

	$("#"+postData.modal_id).modal('show');
	$("#"+postData.modal_id).css({'z-index':1059,'overflow':'auto'});
	$("#"+postData.modal_id).addClass(postData.form_id+"Modal");
	$("#"+postData.modal_id+' .modal-title').html(postData.title);
	$("#"+postData.modal_id+' .modal-body').html('');
	$("#"+postData.modal_id+' .modal-body').html(response);
	$("#"+postData.modal_id+" .modal-body form").attr('id',postData.form_id);
	if(resFunction != ""){
		$("#"+postData.modal_id+" .modal-body form").attr('data-res_function',resFunction);
	}
	$("#"+postData.modal_id+" .modal-footer .btn-save").html(savebtn_text);
	$("#"+postData.modal_id+" .modal-footer .btn-save").attr('onclick',jsStoreFn+"("+fnJson+");");
	$("#"+postData.modal_id+" .btn-custom-save").attr('onclick',jsStoreFn+"("+fnJson+");");

	$("#"+postData.modal_id+" .modal-header .close").attr('data-modal_id',postData.modal_id);
	$("#"+postData.modal_id+" .modal-header .close").attr('data-modal_class',postData.form_id+"Modal");
	$("#"+postData.modal_id+" .modal-footer .btn-close").attr('data-modal_id',postData.modal_id);
	$("#"+postData.modal_id+" .modal-footer .btn-close").attr('data-modal_class',postData.form_id+"Modal");

	if(button == "close"){
		$("#"+postData.modal_id+" .modal-footer .btn-close").show();
		$("#"+postData.modal_id+" .modal-footer .btn-save").hide();
	}else if(button == "save"){
		$("#"+postData.modal_id+" .modal-footer .btn-close").hide();
		$("#"+postData.modal_id+" .modal-footer .btn-save").show();
	}else{
		$("#"+postData.modal_id+" .modal-footer .btn-close").show();
		$("#"+postData.modal_id+" .modal-footer .btn-save").show();
	}

	initModalPlugin(postData.modal_id);
}

function closeModal(formId){
	//zindex = zindex--;
	var modal_id = $("."+formId+"Modal").attr('id');
	$("#"+modal_id).removeClass(formId+"Modal");
	$("#"+modal_id+' .modal-body').html("");
	$("#"+modal_id).modal('hide');	
	$("#"+modal_id).modal({'overflow':'auto'});	
	$(".modal").css({'overflow':'auto'});

	$("#"+modal_id+" .modal-header .close").attr('data-modal_id',"");
	$("#"+modal_id+" .modal-header .close").attr('data-modal_class',"");
	$("#"+modal_id+" .modal-footer .btn-close").attr('data-modal_id',"");
	$("#"+modal_id+" .modal-footer .btn-close").attr('data-modal_class',"");
	$(".select2").select2();
}

function store(postData){
	var formId = postData.formId;
	var fnsave = postData.fnsave || "save";
	var api_slug = postData.api_slug || "";

	$("#"+formId).valid();
	if($("#"+formId).valid() == false){ return false; }

	var form = $('#'+formId)[0];
	var fd = new FormData(form);
	var resFunctionName = $("#"+formId).data('res_function') || "";
	setPlaceHolder();

	$.ajax({
		url: api_url + api_slug,
		data:fd,
		headers: {
			"Authorization": "Bearer "+localStorage.authToken
		},
		type: "POST",
		processData:false,
		contentType:false,
		dataType:"json",
		mimeType: "multipart/form-data",
	}).done(function(data){
		if(resFunctionName != ""){
			window[resFunctionName](data,formId);
		}else{
			if(data.status==true){
				ssTable.ajax.reload(null, true);
				$('#'+formId)[0].reset();
				closeModal(formId);

				toastr.success(data.message, 'Success', { "showMethod": "slideDown", "hideMethod": "slideUp", "closeButton": true, positionClass: 'toastr toast-bottom-center', containerId: 'toast-bottom-center', "progressBar": true });
			}else{
				if(typeof data.message === "object"){
					$(".error").html("");
					$.each( data.message, function( key, value ) {$("."+key).html(value);});
				}else{
					ssTable.ajax.reload(null, true);
					toastr.error(data.message, 'Error', { "showMethod": "slideDown", "hideMethod": "slideUp", "closeButton": true, positionClass: 'toastr toast-bottom-center', containerId: 'toast-bottom-center', "progressBar": true });
				}			
			}	
		}		
	}).fail(function(xhr, err) { 
		siteLogout(xhr); 
	});
}

function confirmStore(data){
	var formId = data.formId || "";
	var fnsave = data.fnsave || "save";
	var api_slug = postData.api_slug || "";
	var controllerName = data.controller || controller;

	if(formId != ""){
		$("#"+formId).valid();
		if($("#"+formId).valid() == false){ return false; }

		var form = $('#'+formId)[0];
		var fd = new FormData(form);
		var resFunctionName = $("#"+formId).data('res_function') || "";
		var msg = data.confirm_msg || "Are you sure want to save this change ?";
		var ajaxParam = {
			url: api_url + api_slug,
			data:fd,
			headers: {
				"Authorization": "Bearer "+localStorage.authToken
			},
			type: "POST",
			processData:false,
			contentType:false,
			dataType:"json"
		};

		setPlaceHolder();
	}else{
		var fd = data.postData;
		var resFunctionName = data.res_function || "";
		var msg = data.message || "Are you sure want to save this change ?";
		var ajaxParam = {
			url: api_url + api_slug,
			data:fd,
			headers: {
				"Authorization": "Bearer "+localStorage.authToken
			},
			data:fd,
			type: "POST",
			dataType:"json"
		};
	}

	$.confirm({
		title: 'Confirm!',
		content: msg,
		type: 'orange',
		buttons: {   
			ok: {
				text: "ok!",
				btnClass: 'btn waves-effect waves-light btn-outline-success',
				keys: ['enter'],
				action: function(){
					$.ajax(ajaxParam).done(function(response){
						if(resFunctionName != ""){
							window[resFunctionName](response,formId);
						}else{
							if(response.status==true){
								ssTable.ajax.reload(null, true);
								if(formId != ""){
									$('#'+formId)[0].reset();
									closeModal(formId);
								}

								toastr.success(response.message, 'Success', { "showMethod": "slideDown", "hideMethod": "slideUp", "closeButton": true, positionClass: 'toastr toast-bottom-center', containerId: 'toast-bottom-center', "progressBar": true });
							}else{
								if(typeof response.message === "object"){
									$(".error").html("");
									$.each( response.message, function( key, value ) {$("."+key).html(value);});
								}else{
									ssTable.ajax.reload(null, true);
									toastr.error(response.message, 'Error', { "showMethod": "slideDown", "hideMethod": "slideUp", "closeButton": true, positionClass: 'toastr toast-bottom-center', containerId: 'toast-bottom-center', "progressBar": true });
								}			
							}	
						}			
					}).fail(function(xhr, err) { 
						siteLogout(xhr); 
					});
				}
			},
			cancel: {
                btnClass: 'btn waves-effect waves-light btn-outline-secondary',
                action: function(){

				}
            }
		}
	});
}

function trash(data){
	var controllerName = data.controller || controller;
	var fnName = data.fndelete || "delete";
	var msg = data.message || "Record";
	var send_data = data.postData;
	var resFunctionName = data.res_function || "";
	var api_slug = data.api_slug || "";

	$.confirm({
		title: 'Confirm!',
		content: 'Are you sure want to delete this '+msg+'?',
		type: 'red',
		buttons: {   
			ok: {
				text: "ok!",
				btnClass: 'btn waves-effect waves-light btn-outline-success',
				keys: ['enter'],
				action: function(){
					$.ajax({
						url: api_url + api_slug,
						headers: {
							"Authorization": "Bearer "+localStorage.authToken
						},
						data: send_data,
						type: "POST",
						dataType:"json",
					}).done(function(response){
						if(resFunctionName != ""){
							window[resFunctionName](response);
						}else{
							if(response.status==false){
								toastr.error(response.message, 'Sorry...!', { "showMethod": "slideDown", "hideMethod": "slideUp", "closeButton": true, positionClass: 'toastr toast-bottom-center', containerId: 'toast-bottom-center', "progressBar": true });
							}else{
								ssTable.ajax.reload(null, true);
								toastr.success(response.message, 'Success', { "showMethod": "slideDown", "hideMethod": "slideUp", "closeButton": true, positionClass: 'toastr toast-bottom-center', containerId: 'toast-bottom-center', "progressBar": true });
							}	
						}
					}).fail(function(xhr, err) { 
						siteLogout(xhr); 
					});
				}
			},
			cancel: {
                btnClass: 'btn waves-effect waves-light btn-outline-secondary',
                action: function(){

				}
            }
		}
	});
}

function checkPermission(){
	$('.permission-read').show();
	$('.permission-write').show();
	$('.permission-modify').show();
	$('.permission-remove').show();
	$('.permission-approve').show();

	//view permission
	if(permissionRead == "1"){ 
		$('.permission-read').prop('disabled', false);
		$('.permission-read').show(); 
	}else{ 
		$('.permission-read').prop('disabled', true);
		$('.permission-read').hide(); 
		window.location.href = base_url + 'error_403';
	}

	//write permission
	if(permissionWrite == "1"){ 
		$('.permission-write').prop('disabled', false);
		$('.permission-write').show(); 
	}else{ 
		$('.permission-write').prop('disabled', true);
		$('.permission-write').hide(); 
	}

	//update permission
	if(permissionModify == "1"){ 
		$('.permission-modify').prop('disabled', false);
		$('.permission-modify').show(); 
	}else{ 
		$('.permission-modify').prop('disabled', true);
		$('.permission-modify').hide(); 
	}

	//delete permission
	if(permissionRemove == "1"){ 
		$('.permission-remove').prop('disabled', false);
		$('.permission-remove').show(); 
	}else{ 
		$('.permission-remove').prop('disabled', true);
		$('.permission-remove').hide(); 
	}

	//Approve permission
	if(permissionApprove == "1"){ 
		$('.permission-approve').prop('disabled', false);
		$('.permission-approve').show(); 
	}else{ 
		$('.permission-approve').prop('disabled', true);
		$('.permission-approve').hide(); 
	}
}

function inrFormat(no){
    if(no){
        no=no.toString();
        var afterPoint = '';
        if(no.indexOf('.') > 0)
           afterPoint = no.substring(no.indexOf('.'),no.length);
        no = Math.floor(no);
        no=no.toString();
        var lastThree = no.substring(no.length-3);
        var otherNumbers = no.substring(0,no.length-3);
        if(otherNumbers != ''){lastThree = ',' + lastThree;}
            
        var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree + afterPoint;
    	return res;
    }else{return no;}        
}