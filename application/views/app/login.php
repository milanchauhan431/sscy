<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#FFFFFF">
    <title><?=SITENAME?> - LOGIN</title>
    
    <link rel="icon" type="image/png" href="<?=base_url("assets/dist/img/icon.png")?>" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=base_url("assets/dist/img/app-img/icon/192x192.png")?>">
    
    <link rel="stylesheet" href="<?=base_url("assets/css/app-css/style.css")?>">
    <link rel="stylesheet" href="<?=base_url("assets/css/app-css/app-style.css")?>">
    <link rel="manifest" href="<?=base_url("assets/js/app-js/__manifest.json")?>">
</head>

<body>

    <!-- loader -->
    <div id="loader">
        <img src="<?=base_url("assets/dist/img/app-img/loading-icon.gif")?>" alt="icon" class="loader-img loading-icon1">
    </div>
    <!-- * loader -->


    <!-- App Capsule -->
    <div id="appCapsule" style="padding-top:10px;">

        <div class="section mt-2 text-center" style="margin-top:0px;">
            <img src="<?=base_url()?>assets/dist/img/icon.png" style="border-radius:18%; margin-bottom:50px;" alt="logo" width="180"/>

            <h1>Log in</h1>
            <h4>Fill the form to log in</h4>
        </div>

        <div class="section mb-5 p-2">
            <form id="loginform" action="<?=base_url('app/login/auth');?>" method="POST">
                <div class="card">
                    <div class="card-body pb-1">
                        <?php if($errorMsg = $this->session->flashdata('loginError')): ?>
                            <div class="error errorMsg text-center"><?=$errorMsg?></div>
                        <?php endif; ?>

                        <input type="hidden" name="app_push_token" id="app_push_token" value="">
                        <div class="form-group basic animated">
                            <div class="input-wrapper">
                                <label class="label" for="user_name">Mobile No.</label>
                                <input type="text" class="form-control" name="user_name" id="user_name" placeholder="Your Mobile No.">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                            <?=form_error('user_name')?>
                        </div>

                        <div class="form-group basic animated">
                            <div class="input-wrapper">
                                <label class="label" for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" autocomplete="off"
                                    placeholder="Your password">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                            <?=form_error('password')?>
                        </div>
                    </div>
                </div>


                <div class="form-links mt-2">
                    <div class="rememberMe icheck-success">
                        <input type="checkbox" id="rememberMe" onclick="lsRememberMe()">
                        <label for="rememberMe">
                            Remember Me
                        </label>
                    </div>
                    <!-- <div><a href="app-forgot-password.html" class="text-muted">Forgot Password?</a></div> -->
                </div>

                <div class="form-button-group  transparent">
                    <button type="submit" class="btn btn-gold btn-block btn-lg">Log in</button>
                </div>

            </form>
        </div>

    </div>
    <!-- * App Capsule -->


    <!-- ========= JS Files =========  -->
    <!-- jQuery -->
    <script src="<?=base_url("assets/plugins/jquery/jquery.min.js")?>"></script>
    <!-- Bootstrap -->
    <script src="<?=base_url("assets/js/app-js/lib/bootstrap.bundle.min.js")?>"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!-- Splide -->
    <script src="<?=base_url("assets/js/app-js/plugins/splide/splide.min.js")?>"></script>
    <!-- Base Js File -->
    <script src="<?=base_url("assets/js/app-js/base.js")?>"></script>
    
    <!-- Firebase App is always required and must be first -->
    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script> 
    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js"></script>
    <script type="module" src="<?=base_url()?>assets/js/notification.js?v=<?=time()?>"></script>
</body>

</html>

<script>
const inputs = document.querySelectorAll(".input");
const rmCheck = document.getElementById("rememberMe"),emailInput = document.getElementById("user_name"),password = document.getElementById("password");
$(document).ready(function(){
    if (localStorage.sscy_checkbox && localStorage.sscy_checkbox !== "") {
        rmCheck.setAttribute("checked", "checked");
        emailInput.value = localStorage.sscy_username;
        password.value = localStorage.sscy_password;
    } else {
        rmCheck.removeAttribute("checked");
        emailInput.value = "";
        password.value = "";
    }
});

function lsRememberMe() {
    if (rmCheck.checked && emailInput.value !== "") {
        localStorage.sscy_username = emailInput.value;
        localStorage.sscy_password = password.value;
        localStorage.sscy_checkbox = rmCheck.value;
    } else {
        localStorage.sscy_username = "";
        localStorage.sscy_password = "";
        localStorage.sscy_checkbox = "";
    }
}

if (Notification.permission !== "granted"){  
    Notification.requestPermission();
}
</script>