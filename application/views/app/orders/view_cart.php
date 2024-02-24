<div class="modal fade modalbox" id="view-cart" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="background: #EDEDF5;">
            <div class="modal-header">
                <a href="#" class="fs-px-30 text-danger btn-close" data-bs-dismiss="modal"><ion-icon name="close-outline"></ion-icon></a>
                <h5 class="modal-title">My Cart</h5>
                <a href="#" class="btn btn-warning">Place Order</a>
            </div>
            <div class="modal-body">
                <div class="section mt-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="cart-item">
                                <div class="detail">
                                    <img src="http://localhost/sscy/assets/dist/img/avatar.png" alt="img" class="image-block imaged w48" style="border:1px solid #c4c4c4;">
                                    <div>
                                        <strong>Milan Chauhan</strong><br>
                                        <small>Code : M001<br></small>
                                        <small>Contact No. : 8160897829</small>
                                    </div>
                                </div>
                                <div class="right">
                                    <div class="qty-input float-end">
                                        <button class="qty-count qty-count--minus" data-action="minus" type="button">-</button>
                                        <input class="product-qty numericOnly" type="number" name="qty" min="0" max="1000" value="0" step="1" pattern="[0-9]*">
                                        <button class="qty-count qty-count--add" data-action="add" type="button">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <span class="text-danger"><ion-icon name="trash"></ion-icon> Remove</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>