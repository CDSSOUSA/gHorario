<footer class="main-footer">

  <div class="float-right d-none d-sm-inline">
    Anything you want
  </div>

  <strong>Copyright © 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
</footer>

</div>


<?php
    //dd($css);    
   foreach ($js as $path) : ?>     
      <script src="<?=$path;?>"></script>
   <?php endforeach; ?>

<script>
  $(document).ready(function() {
    var table = $('#example').DataTable({
      scrollY: "480px",
      scrollX: true,
      scrollCollapse: true,
      paging: false,
      ordering: false,
      info: false,
      searching: false,
      stateSave: true,
      fixedHeader: true,
      fixedColumns: {
        left: 2,
        //right: 1
      }
    });
    $('[data-toggle="tooltip"]').tooltip()
  });

  $(document).ready(function() {
    setTimeout(function() {
      $(".alert-close").fadeOut("slow", function() {
        $(this).alert('close');
      });
    }, 5000);
  });

  $("input[type=checkbox]").bootstrapSwitch({
    onText: '<i class="fa fa-check"></i>',
    offText: '',
    size: "mini",
    onColor: "success"
  });
  // $("input[type=checdkbox]").bootstrapSwitch({
  //   onText: '<i class="fa fa-check"></i>',
  //   offText: '',
  //   size: "mini",
  //   onColor: "success"
  // });

  $(function() {
    $('[data-toggle="tooltip"]').tooltip()
  })
</script>

</body>

</html>