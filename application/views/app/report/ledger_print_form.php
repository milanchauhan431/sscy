<div class="modal fade dialogbox" id="print-modal" data-bs-backdrop="static" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ledger Print</h5>
            </div>
            <div class="modal-body">
                <form id="print_form" action="<?=base_url("app/report/printLedgerSummary")?>">
                    <div class="col-md-12">
                        <div class="row">

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
    $(document).on('click','#print',function(e){
        e.preventDefault();
        e.stopImmediatePropagation();

        $('#print_form .error').html("");
        var to_date = $("#print_form #to_date").val();
        var action_url = $("#print_form").attr("action");

        if(to_date == ""){
            $(".to_date").html("Date is required.");
        }

        var errorCount = $('#print_form .error:not(:empty)').length;

        if (errorCount == 0) {
            var postData = {to_date:to_date}; 
            var url = action_url + '/' + encodeURIComponent(window.btoa(JSON.stringify(postData)));
            window.open(url);
            $("#print-modal").modal('hide');
            toastbox('success',"PDF Generated successfully.", 3000);
        }
    });
});
</script>