$(document).ready(function(){
	var selectedRow = null;	

	// Handle initial row selection on click
	$(document).on("click",".table tbody tr",function(){
		$(".table tbody tr").removeClass('selectedTableRow');
		$(this).addClass('selectedTableRow');
		selectedRow = $(this);
	});

	/* Table tr selected and up down selected row using up and down key */
	$(document).keydown(function(e) {
		//Table row up down using Up arrow key and Down arrow key
		if (e.keyCode === 38) { // Up arrow key
			if (selectedRow && selectedRow.prev().length > 0) {
				selectedRow.removeClass('selectedTableRow');
				selectedRow = selectedRow.prev();
				selectedRow.addClass('selectedTableRow');
			}
		} else if (e.keyCode === 40) { // Down arrow key
			if (selectedRow && selectedRow.next().length > 0) {
				selectedRow.removeClass('selectedTableRow');
				selectedRow = selectedRow.next();
				selectedRow.addClass('selectedTableRow');
			}
		}

		//Table scrolling when up down row
		if(selectedRow != null){
			$ ('.key-scroll .dataTables_scrollBody').scrollTop(selectedRow.position().top);
		}		
		
		//on press atl + O to show/hide action Buttons
		if (e.altKey && e.keyCode === 79) { 			
			if($('.selectedTableRow .actionButtons .mainButton').hasClass("showAction") == false){
				$('.selectedTableRow .actionButtons .mainButton').addClass('open showAction'); // Trigger the click event on your button 
				$('.selectedTableRow .actionButtons .btnDiv').attr('style','z-index:9;');
				$('.selectedTableRow .actionButtons .mainButton i').removeClass('fa fa-cog');
				$('.selectedTableRow .actionButtons .mainButton i').addClass('fa fa-times');
				$('.selectedTableRow .actionButtons .btnDiv a:first').focus();
			}else{
				$('.selectedTableRow .actionButtons .mainButton ').removeClass('open showAction'); // Trigger the click event on your button 
				$('.selectedTableRow .actionButtons .btnDiv').attr('style','z-index:-1;');
				$('.selectedTableRow .actionButtons .mainButton i').removeClass('fa fa-times');
				$('.selectedTableRow .actionButtons .mainButton i').addClass('fa fa-cog');
				$('.selectedTableRow').focus();
			}		  
		}

		// Check if the Alt key and A key are pressed
		if(e.altKey && e.which === 65 || e.altKey && e.which == "a"){
			//Open modal or page for new entry 
			$(".card-header .press-add-btn").trigger("click");
		}

		// Check if the Alt key and C key are pressed
		if (e.altKey && e.which === 67) {
			// Find the last opened modal and close it
			$('.modal-footer .press-close-btn, .card-footer .press-close-btn').trigger("click");
		}
		
		// GO TO Datatable pagination next page using (ALT + N)
		if(e.altKey && e.which === 78){
			$(".dataTables_paginate .pagination .next").trigger("click");
		}

		// GO TO Datatable pagination previous page using (ALT + P)
		if(e.altKey && e.which === 80){
			$(".dataTables_paginate .pagination .previous").trigger("click");
		}

		// Refresh Table Data Using (ALT + R)
		if(e.altKey && e.which === 82){
			$(".nav-tab-refresh").trigger('click');
		}
	});
});

function getActionButton(buttons=""){
	var action = '';
	/* action += '<div class="actionWrapper">';
	action += '<div class="actionButtons actionButtonsRight">';
	action += '<a class="mainButton" href="javascript:void(0)"><i class="fa fa-cog"></i></a>';
	action += '<div class="btnDiv">'+buttons+'</div>';
	action += '</div>';
	action += '</div>'; */

	action += '<div class="col-actions">'+buttons+'</div>';
	return action;
}

