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

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="<?= base_url(); ?>/assets/js/script.js"></script>
<script src="<?= base_url(); ?>/assets/js/school-schedule.js"></script>
<script>

  $(document).ready(function() {
    setTimeout(function() {
      $(".alert-close").fadeOut("slow", function() {
        $(this).alert('close');
      });
    }, 1000);
  });

  $(document).ready(function() {
    $(".moeda").maskMoney({showSymbol: true, thousands: '.', decimal: ',', symbolStay: true});
    $('.number_account').mask('9999999999-A');
    $('.date').mask('00/00/0000');
    $('.time').mask('00:00:00');
    $('.date_time').mask('00/00/0000 00:00:00');
    $('.cep').mask('00000-000');
    $('.phone').mask('0000-0000');
    $('.phone_with_ddd').mask('(00) 0000-0000');
    $('.phone_us').mask('(000) 000-0000');
    $('.mixed').mask('AAA 000-S0S');
    $('.cpf').mask('000.000.000-00', {
      reverse: true
    });
    $('.cnpj').mask('00.000.000/0000-00', {
      reverse: true
    });
    $('.money').mask('000.000.000.000.000,00', {
      reverse: true
    });
    $('.money2').mask("#.##0,00", {
      reverse: true
    });
    $('.ip_address').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
      translation: {
        'Z': {
          pattern: /[0-9]/,
          optional: true
        }
      }
    });
    $('.ip_address').mask('099.099.099.099');
    $('.percent').mask('##0,00%', {
      reverse: true
    });
    $('.clear-if-not-match').mask("00/00/0000", {
      clearIfNotMatch: true
    });
    $('.placeholder').mask("00/00/0000", {
      placeholder: "__/__/____"
    });
    $('.fallback').mask("00r00r0000", {
      translation: {
        'r': {
          pattern: /[\/]/,
          fallback: '/'
        },
        placeholder: "__/__/____"
      }
    });
    $('.selectonfocus').mask("00/00/0000", {
      selectOnFocus: true
    });
  });

  $("#datepicker").datepicker({
    dateFormat: 'dd/mm/yy',
    closeText: "Fechar",
    leftArrow: '<i class="fa fa-long-arrow-left"></i>',
    rightArrow: '<i class="fa fa-long-arrow-right"></i>',
    prevText: "&#x3C;Anterior",
    nextText: "Próximo&#x3E;",
    minDate: new Date(<?=getenv('YEAR_START');?>, <?=getenv('MONTH_START');?>-1, <?=getenv('DAY_START');?>),
    maxDate: "+0d",
    selectOtherMonths: true,
    currentText: "Hoje",
    monthNames: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
    monthNamesShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
    dayNames: ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado"],
    dayNamesShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
    dayNamesMin: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
    weekHeader: "Sm",
    firstDay: 7
  });
</script>

</body>

</html>