<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title><?=SITENAME?> - 404 Page</title>
    
    <link rel="icon" type="image/png" href="<?=base_url("assets/dist/img/icon.png")?>" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=base_url("assets/dist/img/app-img/icon/192x192.png")?>">

    <link rel="stylesheet" href="<?=base_url("assets/css/app-css/style.css")?>">
    <link rel="stylesheet" href="<?=base_url("assets/css/app-css/app-style.css")?>">
    <link rel="manifest" href="<?=base_url("assets/js/app-js/__manifest.json")?>">
</head>

<body class="bg-white">

    <!-- loader -->
    <div id="loader">
        <img src="<?=base_url("assets/dist/img/app-img/loading-icon.gif")?>" alt="icon" class="loader-img loading-icon1">
    </div>
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader no-border">
        <div class="left">
            <a href="<?=base_url("app/login")?>" class="headerButton goBack1 text-dark">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            404 Page
        </div>
        <div class="right">
        </div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">

        <div class="section">
            <div class="splash-page mt-5 mb-5">
                <h1>404</h1>
                <h2 class="mb-2">Page not found!</h2>
            </div>
        </div>

        <div class="fixed-bar">
            <div class="row">
                <div class="col-12">
                    <a href="<?=base_url("app/login")?>" class="btn btn-lg btn-outline-danger btn-block goBack">Go Back</a>
                </div>
                <!-- <div class="col-6">
                    <a href="app-pages.html" class="btn btn-lg btn-primary btn-block">Try Again</a>
                </div> -->
            </div>
        </div>

    </div>
    <!-- * App Capsule -->


    <!-- ========= JS Files =========  -->
    <!-- Bootstrap -->
    <script src="<?=base_url("assets/js/app-js/lib/bootstrap.bundle.min.js")?>"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!-- Splide -->
    <script src="<?=base_url("assets/js/app-js/plugins/splide/splide.min.js")?>"></script>
    <!-- Base Js File -->
    <script src="<?=base_url("assets/js/app-js/base.js")?>"></script>


</body>

</html>