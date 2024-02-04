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
    <a href="<?=base_url("app/products")?>" class="item <?=($headData->controller == "products")?"active":""?>">
        <div class="col">
            <ion-icon name="cart-outline"></ion-icon>
            <strong>Product</strong>
        </div>
    </a>
    <a href="<?=base_url("app/orders")?>" class="item <?=($headData->controller == "orders")?"active":""?>">
        <div class="col">
            <ion-icon name="document-text-outline"></ion-icon>
            <strong>My Orders</strong>
        </div>
    </a>    
    <a href="<?=base_url("app/uaerMaster/userProfile")?>" class="item <?=($headData->controller == "uaerMaster/userProfile")?"active":""?>">
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
                <div class="profileBox pt-1 pb-1 bg-success">
                    <div class="image-wrapper">
                        <img src="<?=base_url("assets/dist/img/icon.png")?>" alt="image" class="imaged w50">
                    </div>
                    <div class="in">
                        <strong>SADHNA</strong>
                        <!-- <div class="text-muted">4029209</div> -->
                    </div>
                    <a href="#" class="btn btn-link btn-icon sidebar-close" data-bs-dismiss="modal">
                        <ion-icon name="close-outline"></ion-icon>
                    </a>
                </div>
                <!-- * profile box -->
                <!-- balance -->
                <!-- <div class="sidebar-balance">
                    <div class="listview-title">Balance</div>
                    <div class="in">
                        <h1 class="amount">$ 2,562.50</h1>
                    </div>
                </div> -->
                <!-- * balance -->

                <!-- action group -->
                <!-- <div class="action-group">
                    <a href="index.html" class="action-button">
                        <div class="in">
                            <div class="iconbox">
                                <ion-icon name="add-outline"></ion-icon>
                            </div>
                            Deposit
                        </div>
                    </a>
                    <a href="index.html" class="action-button">
                        <div class="in">
                            <div class="iconbox">
                                <ion-icon name="arrow-down-outline"></ion-icon>
                            </div>
                            Withdraw
                        </div>
                    </a>
                    <a href="index.html" class="action-button">
                        <div class="in">
                            <div class="iconbox">
                                <ion-icon name="arrow-forward-outline"></ion-icon>
                            </div>
                            Send
                        </div>
                    </a>
                    <a href="app-cards.html" class="action-button">
                        <div class="in">
                            <div class="iconbox">
                                <ion-icon name="card-outline"></ion-icon>
                            </div>
                            My Cards
                        </div>
                    </a>
                </div> -->
                <!-- * action group -->

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
                        <a href="<?=base_url("app/uaerMaster")?>" class="item <?=($headData->controller == "uaerMaster")?"active-item":""?>">
                            <div class="icon-box bg-success">
                                <ion-icon name="people-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Kariger
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url("app/products")?>" class="item <?=($headData->controller == "products")?"active-item":""?>">
                            <div class="icon-box bg-success">
                                <ion-icon name="cart-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Product
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url("app/orders")?>" class="item <?=($headData->controller == "orders")?"active-item":""?>">
                            <div class="icon-box bg-success">
                                <ion-icon name="document-text-outline"></ion-icon>
                            </div>
                            <div class="in">
                                My Orders
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
                </ul>
                <!-- * menu -->

                <!-- others -->
                <!-- <div class="listview-title mt-1">Others</div>
                <ul class="listview flush transparent no-line image-listview">
                    <li>
                        <a href="app-settings.html" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="settings-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Settings
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="component-messages.html" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="chatbubble-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Support
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="app-login.html" class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="log-out-outline"></ion-icon>
                            </div>
                            <div class="in">
                                Log out
                            </div>
                        </a>
                    </li>


                </ul> -->
                <!-- * others -->

                <!-- send money -->
                <!-- <div class="listview-title mt-1">Send Money</div>
                <ul class="listview image-listview flush transparent no-line">
                    <li>
                        <a href="#" class="item">
                            <img src="assets/img/sample/avatar/avatar2.jpg" alt="image" class="image">
                            <div class="in">
                                <div>Artem Sazonov</div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="item">
                            <img src="assets/img/sample/avatar/avatar4.jpg" alt="image" class="image">
                            <div class="in">
                                <div>Sophie Asveld</div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="item">
                            <img src="assets/img/sample/avatar/avatar3.jpg" alt="image" class="image">
                            <div class="in">
                                <div>Kobus van de Vegte</div>
                            </div>
                        </a>
                    </li>
                </ul> -->
                <!-- * send money -->

            </div>
        </div>
    </div>
</div>
<!-- * App Sidebar -->