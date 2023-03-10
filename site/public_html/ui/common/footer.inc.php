<?php if (isset($_SESSION[constant("cAppKey")]["credential"])) { ?>
  </div>
  <footer class="main-footer">
    <strong>Copyright &copy; 2022-<?php print(date("Y")); ?> <a href="">MJ SYSTEM SOLUTIONS</a>.</strong> Todos os direitos reservados.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark" style="display: none;">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>

  <div class="control-sidebar-bg"></div>

  </div>
<?php } ?>

<div class="spinner-border" role="status">
  <span class="sr-only">Loading...</span>
</div>

<style>
  .spinner-border {
    position: fixed;
    display: none;
    top: 50%;
    left: 50%;
    text-align: center;
    background-color: rgba(255, 255, 255, 0.8);
    z-index: 2;
  }
</style>

<!-- jQuery 3 -->
<script src="<?php printf("%s%s", constant("cFurniture"), "AdminLTE/bower_components/jquery/dist/jquery.min.js") ?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php printf("%s%s", constant("cFurniture"), "AdminLTE/bower_components/jquery-ui/jquery-ui.min.js") ?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- sweetalert2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>

<script>
  $(function() {
    //Initialize Select2 Elements
    $('.select2').select2()
  })
</script>

<!-- Select2 -->
<script src="<?php printf("%s%s", constant("cFurniture"), "AdminLTE/bower_components/select2/dist/js/select2.full.min.js") ?>"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php printf("%s%s", constant("cFurniture"), "AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js") ?>"></script>
<!-- Morris.js charts -->
<script src="<?php printf("%s%s", constant("cFurniture"), "AdminLTE/bower_components/raphael/raphael.min.js") ?>"></script>
<script src="<?php printf("%s%s", constant("cFurniture"), "AdminLTE/bower_components/morris.js/morris.min.js") ?>"></script>
<!-- Sparkline -->
<script src="<?php printf("%s%s", constant("cFurniture"), "AdminLTE/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js") ?>"></script>
<!-- jvectormap -->
<script src="<?php printf("%s%s", constant("cFurniture"), "AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js") ?>"></script>
<script src="<?php printf("%s%s", constant("cFurniture"), "AdminLTE/plugins/jvectormap/jquery-jvectormap-world-mill-en.js") ?>"></script>
<!-- jQuery Knob Chart -->
<script src="<?php printf("%s%s", constant("cFurniture"), "AdminLTE/bower_components/jquery-knob/dist/jquery.knob.min.js") ?>"></script>
<!-- daterangepicker -->
<script src="<?php printf("%s%s", constant("cFurniture"), "AdminLTE/bower_components/moment/min/moment.min.js") ?>"></script>
<script src="<?php printf("%s%s", constant("cFurniture"), "AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.js") ?>"></script>
<!-- datepicker -->
<script src="<?php printf("%s%s", constant("cFurniture"), "AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js") ?>"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php printf("%s%s", constant("cFurniture"), "AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js") ?>"></script>
<!-- Slimscroll -->
<script src="<?php printf("%s%s", constant("cFurniture"), "AdminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js") ?>"></script>
<!-- FastClick -->
<script src="<?php printf("%s%s", constant("cFurniture"), "AdminLTE/bower_components/fastclick/lib/fastclick.js") ?>"></script>
<!-- AdminLTE App -->
<script src="<?php printf("%s%s", constant("cFurniture"), "AdminLTE/dist/js/adminlte.min.js") ?>"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php printf("%s%s", constant("cFurniture"), "AdminLTE/dist/js/pages/dashboard.js") ?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php printf("%s%s", constant("cFurniture"), "AdminLTE/dist/js/demo.js") ?>"></script>

<script type='text/javascript' src="<?php printf("%s%s", constant("cFurniture"), "js/app.js") ?>"></script>

<!-- <script type='text/javascript' src="<?php printf("%s%s", constant("cFurniture"), "js/jquery.js") ?>"></script>
<script type='text/javascript' src='<?php printf("%s%s", constant("cFurniture"), "js/jquery-ui.js") ?>'></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
<script type='text/javascript' src='<?php printf("%s%s", constant("cFurniture"), "js/jquery.inputmask.bundle.js") ?>'></script>
<script type='text/javascript' src='<?php printf("%s%s", constant("cFurniture"), "js/jquery-autocomplete.js") ?>'></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

<script type="text/javascript">
  // $('.editor').jqte();
  $('.datepicker').datepicker({
    dateFormat: 'yy-mm-d',
    closeText: "Fechar",
    prevText: "&#x3C;Anterior",
    nextText: "Pr??ximo&#x3E;",
    currentText: "Hoje",
    monthNames: ["Janeiro", "Fevereiro", "Mar??o", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
    monthNamesShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
    dayNames: ["Domingo", "Segunda-feira", "Ter??a-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "S??bado"],
    dayNamesShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "S??b"],
    dayNamesMin: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "S??b"],
    weekHeader: "Sm",
    firstDay: 1
  });
</script>