<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" /> -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#FFFFFF">
    <title><?=SITENAME?> - <?=(isset($headData->pageName)) ? $headData->pageName : '' ?></title>
    
    <link rel="icon" type="image/png" href="<?=base_url("assets/dist/img/icon.png")?>" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=base_url("assets/dist/img/app-img/icon/192x192.png")?>">

    <!-- App Style -->
    <link rel="stylesheet" href="<?=base_url("assets/css/app-css/style.css")?>">
    <link rel="stylesheet" href="<?=base_url("assets/css/app-css/app-style.css")?>">

    <!-- Select2 -->
    <link rel="stylesheet" href="<?=base_url("assets/plugins/select2/css/select2.min.css")?>">
    <link rel="stylesheet" href="<?=base_url("assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css")?>">

    <!-- Multi Select -->
    <link rel="stylesheet" href="<?=base_url("assets/plugins/multiselect/css/bootstrap-multiselect.css")?>">

    <!-- font-awesome CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Jquery Confirm -->
    <link href="<?=base_url("assets/css/jquery-confirm.css");?>" rel="stylesheet" type="text/css">

    <link rel="manifest" href="<?=base_url("assets/js/app-js/__manifest.json")?>">
</head>

<body>

    <!-- loader -->
    <div id="loader">
        <img src="<?=base_url("assets/dist/img/app-img/loading-icon.gif")?>" alt="icon" class="loader-img loading-icon1">
    </div>
    <!-- * loader -->