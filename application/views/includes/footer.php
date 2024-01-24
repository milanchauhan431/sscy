<!-- /.content-wrapper -->
<footer class="main-footer">
    <strong>Copyright &copy; 2021-<?=date("Y")?> <a href="#">Deckle</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<?php 
  $this->load->view("includes/footerfiles"); 
  $this->load->view("includes/modal"); 
?>
<script>
$(document).ready(function(){
    $(document).on('click','#logout',function(){
        localStorage.authToken = "";
        /* var username = localStorage.username;
        var password = localStorage.password;
        localStorage.clear();
        localStorage.username = username;
        localStorage.password = password; */
        window.location.href = base_url;
    });
});
</script>
</body>

</html>