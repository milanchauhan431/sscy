<div class="modal fade dialogbox" id="print-modal" data-bs-backdrop="static" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Print</h5>
            </div>
            <div class="modal-body">
                <form id="print_form" action="<?=base_url("app/orders/printOrder")?>">
                    <div class="col-md-12">
                        <div class="row">

                            <div class="form-group basic animated">
                                <div class="input-wrapper">
                                    <label class="label" for="trans_date">Date</label>
                                    <input type="date" name="trans_date" id="trans_date" class="form-control" value="<?=date("Y-m-d")?>">
                                </div>
                                <div class="error trans_date"></div>
                            </div>

                            <div class="form-group basic animated">
                                <div class="input-wrapper">
                                    <label class="label" for="party_id">Code</label>
                                    <select name="party_id" id="party_id" class="form-control selectBox select2">
                                        <option value="">Select Code</option>
                                        <?php
                                            foreach($userList as $row):
                                                echo '<option value="'.$row->id.'">'.$row->user_code.'</option>';
                                            endforeach;
                                        ?>
                                    </select>
                                </div>
                                <div class="error party_id"></div>
                            </div>
                            
                            <div class="form-group basic animated">
                                <div class="input-wrapper">
                                    <label class="label" for="trans_status">Order Status</label>
                                    <select name="trans_status" id="trans_status" class="form-control selectBox select2">
                                        <option value="">All</option>
                                        <option value="0">Pending</option>
                                        <option value="1">Accepted</option>
                                        <option value="2">Competed</option>
                                        <option value="3">Cancled</option>
                                        <option value="4">Rejected</option>
                                    </select>
                                </div>
                                <div class="error trans_status"></div>
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

        /* var form = $('#print_form')[0];
	    var fd = new FormData(form);
        var action_url = $("#print_form").attr("action");

        $.ajax({
            url: action_url,
            data:fd,
            type: "POST",
            processData:false,
            contentType:false,
            dataType:"json",        
        }).done(function(data){
            if(data.status==1){
                $("#print-modal").modal('hide');
                toastbox('success',"PDF Generated successfully.", 3000);
            }else{
                if(typeof data.message === "object"){
                    $(".error").html("");
                    $.each( data.message, function( key, value ) {$("."+key).html(value);});
                }else{
                    toastbox('error',data.message, 3000);
                }			
            }
        }); */	

        $('#print_form .error').html("");
        var trans_date = $("#print_form #trans_date").val();
        var party_id = $("#print_form #party_id").val();
        var trans_status = $("#print_form #trans_status").val();
        var action_url = $("#print_form").attr("action");

        if(trans_date == ""){
            $(".trans_date").html("Date is required.");
        }
        if(party_id == ""){
            $(".party_id").html("Kariger Code is required.");
        }

        var errorCount = $('#print_form .error:not(:empty)').length;

        if (errorCount == 0) {
            var postData = {trans_date:trans_date,party_id:party_id,trans_status:trans_status}; 
            var url = action_url + '/' + encodeURIComponent(window.btoa(JSON.stringify(postData)));
            window.open(url);
            $("#print-modal").modal('hide');
            toastbox('success',"PDF Generated successfully.", 3000);
        }
    });
});
</script>