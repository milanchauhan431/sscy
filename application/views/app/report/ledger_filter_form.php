<div class="modal fade dialogbox" id="filter-modal" data-bs-backdrop="static" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filters</h5>
            </div>
            <div class="modal-body">
                <form id="filter_form" data-page_name="ledger">
                    <div class="col-md-12">
                        <div class="row">

                            <div class="form-group basic animated">
                                <div class="input-wrapper">
                                    <label class="label" for="to_date">To Date</label>
                                    <input type="date" name="to_date" id="to_date" class="form-control" value="<?=date("Y-m-d")?>">
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="btn-inline">
                    <a href="#" id="clearFilters" class="btn btn-text-secondary" data-bs-dismiss="modal">Clear</a>
                    <a href="#" id="applyFilter" class="btn btn-text-success" data-bs-dismiss="modal">Apply</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $("#filter-btn").removeClass('text-warning').addClass('text-success');
    if(localStorage.ledger){
        var applyedFilters = JSON.parse(localStorage.ledger);
        $.each(applyedFilters.filters,function(key,value){ $("#filter_form #"+key).val(value); });
        $("#filter-modal .select2").select2(); 
        $("#filter-btn").removeClass('text-success').addClass('text-warning');
    }
});
</script>