function ssDatatable(ele,tableOptions,postData={}){    
    var dataUrl = ele.attr('data-url');
	var tableId = ele.attr('id');

    var ssTableOptions = {
		"processing": true, /*for show progress bar*/		
		"paging": true,
		"serverSide": true,
		'ajax': function (postData, callback, settings) {
			$.ajax({
			  	url: api_url + dataUrl,
			  	type:"POST", 
				headers: {
					"Authorization": "Bearer "+localStorage.authToken
				},
				data:postData,
				global:false ,
				dataType:'json',
				mimeType: "multipart/form-data",
				beforeSend: function() {
					var columnCount = $('#'+tableId+' thead tr').first().children().length;
					$("#"+tableId+" TBODY").html('<tr><td colspan="'+columnCount+'" class="text-center">Loading...</td></tr>');
				},
			}).then ( function( json, textStatus, jqXHR ) {
				callback(json.data);
			}).fail(function(xhr, err) { siteLogout(xhr); });
		},
		//responsive: true,
		responsive: {
			details: true
		},
		"scrollY": '52vh',
		"scrollX": true,
		orderCellsTop: true,
		//deferRender: true,
		//scroller: true,
		//destroy: true,
		"autoWidth" : false,
		pageLength: 25,
		language: { search: "" },
		lengthMenu: [
			[ 10, 20, 25, 50, 75, 100, -1],
			[ '10 rows', '20 rows', '25 rows', '50 rows', '75 rows', '100 rows', 'Show All']
		],
		order:[],
		orderCellsTop: true,
		dom: "<'row'<'col-sm-7'B><'col-sm-5'f>>" +"<'row'<'col-sm-12't>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
		buttons: {
			dom: {
				button: {
					className: "btn btn-outline-theme btn-sm m-r-1 m-l-1"
				}
			},
			buttons:[ 
				'pageLength', 
				{
					extend: 'excel',
					exportOptions: {
						columns: "thead th:not(.noExport)"
					}
				},
				{
					text: 'Refresh',
					className:'nav-tab-refresh',
					action: function (){ 
						ssTable.ajax.reload(null, true); 
						$(".columnSearchInput").val("");
						/* initTable(tableOptions,postData); */ 
					} 
				}
			]
		},
		"fnInitComplete":function(){
			$('#' + tableId +' tbody tr:first').trigger('click');			
		},
		"fnDrawCallback": function( oSettings ) {			
			OverlayScrollbars(document.querySelector('.dataTables_scrollBody'), {});
			$('#' + tableId +' tbody tr:first').trigger('click');

			//$('.dataTables_scrollBody').perfectScrollbar('destroy').perfectScrollbar();
			//$(".bt-switch").bootstrapSwitch();
			//checkPermission();
		}
	};

	//$('.ssTable-cf thead tr').clone(true).addClass('filters').appendTo('.ssTable-cf thead');

    $.extend( ssTableOptions, tableOptions );
	ssTable = ele.DataTable(ssTableOptions);
	ssTable.buttons().container().appendTo( '#' + tableId +'_wrapper toolbar' );
	$('.dataTables_filter').css("text-align","left");
	$('#' + tableId +'_filter label').css("display","block");
	$('.btn-group>.btn:first-child').css("border-top-right-radius","0");
	$('.btn-group>.btn:first-child').css("border-bottom-right-radius","0");
	$('#' + tableId +'_filter label').attr("id","search-form");	
	$('#' + tableId +'_filter .form-control-sm').css("width","97%");
	$('#' + tableId +'_filter .form-control-sm').attr("placeholder","Search.....");	
	$(".dataTables_scroll").addClass("key-scroll");

	/* $("ssTable-cf thead tr:eq(1)").data("sorter", false).data("filter", false);

	// Setup - add a text input to each header cell	
	var state = ssTable.state.loaded();	
	$('.ssTable-cf thead tr:eq(1) th').each(function (i) {
		$(this).removeClass('sorting').addClass('sorting_disabled');		
		var searchCol = $('.ssTable-cf thead tr:eq(0) th:eq('+i+')').hasClass('no_filter');
		if(searchCol == true){
			$(this).html('');
		}else{
			var title = $(this).text();
			$(this).html('<input type="text" class="form-control form-control-sm filters columnSearchInput" placeholder="Search ' + title + '"  />');

			if (state) {
				var colSearch = state.columns[i].search;
				if ( colSearch.search ) {$('.ssTable-cf thead tr:eq(1) th:eq('+i+') input').val( colSearch.search );}
			}

			$('input', this).on('keyup change', function () {
				if (ssTable.column(i).search() !== this.value) {
					ssTable.column(i).search(this.value).draw();
				}
			});
		}			
	}); */
}

function reportTable(tableId = "reportTable",tableOptions = ""){
	if(tableOptions == ""){
		tableOptions = {
			responsive: true,
			"scrollY": '52vh',
			"scrollX": true,
			deferRender: true,
			scroller: true,
			destroy: true,
			"autoWidth" : false,
			order: [],
			"columnDefs": [
				{type: 'natural',targets: 0},
				{orderable: false,targets: "_all"},
				{className: "text-center",targets: [0, 1]},
				{className: "text-center","targets": "_all"}
			],
			pageLength: 25,
			language: {search: ""},
			lengthMenu: [
				[ 10, 20, 25, 50, 75, 100, 250, -1 ],
				[ '10 rows', '20 rows', '25 rows', '50 rows', '75 rows', '100 rows','250 rows', 'Show all' ]
			],
			dom: "<'row'<'col-sm-7'B><'col-sm-5'f>>" + "<'row'<'col-sm-12't>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
			buttons: {
                dom: {
                    button: {
                        className: "btn btn-outline-success btn-sm m-r-1 m-l-1"
                    }
                },
                buttons:[ 'pageLength', 'excel', {text: 'Refresh',action: function (){$(".refreshReportData").trigger('click');} }]
            },
			"fnInitComplete":function(){ $('.dataTables_scrollBody').perfectScrollbar(); },
    		"fnDrawCallback": function() { $('.dataTables_scrollBody').perfectScrollbar('destroy').perfectScrollbar(); }
		};
	}

	var reportTable = $('#'+tableId).DataTable(tableOptions);
	reportTable.buttons().container().appendTo( '#'+tableId+'_wrapper toolbar' );
	$('.dataTables_filter .form-control-sm').css("width","97%");
	$('.dataTables_filter .form-control-sm').attr("placeholder","Search.....");
	$('.dataTables_filter').css("text-align","left");
	$('.dataTables_filter label').css("display","block");
	$('.btn-group>.btn:first-child').css("border-top-right-radius","0");
	$('.btn-group>.btn:first-child').css("border-bottom-right-radius","0");

	//setTimeout(function(){ reportTable.columns.adjust().draw();}, 10);
	//$('.page-wrapper').resizer(function() { reportTable.columns.adjust().draw(); });

	return reportTable;
}