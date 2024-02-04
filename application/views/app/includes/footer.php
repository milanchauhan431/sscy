    <?php $this->load->view("app/includes/sidebar"); ?>
    
    <!-- iOS Add to Home Action Sheet -->
    <div class="modal inset fade action-sheet ios-add-to-home" id="ios-add-to-home-screen" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add to Home Screen</h5>
                    <a href="#" class="close-button" data-bs-dismiss="modal">
                        <ion-icon name="close"></ion-icon>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="action-sheet-content text-center">
                        <div class="mb-1"><img src="<?=base_url("assets/dist/img/app-img/icon/192x192.png")?>" alt="image" class="imaged w64 mb-2">
                        </div>
                        <div>
                            Install <strong>App</strong> on your iPhone's home screen.
                        </div>
                        <div>
                            Tap <ion-icon name="share-outline"></ion-icon> and Add to homescreen.
                        </div>
                        <div class="mt-2">
                            <button class="btn btn-primary btn-block" data-bs-dismiss="modal">CLOSE</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- * iOS Add to Home Action Sheet -->


    <!-- Android Add to Home Action Sheet -->
    <div class="modal inset fade action-sheet android-add-to-home" id="android-add-to-home-screen" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add to Home Screen</h5>
                    <a href="#" class="close-button" data-bs-dismiss="modal">
                        <ion-icon name="close"></ion-icon>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="action-sheet-content text-center">
                        <div class="mb-1">
                            <img src="<?=base_url("assets/dist/img/app-img/icon/192x192.png")?>" alt="image" class="imaged w64 mb-2">
                        </div>
                        <div>
                            Install <strong>App</strong> on your Android's home screen.
                        </div>
                        <div>
                            Tap <ion-icon name="ellipsis-vertical"></ion-icon> and Add to homescreen.
                        </div>
                        <div class="mt-2">
                            <button class="btn btn-primary btn-block" data-bs-dismiss="modal">CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- * Android Add to Home Action Sheet -->

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
    <script src="<?=base_url("assets/js/app-js/base.js?v=".time())?>"></script>

    <!-- Custom JS -->
    <script src="<?=base_url("assets/js/app-js/app-comman.js?v=".time())?>"></script>
    <script src="<?=base_url("assets/js/app-js/app-lazy-load.js?v=".time())?>"></script>

    <script>
        // Add to Home with 2 seconds delay.
        AddtoHome("2000", "once");
    </script>

    <?php $this->load->view("app/includes/modal.php"); ?>
</body>

</html>