<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Teknisi</h1>

    <div class="text-left">
        <a href="<?= BASEURL; ?>/teknisi" class="btn btn-warning btn-sm mb-3">
            <span class="icon text-white-50">
                <i class="fas fa-angle-double-left"></i>
            </span>
            <span class="text">Kembali</span>
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-0 shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Teknisi</h6>
                </div>
                <div class="card-body">
                    <style>
                        form label:not(.form-check-label) {font-weight:bold;}
                    </style>
                    <div class="col-lg">
                    <form action="<?= BASEURL; ?>/teknisi/tambahteknisi" method="post">
                        <div class="form-group">
                            <label for="teknisi">Nama teknisi</label>
                            <input type="text" name="teknisi" id="teknisi" class="form-control" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="keahlian">Keahlian</label>
                            <input type="text" name="keahlian" id="keahlian" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="tahun">Tahun Masuk</label>
                            <input type="number" name="tahun" id="tahun" class="form-control" required>
                        </div>
                        <br>
                        <div class="form-group text-right">
                            <input type="submit" name="simpan" value="Simpan" class="btn btn-success">
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>