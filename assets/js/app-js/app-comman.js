
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
