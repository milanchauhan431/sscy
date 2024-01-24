<!DOCTYPE html>
<html lang="en">

<?php $this->load->view('includes/headerfiles'); ?>

<body class="sidebar-mini layout-fixed layout-footer-fixed layout-navbar-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center" >
            <img class="animation__shake" src="<?=base_url("assets/dist/img/deckle_logo.png")?>" alt="Deckle Logo" height="80" width="80" style="border:1px solid black; border-radius:3rem;">
        </div>

        <?php $this->load->view('includes/navbar'); ?>
        <?php $this->load->view('includes/sidebar'); ?>