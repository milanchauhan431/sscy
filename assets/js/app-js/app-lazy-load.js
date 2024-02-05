var load_flag = 0;
var ajax_call = false;
$(document).ready(function(){
    
    $(window).scroll(function(){        
        if(($(window).scrollTop() + 1) >= ($(document).height() - $(window).height())){           
            loadTransaction();
        }

        if($("#transactions").hasClass("loadModre") == true){ 
            ajax_call = false; $("#transactions").removeClass("loadModre"); 
        }
    });

    $(document).on('keyup','#commanSerach',function(){
		load_flag = 0;
        $("#transactions").html('');
		loadTransaction();
	});

    $(document).on('click',"#clearSerach",function(){
        load_flag = 0;
        $("#transactions").html('');
        $("#commanSerach").val("");
		loadTransaction();
    });
});

function actionBtnJson(jsonData){
	// Convert JSON to string using jQuery
    var jsonString = JSON.stringify(jsonData);

    // Replace double quotes with &quot; to avoid conflicts in HTML attribute
    var escapedJsonString = jsonString.replace(/"/g, "&quot;");

	return "\'" + escapedJsonString + "\'";
}

function loadTransaction(){
    var search = $('#commanSerach').val() || "";
	var dataSet = {draw:1,start:load_flag,length:25,search : {value : search, regex : false}};
	var url = $("#transactions").attr('data-url');
	var postData = {url:url,dataSet:dataSet,resFunctionName:"dataListing"};
	loadMore(postData);
}

function reloadTransaction(){
    var search = $('#commanSerach').val() || "";
    load_flag = 0;
	var dataSet = {draw:1,start:load_flag,length:25,search : {value : search, regex : false}};
	var url = $("#transactions").attr('data-url');
	var postData = {url:url,dataSet:dataSet,resFunctionName:"dataListing"};
	loadMore(postData);
}

function tabLoading(url){
	load_flag = 0;
    ajax_call = false;
	$("#transactions").removeAttr('data-url');
	$("#transactions").attr('data-url',url);
    $("#transactions").html('');
	loadTransaction();
}

function loadMore(postData){
    var dataSet = postData.dataSet;

    if(ajax_call == true){
        return false;
    }

    $.ajax({
        url : postData.url,
        type : 'post',
        data : dataSet,
        dataType : 'json',
        async : false,
        beforeSend: function() {
            $("#transactionLoader").show();
            ajax_call = true;
        },
    }).done(function(response){
        setTimeout(function(){            
            $("#transactionLoader").hide();
            window[postData.resFunctionName](response);
            if(response.recordsFiltered > load_flag){
                load_flag += dataSet.length;   
                ajax_call = false;             
            }else{
                $("#transactions").addClass("loadModre");
            }
        },2000);
    }).fail(function(xhr, err) { 
        loadingStatus(xhr); 
    });    
}

function loadingStatus(data=""){
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