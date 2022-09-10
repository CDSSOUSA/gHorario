<footer class="main-footer">
  <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
  All rights reserved.
  <div class="float-right d-none d-sm-inline-block">
    <b>Version</b> 3.2.0
  </div>
</footer>

<aside class="control-sidebar control-sidebar-dark">

</aside>

</div>



<script src="<?= base_url(); ?>/assets/js/jquery.min.js"></script>
<script src="<?= base_url(); ?>/assets/plugins/jquery-ui/jquery-ui.js"></script>

<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>

<script src="<?= base_url(); ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="<?= base_url(); ?>/assets/plugins/moment/moment.min.js"></script>

<script src="<?= base_url(); ?>/assets/plugins/summernote/summernote-bs4.min.js"></script>

<script src="<?= base_url(); ?>/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="<?= base_url(); ?>/assets/plugins/bootstrap-switch/js/bootstrap-switch.js"></script>

<script src="<?= base_url(); ?>/assets/plugins/toastr/toastr.min.js"></script>

<script src="<?= base_url(); ?>/assets/dist/js/adminlte.js?v=3.2.0"></script>

<script src="<?= base_url(); ?>/assets/js/jquery.mask.min.js"></script>


<script src="<?= base_url(); ?>/assets/js/jquery.maskMoney.js"></script>
<script src="<?= base_url(); ?>/assets/js/axios.min.js"></script>
<script src="<?= base_url(); ?>/assets/js/script.js"></script>
<script src="<?= base_url(); ?>/assets/js/school-schedule.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"></script>

<script>
$(document).ready(function() {
    var table = $('#example').DataTable( {
        scrollY:        "480px",
        scrollX:        true,
        scrollCollapse: true,
        paging: false,
        ordering: false,
        info: false,    
        searching: false,
        stateSave: true,
        fixedHeader: true,    
        fixedColumns:   {
            left: 2,
            //right: 1
        }
    } );
} );

  $(document).ready(function() {
    setTimeout(function() {
      $(".alert-close").fadeOut("slow", function() {
        $(this).alert('close');
      });
    }, 1000);
  });
 
</script>

</body>

</html>