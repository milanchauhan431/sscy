var load_flag = 0; var ajax_call = false;
$(document).ready(function(){
    
    $(window).scroll(function(){        
        if(($(window).scrollTop() + 2) >= ($(document).height() - $(window).height())){           
            loadTransaction();
        }

        if($("#lazy-load-trans").hasClass("loadModre") == true){ 
            ajax_call = false; $("#lazy-load-trans").removeClass("loadModre"); 
        }
    });

    $(document).on('keyup','#commanSerach',function(){
		load_flag = 0;ajax_call = false;
        $("#lazy-load-trans").addClass("filterList"); 
        $("#lazy-load-trans").html('');
		loadTransaction();
	});

    $(document).on('click',"#clearSerach",function(){
        load_flag = 0;ajax_call = false;
        $("#lazy-load-trans").removeClass("filterList"); 
        $("#lazy-load-trans").html('');
        $("#commanSerach").val("");
		loadTransaction();
    });
    
    $(document).on('click','#applyFilter',function(){
        var page_name = $("#filter_form").data('page_name');
        var filterData = {};
        var form = $('#filter_form')[0];
        if(form){    
            var fd = $(form).serializeArray();    
            $.each(fd,function(key,row){ filterData[row.name] = row.value; });
        }
        var storageData = {
            filters: filterData
        };

        localStorage.setItem(page_name, JSON.stringify(storageData));
        $("#filter-btn").removeClass('text-success').addClass('text-warning');
        reloadTransaction();
    });

    $(document).on('click','#clearFilters',function(){
        var page_name = $("#filter_form").data('page_name');
        $("#filter_form")[0].reset();
        $("#filter-modal .select2").select2();
        localStorage.removeItem(page_name);
        $("#filter-btn").removeClass('text-warning').addClass('text-success');
        reloadTransaction();
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
    var filter_page_name = $("#lazy-load-trans").data('filter_page_name') || "";

    var filterData = {};
    if(filter_page_name){
        var flData = localStorage.getItem(filter_page_name);
        if(flData){
            filterData = JSON.parse(flData);
            filterData = filterData.filters;
        } 
    }
      
	var dataSet = {draw:1,start:load_flag,length:20,search : {value : search, regex : false},filters:filterData};
	var url = $("#lazy-load-trans").attr('data-url');
	var postData = {url:url,dataSet:dataSet,resFunctionName:"dataListing"};
	loadMore(postData);
}

function reloadTransaction(){
    $("#lazy-load-trans").html('');
    var search = $('#commanSerach').val() || "";
    load_flag = 0;ajax_call = false;

    var filter_page_name = $("#lazy-load-trans").data('filter_page_name') || "";
    var filterData = {};
    if(filter_page_name){
        var flData = localStorage.getItem(filter_page_name);
        if(flData){
            filterData = JSON.parse(flData);
            filterData = filterData.filters;
        } 
    }

	var dataSet = {draw:1,start:load_flag,length:20,search : {value : search, regex : false},filters:filterData};
	var url = $("#lazy-load-trans").attr('data-url');
	var postData = {url:url,dataSet:dataSet,resFunctionName:"dataListing"};
	loadMore(postData);
}

function tabLoading(url){
	load_flag = 0;ajax_call = false;
	$("#lazy-load-trans").removeAttr('data-url');
	$("#lazy-load-trans").attr('data-url',url);
    $("#lazy-load-trans").html('');
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
        global: false,
        beforeSend: function() {
            $("#lazyLoader").show();
            ajax_call = true;
        },
    }).done(function(response){
        setTimeout(function(){            
            $("#lazyLoader").hide();
            if($("#lazy-load-trans").hasClass("filterList") == true){ 
                if(response.data.length > 0){
                    $("#lazy-load-trans").html(""); 
                }
            }
            window[postData.resFunctionName](response);
            if(response.recordsFiltered > load_flag){
                load_flag += dataSet.length;   
                ajax_call = false;    
                $("#lazy-load-trans").removeClass("loadModre"); 
            }else{
                $("#lazy-load-trans").addClass("loadModre");
            }
        },1000);
    }).fail(function(xhr, err) { 
        loadingStatus(xhr); 
    });    
}

function loadingStatus(data=""){
    /* var status = navigator.onLine; 
    if(status == false){alert("no internet");} */

    if(data != ""){
        if(data.status == 401){
            setTimeout(function(){ 
                window.location.href = base_url + 'app/logout';
            }, 2000);
        }
    }    
}