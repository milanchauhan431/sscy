
var zindex = "9999";
$(document).ready(function(){
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
		$("#"+modal_id+" .modal-header .btn-close").attr('data-modal_class',"");
		setTimeout(function(){ 
			//$("#"+modalId+" .select2").select2({with:null});
		}, 500);
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

function modalAction(data){
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
	$("#"+postData.modal_id+" .btn-custom-save").attr('onclick',jsStoreFn+"("+fnJson+");");

	$("#"+postData.modal_id+" .modal-header .btn-close").attr('data-modal_id',postData.modal_id);
	$("#"+postData.modal_id+" .modal-header .btn-close").attr('data-modal_class',postData.form_id+"Modal");

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
		$("#"+postData.modal_id+" .select2").select2({with:null});
	}, 5);
	setTimeout(function(){
		$('#'+postData.modal_id+'  :input:enabled:visible:first, select:first').focus();
	},500);
	zindex++;
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
	$("#"+modal_id+" .modal-header .btn-close").attr('data-modal_class',"");
	setTimeout(function(){ 
		$("#"+modalId+" .select2").select2({with:null});	
	}, 500);
}

function store(postData){
	setPlaceHolder();

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
				toastbox('success',data.message, 2000);
			}else{
				if(typeof data.message === "object"){
					$(".error").html("");
					$.each( data.message, function( key, value ) {$("."+key).html(value);});
				}else{
					reloadTransaction();
					toastbox('error',data.message, 2000);
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
								toastbox('error',data.message, 2000);
							}else{
								reloadTransaction();
								toastbox('success',data.message, 2000);
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



