<!-- App Header -->
<div class="appHeader bg-success text-light">
    <div class="left">
        <a href="#" class="headerButton" data-bs-toggle="modal" data-bs-target="#sidebarPanel">
            <ion-icon name="menu-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">
        <!-- <img src="<?=base_url("assets/dist/img/logo.png")?>" alt="logo" class="logo"> -->
        <h2 class="text-center text-white font-weight-bolder" style="font-weight: 700;margin-top: 1%;    font-size: 2rem; margin-bottom: 0rem;"><?=SITENAME?></h2>
    </div>
    <div class="right">
        <!-- <a href="app-notifications.html" class="headerButton">
            <ion-icon class="icon" name="notifications-outline"></ion-icon>
            <span class="badge badge-danger">4</span>
        </a> -->
        <a href="<?=base_url("app/myProfile")?>" class="headerButton">
            <img src="<?=$this->userImage?>" alt="image" class="imaged w32">
        </a>
    </div>
</div>
<!-- * App Header -->