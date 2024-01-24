<script>
var base_url = "<?=base_url()?>";
var controller = '<?=(isset($pageName)) ? $pageName : ''?>';
var api_url = '<?=API_URL?>';
</script>

<!-- jQuery -->
<script src="<?=base_url("assets/plugins/jquery/jquery.min.js")?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?=base_url("assets/plugins/jquery-ui/jquery-ui.min.js")?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?=base_url("assets/plugins/bootstrap/js/bootstrap.bundle.min.js")?>"></script>
<!-- ChartJS -->
<script src="<?=base_url("assets/plugins/chart.js/Chart.min.js")?>"></script>
<!-- Sparkline -->
<script src="<?=base_url("assets/plugins/sparklines/sparkline.js")?>"></script>
<!-- JQVMap -->
<script src="<?=base_url("assets/plugins/jqvmap/jquery.vmap.min.js")?>"></script>
<script src="<?=base_url("assets/plugins/jqvmap/maps/jquery.vmap.usa.js")?>"></script>
<!-- jQuery Knob Chart -->
<script src="<?=base_url("assets/plugins/jquery-knob/jquery.knob.min.js")?>"></script>
<!-- daterangepicker -->
<script src="<?=base_url("assets/plugins/moment/moment.min.js")?>"></script>
<script src="<?=base_url("assets/plugins/daterangepicker/daterangepicker.js")?>"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?=base_url("assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js")?>">
</script>
<!-- Summernote -->
<script src="<?=base_url("assets/plugins/summernote/summernote-bs4.min.js")?>"></script>
<!-- overlayScrollbars -->
<script src="<?=base_url("assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js")?>"></script>
<!-- Toastr -->
<script src="<?=base_url("assets/plugins/toastr/dist/build/toastr.min.js")?>"></script>
<!-- AdminLTE App -->
<script src="<?=base_url("assets/dist/js/adminlte.js")?>"></script>
<script src="<?=base_url("assets/js/waves.js")?>"></script>

<!-- DataTables  & Plugins -->
<script src="<?=base_url("assets/plugins/datatables/jquery.dataTables.min.js")?>"></script>
<script src="<?=base_url("assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js")?>"></script>
<script src="<?=base_url("assets/plugins/datatables-responsive/js/dataTables.responsive.min.js")?>"></script>
<script src="<?=base_url("assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js")?>"></script>
<script src="<?=base_url("assets/plugins/datatables-buttons/js/dataTables.buttons.min.js")?>"></script>
<script src="<?=base_url("assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js")?>"></script>
<script src="<?=base_url("assets/plugins/datatables-buttons/js/buttons.html5.min.js")?>"></script>
<script src="<?=base_url("assets/plugins/datatables-buttons/js/buttons.print.min.js")?>"></script>
<script src="<?=base_url("assets/plugins/datatables-buttons/js/buttons.colVis.min.js")?>"></script>
<script src="<?=base_url("assets/plugins/datatables/natural.js")?>"></script>
<script src="<?=base_url("assets/plugins/datatables/dataTables.fixedHeader.min.js")?>"></script>
<script src="<?=base_url("assets/plugins/jszip/jszip.min.js")?>"></script>
<script src="<?=base_url("assets/plugins/pdfmake/pdfmake.min.js")?>"></script>
<script src="<?=base_url("assets/plugins/pdfmake/vfs_fonts.js")?>"></script>

<script src="<?=base_url("assets/plugins/datatables/DateTime/js/dataTables.dateTime.min.js")?>"></script>
<script src="<?=base_url("assets/plugins/datatables/DataRender/datetime.js")?>"></script>
<script src="<?=base_url("assets/plugins/moment/moment.min.js")?>"></script>

<!-- jquery-validation -->
<script src="<?=base_url("assets/plugins/jquery-validation/jquery.validate.min.js?=".time())?>"></script>
<script src="<?=base_url("assets/plugins/jquery-validation/additional-methods.min.js?=".time())?>"></script>

<!-- Select2 -->
<script src="<?=base_url("assets/plugins/select2/js/select2.full.min.js")?>"></script>

<!-- Jquery Confirm -->
<script src="<?=base_url("assets/js/jquery-confirm.js");?>"></script>

<!-- Custom JS -->
<script src="<?=base_url("assets/js/custom/comman.js?=".time())?>"></script>
<script src="<?=base_url("assets/js/custom/ss-table.js?=".time())?>"></script>

<div class="ajaxModal"></div>
<div class="centerImg">
	<img src="<?=base_url()?>assets/dist/img/deckle_text_logo.png" style="width:100%;height:auto;"><br>
	<img src="<?=base_url()?>assets/dist/img/ajaxLoading.gif" style="margin-top:-15px;width:65%;height:auto;background:transparent;">
</div>
