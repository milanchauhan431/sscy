<div class="modal fade dialogbox" id="filter-modal" data-bs-backdrop="static" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filters</h5>
            </div>
            <div class="modal-body">
                <form id="filter_form" data-page_name="orders">
                    <div class="col-md-12">
                        <div class="row">

                            <div class="form-group basic animated">
                                <div class="input-wrapper">
                                    <label class="label" for="item_code">Code</label>
                                    <select name="item_code" id="item_code" class="form-control selectBox select2">
                                        <option value="">Select Code</option>
                                        <?php
                                            foreach($userList as $row):
                                                echo '<option value="'.$row->user_code.'">'.$row->user_code.'</option>';
                                            endforeach;
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group basic animated">
                                <div class="input-wrapper">
                                    <label class="label" for="group_id">Group</label>
                                    <select name="group_id" id="group_id" class="form-control selectBox select2">
                                        <option value="">Select Group</option>
                                        <?php
                                            foreach($itemGroupList as $row):
                                                echo '<option value="'.$row->id.'">'.$row->group_name.'</option>';
                                            endforeach;
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <!-- <div class="form-group basic animated">
                                <div class="input-wrapper">
                                    <label class="label" for="category_id">Category</label>
                                    <select name="category_id" id="category_id" class="form-control selectBox select2">
                                        <option value="">Select Category</option>
                                        <?php
                                            /* foreach($itemCategoryList as $row):
                                                echo '<option value="'.$row->id.'">'.$row->category_name.'</option>';
                                            endforeach; */
                                        ?>
                                    </select>
                                </div>
                            </div> -->

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
    if(localStorage.orders){
        var applyedFilters = JSON.parse(localStorage.orders);
        $.each(applyedFilters.filters,function(key,value){ $("#filter_form #"+key).val(value); });
        $("#filter-modal .select2").select2(); 
        $("#filter-btn").removeClass('text-success').addClass('text-warning');
    }  
});
</script>