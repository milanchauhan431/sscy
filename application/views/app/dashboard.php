<?php $this->load->view("app/includes/header"); ?>
<?php $this->load->view("app/includes/topbar"); ?>

<!-- App Capsule -->
<div id="appCapsule">
    <div class="section mt-2">
        <div class="section-heading">
            <h2 class="title">Estimated Delivery</h2>
            <a href="#" class="link">View All</a>
        </div>
        <div class="transactions">
            <!-- item -->
            <a href="app-transaction-detail.html" class="item">
                <div class="detail">
                    <img src="<?=base_url("assets/dist/img/app-img/sample/brand/1.jpg")?>" alt="img" class="image-block imaged w48">
                    <div>
                        <strong>Amazon</strong>
                        <p>Shopping</p>
                    </div>
                </div>
                <div class="right">
                    <div class="price text-danger"> - $ 150</div>
                </div>
            </a>
            <!-- * item -->
        </div>
    </div>
</div>
<!-- * App Capsule -->

<?php $this->load->view("app/includes/footer"); ?>