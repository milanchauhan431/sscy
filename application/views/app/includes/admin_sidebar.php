<!-- App Bottom Menu -->
<div class="appBottomMenu">
    <a href="<?=base_url("app/dashboard")?>" class="item <?=($headData->controller == "dashboard")?"active":""?>">
        <div class="col">
            <ion-icon name="pie-chart-outline"></ion-icon>
            <strong>Overview</strong>
        </div>
    </a>

    <a href="<?=base_url("app/userMaster")?>" class="item <?=($headData->controller == "userMaster")?"active":""?>">
        <div class="col">
            <ion-icon name="people-outline"></ion-icon>
            <strong>Karigar</strong>
        </div>
    </a>

    <a href="<?=base_url("app/orders")?>" class="item <?=($headData->controller == "orders")?"active":""?>">
        <div class="col">
            <ion-icon name="cart-outline"></ion-icon>
            <strong>Product</strong>
        </div>
    </a>    
    
    <a href="<?=base_url("app/myOrders")?>" class="item <?=($headData->controller == "myOrders")?"active":""?>">
        <div class="col">
            <ion-icon name="document-text-outline"></ion-icon>
            <strong>My Orders</strong>
        </div>
    </a>    

    <a href="<?=base_url("app/myProfile")?>" class="item <?=($headData->controller == "myProfile")?"active":""?>">
        <div class="col">
            <ion-icon name="settings-outline"></ion-icon>
            <strong>My Profile</strong>
        </div>
    </a>
</div>
<!-- * App Bottom Menu -->

<!-- App Sidebar -->
<div class="modal fade panelbox panelbox-left" id="sidebarPanel" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <!-- profile box -->
                <div class="profileBox pt-1 pb-1 bg-gold">
                    <div class="image-wrapper">
                        <img src="<?=base_url("assets/dist/img/icon.png")?>" alt="image" class="imaged w50">
                    </div>
                    <div class="in">
                        <strong><?=SITENAME?></strong>
                    </div>
                    <a href="#" class="btn btn-link btn-icon sidebar-close text-dark" data-bs-dismiss="modal">
                        <ion-icon name="close-outline" class="fs-px-50"></ion-icon>
                    </a>
                </div>

                <!-- menu -->
                <div class="listview-title mt-1">Menu</div>
                <ul class="listview flush transparent no-line image-listview">
                    <li>
                        <a href="<?=base_url("app/dashboard")?>" class="item <?=($headData->controller == "dashboard")?"active-item":""?>">
                            <div class="icon-box bg-success">
                                <ion-icon name="pie-chart-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Overview
                                <span class="badge badge-success">10</span>
                            </div>
                        </a>
                    </li>
                    
                    <li>
                        <a href="<?=base_url("app/userMaster")?>" class="item <?=($headData->controller == "userMaster")?"active-item":""?>">
                            <div class="icon-box bg-success">
                                <ion-icon name="people-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Kariger
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="<?=base_url("app/itemGroup")?>" class="item <?=($headData->controller == "itemGroup")?"active-item":""?>">
                            <div class="icon-box bg-success">
                                <ion-icon name="bookmark-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Item Group
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="<?=base_url("app/Orders")?>" class="item <?=($headData->controller == "Orders")?"active-item":""?>">
                            <div class="icon-box bg-success">
                                <ion-icon name="cart-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Product
                            </div>
                        </a>
                    </li>                    

                    <li>
                        <a href="<?=base_url("app/myOrders")?>" class="item <?=($headData->controller == "myOrders")?"active-item":""?>">
                            <div class="icon-box bg-success">
                                <ion-icon name="document-text-outline"></ion-icon>
                            </div>
                            <div class="in">
                                My Orders
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="<?=base_url("app/karigerLedger")?>" class="item <?=($headData->controller == "karigerLedger")?"active-item":""?>">
                            <div class="icon-box bg-success">
                                <ion-icon name="book-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Kariger Ledger
                            </div>
                        </a>
                    </li>

                    <li>
                        <a href="<?=base_url("app/logout")?>" class="item">
                            <div class="icon-box bg-success">
                                <ion-icon name="log-out-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Log out
                            </div>
                        </a>
                    </li>

                    <!-- <li>
                        <a href="#" class="item" id="forceReload">
                            <div class="icon-box bg-success">
                                <ion-icon name="reload-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Force Reload
                            </div>
                        </a>
                    </li> -->
                </ul>
                <!-- * menu -->
            </div>
        </div>
    </div>
</div>
<!-- * App Sidebar -->