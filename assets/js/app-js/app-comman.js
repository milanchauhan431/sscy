
var zindex = "9999";
$(document).ready(function(){
	//Select2 check if there is no dropdownParent and if the function is called on an element that has a parent of the type div.modal. If so, it will add that modal as the parent for the dropdown.
	(function(){
		var oldSelect2 = jQuery.fn.select2;
		jQuery.fn.select2 = function() {
			const modalParent = jQuery(this).parents('div.modal').first();
			if (arguments.length === 0 && modalParent.length > 0) {
				arguments = [{dropdownParent: modalParent}];
			} else if (arguments.length === 1
						&& typeof arguments[0] === 'object'
						&& typeof arguments[0].dropdownParent === 'undefined'
						&& modalParent.length > 0) {
				arguments[0].dropdownParent = modalParent;
			}
			return oldSelect2.apply(this,arguments);
		};
		// Copy all properties of the old function to the new
		for (var key in oldSelect2) {
			jQuery.fn.select2[key] = oldSelect2[key];
		}
	})();

	/*** Keep Selected Tab after page loading ***/
	/* var selectedTab = localStorage.getItem('selected_tab');
	if (selectedTab != null) { 
		$(".nav-tabs .nav-link").removeClass('active');
		$("#"+selectedTab).trigger('click').addClass('active');
		$("#transactions").html('');
	} */
	$(document).on('click','.nav-link',function(){
		var id = $(this).attr('id');
		$(".nav-tabs .nav-link").removeClass('active');
		$(this).addClass('active');
    	//localStorage.setItem('selected_tab', id);
    });

	$(document).on('click','.btn-close',function(){
		zindex--;
		var modal_id = $(this).data('modal_id');
		var modal_class = $(this).data('modal_class');
		$("#"+modal_id).removeClass(modal_class);
		$("#"+modal_id+' .modal-body').html("");
		$(".modal").css({'overflow':'auto'});
		$("#"+modal_id).removeClass('modal-i-'+zindex);	
		$('.modal-i-'+(zindex-1)).addClass('show');

		$("#"+modal_id+" .modal-header .btn-close").attr('data-modal_id',"");
		$("#"+modal_id+" .modal-footer .btn-close").attr('data-modal_id',"");
		$("#"+modal_id+" .modal-header .btn-close").attr('data-modal_class',"");
		$("#"+modal_id+" .modal-footer .btn-close").attr('data-modal_class',"");
		setTimeout(function(){ 
			//$("#"+modalId+" .select2").select2({with:null});
		}, 500);
	});

	$(document).on("keypress",".numericOnly",function (e) {
		if(String.fromCharCode(e.keyCode).match(/[^0-9]/g)){ return false; } 
		if(e.originalEvent.data && e.originalEvent.data.match(/[^0-9]/g)){ return false; }
	});

	$(document).on("keypress",'.floatOnly',function(e) {
		if ((e.which != 46 || $(this).val().indexOf('.') != -1) && (e.which < 48 || e.which > 57)) {e.preventDefault();}

		// Get the current input value
		var inputValue = $(this).val();
		// Allow only one dot and numeric characters
		if ((inputValue.indexOf('.') !== -1 && e.data === '.') || (e.data !== '.' && (e.data < '0' || e.data > '9'))) {
			e.preventDefault();
		}
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

	$(document).ajaxStart(function(){
		$('.ajaxLoader,.ajaxLoaderImg').show();$(".error").html("");
		$('.btn-save').attr('disabled','disabled');
	});
	
	$(document).ajaxComplete(function(){
		$('.ajaxLoader,.ajaxLoaderImg').hide();
		$('.btn-save').removeAttr('disabled');
	});
	
	$(document).on('click','#forceReload',function(){
		window.location.reload(true);
	});
});

function setInputEvent(){
	
	//-----------------------------------------------------------------------
	// Input
	// Clear input
	var clearInput = document.querySelectorAll(".clear-input");
	clearInput.forEach(function (el) {
		el.addEventListener("click", function () {
			var parent = this.parentElement
			var input = parent.querySelector(".form-control")
			input.focus();
			input.value = "";
			parent.classList.remove("not-empty");
		})
	})

	// active
	var formControl = document.querySelectorAll(".form-group .form-control");
	formControl.forEach(function (el) {	
		// active
		el.addEventListener("focus", () => {
			var parent = el.parentElement;
			parent.classList.add("active");
		});
		el.addEventListener("blur", () => {
			var parent = el.parentElement;
			parent.classList.remove("active");
		});
		// empty check
		el.addEventListener("keyup", log);
		function log(e) {
			var inputCheck = this.value.length;
			if (inputCheck > 0) {
				this.parentElement.classList.add("not-empty")
			}
			else {
				this.parentElement.classList.remove("not-empty")
			}
		}

		var checkInput = el.value.length;
		if (checkInput > 0) {
			el.parentElement.classList.add("not-empty")
		}
		else {
			el.parentElement.classList.remove("not-empty")
		}
	})

	var select2 = document.querySelectorAll(".selectBox");
	select2.forEach(function (el) {
		// Initialize Select2
		$(el).select2();

		// Event listeners for Select2
		$(el).on('select2:open', function (e) {
			var parent = el.parentElement;
			parent.classList.add("active");
			parent.classList.add("not-empty");
			$(".select2-dropdown .select2-search__field").focus().select();
		});

		$(el).on('select2:close', function (e) {
			var parent = el.parentElement;
			parent.classList.remove("active");
		});

		$(el).on('change', function (e) {
			var checkSelected = $(this).val().length;
			var parent = el.parentElement;

			if (checkSelected > 0) {
				parent.classList.add("not-empty");
			} else {
				parent.classList.remove("not-empty");
			}
		});

		// Check initial state
		var checkSelected = $(el).val().length;
		var parent = el.parentElement;

		if (checkSelected > 0) {
			parent.classList.add("not-empty");
		} else {
			parent.classList.remove("not-empty");
		}
	});

	var multiSelectBox = document.querySelectorAll(".multiSelectBox");
	multiSelectBox.forEach(function (el) { 
		// Event listener for 'show.bs.dropdown' event
		$(el).on('focus', function () {
			var parent = el.parentElement;
			parent = parent.parentElement;
			parent.classList.add("active");
		});

		// Event listener for 'hide.bs.dropdown' event
		$(el).on('blur', function () {
			var parent = el.parentElement;
			parent = parent.parentElement;
			parent.classList.remove("active");
		});

		// Event listener for 'change' event
		$(el).on('change', function () {
			var checkSelected = $("#"+($(this).data('input_id'))).val().length;
			var parent = el.parentElement;
			parent = parent.parentElement;

			if (checkSelected > 0) {
				parent.classList.add("not-empty");
				//parent.classList.add("active");
			} else {
				parent.classList.remove("not-empty");
				parent.classList.remove("active");
			}
		});

		// Check initial state
		var checkSelected = $("#"+($(el).data('input_id'))).val().length;
		var parent = el.parentElement;
		parent = parent.parentElement;

		if (checkSelected > 0) {
			parent.classList.add("not-empty");
		} else {
			parent.classList.remove("not-empty");
		}
	});

	//-----------------------------------------------------------------------

	//-----------------------------------------------------------------------
	// Upload Input
	var uploadComponent = document.querySelectorAll('.custom-file-upload');
	uploadComponent.forEach(function (el) {
		var fileUploadParent = '#' + el.id;
		var fileInput = document.querySelector(fileUploadParent + ' input[type="file"]')
		var fileLabel = document.querySelector(fileUploadParent + ' label')
		var fileLabelText = document.querySelector(fileUploadParent + ' label span')
		var filelabelDefault = fileLabelText.innerHTML;
		fileInput.addEventListener('change', function (event) {
			var name = this.value.split('\\').pop()
			tmppath = URL.createObjectURL(event.target.files[0]);
			if (name) {
				fileLabel.classList.add('file-uploaded');
				fileLabel.style.backgroundImage = "url(" + tmppath + ")";
				fileLabelText.innerHTML = name;
			}
			else {
				fileLabel.classList.remove("file-uploaded")
				fileLabelText.innerHTML = filelabelDefault;
			}
		})
	})
	//-----------------------------------------------------------------------
}

function initMultiSelect(){
	$('.multiselect').multiselect({
		includeSelectAllOption:true,
		enableFiltering:true,
        enableCaseInsensitiveFiltering: true,
		buttonWidth: '100%',
		onDropdownShown: function(even) {
			this.$filter.find('.multiselect-search').focus();
		},
		onChange: function() {
			var inputId = this.$select.data('input_id');
			var selected = this.$select.val();$('#' + inputId).val(selected);
		},
		onSelectAll: function(){
			var inputId = this.$select.data('input_id');
			var selected = this.$select.val();$('#' + inputId).val(selected.join(","));
		},
		onDeselectAll: function(){
			var inputId = this.$select.data('input_id');
			$('#' + inputId).val("");
		}
	});
	$('.form-check-input').addClass('filled-in');
	$('.multiselect-filter i').removeClass('fas');
	$('.multiselect-filter i').removeClass('fa-sm');
	$('.multiselect-filter i').addClass('fa');
	$('.multiselect-container.dropdown-menu').addClass('scrollable');
	$('.multiselect-container.dropdown-menu').css('max-height','200px');
}

function reInitMultiSelect(){
	$('.scrollable').multiselect('rebuild');
	$('.form-check-input').addClass('filled-in');
	$('.multiselect-filter i').removeClass('fas');
	$('.multiselect-filter i').removeClass('fa-sm');
	$('.multiselect-filter i').addClass('fa');
	$('.multiselect-container.dropdown-menu').addClass('scrollable');
	$('.multiselect-container.dropdown-menu').css('height','200px');
}

function siteStatus(data=""){
    var status = navigator.onLine; 
    if(status == false){alert("no internet");}

    if(data != ""){
        if(data.status == 401){
            setTimeout(function(){ 
                window.location.href = base_url + 'app/logout';
            }, 2000);
        }
    }    
}

function initModal(postData,response){
	var button = postData.button;if(button == "" || button == null){button="both";};
	var fnedit = postData.fnedit;if(fnedit == "" || fnedit == null){fnedit="edit";}
	var fnsave = postData.fnsave;if(fnsave == "" || fnsave == null){fnsave="save";}
	var controllerName = postData.controller;if(controllerName == "" || controllerName == null){controllerName=controller;}

	var resFunction = postData.res_function || "";
	var jsStoreFn = postData.js_store_fn || 'store';

	var fnJson = "{'formId':'"+postData.form_id+"','fnsave':'"+fnsave+"','controller':'"+controllerName+"'}";

	$("#"+postData.modal_id).modal('show');
	$("#"+postData.modal_id).addClass('modal-i-'+zindex);
	$('.modal-i-'+(zindex - 1)).removeClass('show');
	$("#"+postData.modal_id).css({'z-index':zindex,'overflow':'auto'});
	$("#"+postData.modal_id).addClass(postData.form_id+"Modal");
	$("#"+postData.modal_id+' .modal-title').html(postData.title);
	$("#"+postData.modal_id+' .modal-body').html('');
	$("#"+postData.modal_id+' .modal-body').html(response);
	$("#"+postData.modal_id+" .modal-body form").attr('id',postData.form_id);
	if(resFunction != ""){
		$("#"+postData.modal_id+" .modal-body form").attr('data-res_function',resFunction);
	}
	$("#"+postData.modal_id+" .modal-header .btn-save").attr('onclick',jsStoreFn+"("+fnJson+");");
	$("#"+postData.modal_id+" .modal-footer .btn-save").attr('onclick',jsStoreFn+"("+fnJson+");");
	$("#"+postData.modal_id+" .btn-custom-save").attr('onclick',jsStoreFn+"("+fnJson+");");

	$("#"+postData.modal_id+" .modal-header .btn-close").attr('data-modal_id',postData.modal_id);
	$("#"+postData.modal_id+" .modal-footer .btn-close").attr('data-modal_id',postData.modal_id);
	$("#"+postData.modal_id+" .modal-header .btn-close").attr('data-modal_class',postData.form_id+"Modal");
	$("#"+postData.modal_id+" .modal-footer .btn-close").attr('data-modal_class',postData.form_id+"Modal");

	if(button == "close"){
		$("#"+postData.modal_id+" .modal-header .btn-close").show();
		$("#"+postData.modal_id+" .modal-header .btn-save").hide();
	}else if(button == "save"){
		$("#"+postData.modal_id+" .modal-header .btn-close").hide();
		$("#"+postData.modal_id+" .modal-header .btn-save").show();
	}else{
		$("#"+postData.modal_id+" .modal-header .btn-close").show();
		$("#"+postData.modal_id+" .modal-header .btn-save").show();
	}
	
	setTimeout(function(){ 
		$("#"+postData.modal_id+" .select2").select2(); 
		setInputEvent();initMultiSelect();
	}, 5);
	setTimeout(function(){
		//$('#'+postData.modal_id+'  :input:enabled:visible:first, select:first').focus();
		$('#'+postData.modal_id+'  .form-control:enabled:visible:first').focus();
	},500);
	zindex++;
}

function modalAction(data){
	if(typeof data == "string"){ data  = JSON.parse(data); }
	var call_function = data.call_function;
	if(call_function == "" || call_function == null){call_function="edit";}

	var fnsave = data.fnsave;
	if(fnsave == "" || fnsave == null){fnsave="save";}

	var controllerName = data.controller;
	if(controllerName == "" || controllerName == null){controllerName=controller;}	

	$.ajax({ 
		type: "POST",   
		url: base_url + controllerName + '/' + call_function,   
		data: data.postData,
	}).done(function(response){
		initModal(data,response);
	});
}

function closeModal(formId){
	zindex--;
	
	var modal_id = $("."+formId+"Modal").attr('id');
	$("#"+modal_id).removeClass(formId+"Modal");
	$("#"+modal_id+' .modal-body').html("");
	$("#"+modal_id).modal('hide');	
	$(".modal").css({'overflow':'auto'});
	$("#"+modal_id).removeClass('modal-i-'+zindex);	
	$('.modal-i-'+(zindex-1)).addClass('show');

	$("#"+modal_id+" .modal-header .btn-close").attr('data-modal_id',"");
	$("#"+modal_id+" .modal-footer .btn-close").attr('data-modal_id',"");
	$("#"+modal_id+" .modal-header .btn-close").attr('data-modal_class',"");
	$("#"+modal_id+" .modal-footer .btn-close").attr('data-modal_class',"");
	setTimeout(function(){ 
		$("#"+modal_id+" .select2").select2({with:null});	
	}, 500);
}

function store(postData){
	setInputEvent();
	if(typeof postData == "string"){ postData  = JSON.parse(postData); }

	var formId = postData.formId;
	var fnsave = postData.fnsave || "save";
	var controllerName = postData.controller || controller;

	var form = $('#'+formId)[0];
	var fd = new FormData(form);
	var resFunctionName = $("#"+formId).data('res_function') || "";

	$.ajax({
		url: base_url + controllerName + '/' + fnsave,
		data:fd,
		type: "POST",
		processData:false,
		contentType:false,
		dataType:"json",
	}).done(function(data){
		if(resFunctionName != ""){
			window[resFunctionName](data,formId);
		}else{
			if(data.status==1){
				reloadTransaction(); $('#'+formId)[0].reset(); closeModal(formId);
				toastbox('success',data.message, 3000);
			}else{
				if(typeof data.message === "object"){
					$(".error").html("");
					$.each( data.message, function( key, value ) {$("."+key).html(value);});
				}else{
					reloadTransaction();
					toastbox('error',data.message, 3000);
				}			
			}	
		}			
	});
}

function confirmStore(data){
	if(typeof data == "string"){ data  = JSON.parse(data); }
	setInputEvent();

	var formId = data.formId || "";
	var fnsave = data.fnsave || "save";
	var controllerName = data.controller || controller;

	if(formId != ""){
		var form = $('#'+formId)[0];
		var fd = new FormData(form);
		var resFunctionName = $("#"+formId).data('res_function') || "";
		var msg = $("#"+formId).data('confirm_message') || "Are you sure want to save this change ?";
		var ajaxParam = {
			url: base_url + controllerName + '/' + fnsave,
			data:fd,
			type: "POST",
			processData:false,
			contentType:false,
			dataType:"json"
		};
	}else{
		var fd = data.postData;
		var resFunctionName = data.res_function || "";
		var msg = data.message || "Are you sure want to save this change ?";
		var ajaxParam = {
			url: base_url + controllerName + '/' + fnsave,
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
							if(response.status==1){
								reloadTransaction(); if(formId != ""){$('#'+formId)[0].reset(); closeModal(formId);}
								toastbox('success',response.message, 3000);
							}else{
								if(typeof response.message === "object"){
									$(".error").html("");
									$.each( response.message, function( key, value ) {$("."+key).html(value);});
								}else{
									reloadTransaction();
									toastbox('error',response.message, 3000);
								}			
							}
						}			
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
	if(typeof data == "string"){ data  = JSON.parse(data); }
	var controllerName = data.controller || controller;
	var fnName = data.fndelete || "delete";
	var msg = data.message || "Record";
	var send_data = data.postData;
	var resFunctionName = data.res_function || "";
	
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
						url: base_url + controllerName + '/' + fnName,
						data: send_data,
						type: "POST",
						dataType:"json",
					}).done(function(response){
						if(resFunctionName != ""){
							window[resFunctionName](response);
						}else{
							if(response.status==0){
								reloadTransaction();
								toastbox('error',response.message, 3000);
							}else{
								reloadTransaction();
								toastbox('success',response.message, 3000);
							}	
						}
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



