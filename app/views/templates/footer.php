      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Work Order Monitoring <?= date('Y'); ?></span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Yakin akan keluar ?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Pilih "Logout" jika Anda yakin akan keluar dari sesi ini.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="<?= BASEURL; ?>/auth/logout">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?= BASEURL; ?>/js/jquery-3.5.1.min.js"></script>
  <script src="<?= BASEURL; ?>/js/popper.min.js"></script>
  <script src="<?= BASEURL; ?>/js/bootstrap.min.js"></script>


  <!-- Custom scripts for all pages-->
  <script src="<?= BASEURL; ?>/js/sb-admin-2.min.js"></script>

  <script src="<?= BASEURL; ?>/js/Chart.min.js"></script>

  <script src="<?= BASEURL; ?>/js/select2.min.js"></script>

  <script src="<?= BASEURL; ?>/js/myscript.js"></script>

  <script src="<?= BASEURL; ?>/js/sweetalert2.all.min.js"></script>

  <!-- <script src="<?= BASEURL; ?>/js/demo/chart-area-demo.js"></script>
  <script src="<?= BASEURL; ?>/js/demo/chart-pie-demo.js"></script> -->

  <script type="text/javascript" src="<?= BASEURL; ?>/libs/DataTables/datatables.min.js"></script>
  <script type="text/javascript" src="<?= BASEURL; ?>/libs/DataTables/Buttons-1.6.1/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" src="<?= BASEURL; ?>/libs/DataTables/Buttons-1.6.1/js/buttons.print.min.js"></script>


</body>
