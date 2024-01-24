<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-teal elevation-4">
    <!-- Brand Logo -->
    <a href="<?=base_url("dashboard")?>" class="brand-link">
        <img src="<?=base_url("assets/dist/img/deckle_logo.png")?>" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">

        <!-- <img src="<?=base_url("assets/dist/img/deckle_text_logo.png")?>" alt="Logo" class="brand-image elevation-3" style="opacity: .8;border:1px solid black; border-radius:0.2rem;"> -->

        <h3 class="brand-text font-weight-light ml-10" style="font-weight: 600 !important; "><?=SITENAME?></h3>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div> -->

        <!-- SidebarSearch Form -->
        <div class="form-inline mt-4">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
                    <a href="<?=base_url("dashboard")?>" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-map-marker"></i>
                        <p>
                            Location
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?=base_url("countries")?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Country</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=base_url("states")?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>State</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=base_url("cities")?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>City</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>