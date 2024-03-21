<div class="modal fade dialogbox" id="print-modal" data-bs-backdrop="static" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ledger Detail Print</h5>
            </div>
            <div class="modal-body">
                <form id="print_form" action="<?=base_url("app/report/printLedgerDetail")?>">
                    <div class="col-md-12">
                        <div class="row">
                            <input type="hidden" id="party_id" value="<?=$userData->id?>">

                            <div class="form-group basic animated">
                                <div class="input-wrapper">
                                    <label class="label" for="from_date">From Date</label>
                                    <input type="date" name="from_date" id="from_date" class="form-control" value="<?=date("Y-m-d")?>">
                                </div>
                                <div class="error from_date"></div>
                            </div>

                            <div class="form-group basic animated">
                                <div class="input-wrapper">
                                    <label class="label" for="to_date">To Date</label>
                                    <input type="date" name="to_date" id="to_date" class="form-control" value="<?=date("Y-m-d")?>">
                                </div>
                                <div class="error to_date"></div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="btn-inline">
                    <a href="#" class="btn btn-text-secondary" data-bs-dismiss="modal">Cancel</a>
                    <a href="#" id="print" class="btn btn-text-success">Print</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    $(document).on('change','#print_form #from_date',function(){
		var inputDate = $("#print_form #from_date").val();
		if (inputDate) {
			var dateObj = new Date(inputDate);
			dateObj.setDate(dateObj.getDate());

			var resultDate = dateObj.toISOString().split('T')[0];
			$("#print_form #to_date").val(resultDate);
			$("#print_form #to_date").attr('min',resultDate);
		}
	});
    
    $(document).on('click','#print',function(e){
        e.preventDefault();
        e.stopImmediatePropagation();

        $('#print_form .error').html("");
        var party_id = $("#print_form #party_id").val();
        var from_date = $("#print_form #from_date").val();
        var to_date = $("#print_form #to_date").val();
        var action_url = $("#print_form").attr("action");


        if(from_date == ""){
            $(".from_date").html("From Date is required.");
        }
        if(to_date == ""){
            $(".to_date").html("To Date is required.");
        }

        var errorCount = $('#print_form .error:not(:empty)').length;

        if (errorCount == 0) {
            var postData = {party_id:party_id,from_date:from_date,to_date:to_date}; 
            var url = action_url + '/' + encodeURIComponent(window.btoa(JSON.stringify(postData)));
            window.open(url);
            $("#print-modal").modal('hide');
            toastbox('success',"PDF Generated successfully.", 3000);
        }
    });
});
</script>