<div class="modal fade modalbox" id="view-cart-modal" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="background: #EDEDF5;">
            <div class="modal-header">
                <a href="#" class="fs-px-30 text-danger btn-close" data-bs-dismiss="modal"><ion-icon name="close-outline"></ion-icon></a>
                <h5 class="modal-title">My Cart</h5>
                <a href="#" class="btn btn-warning" onclick="confirmStore({'formId':'cartItemList','fnsave':'saveOrder','controller':'orders'});">Place Order</a>
            </div>                 
            <div class="modal-body">
                <form id="cartItemList" data-confirm_message="Are you sure to place this order?" data-res_function="resSaveOrder"> 
                
                </form>
            </div>                        
        </div>
    </div>
</div>
