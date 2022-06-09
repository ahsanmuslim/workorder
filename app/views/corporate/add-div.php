<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Corporate Data</h1>

    <div class="text-left">
        <a href="<?= BASEURL; ?>/divisi" class="btn btn-warning btn-sm mb-3">
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
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Divisi</h6>
                </div>
                <div class="card-body">
                    <style>
                        form label:not(.form-check-label) {font-weight:bold;}
                    </style>
                    <div class="col-lg">
                    <form action="<?= BASEURL; ?>/divisi/tambahDivisi" method="post">
                        <div class="form-group">
                            <label for="divisi">Nama Divisi</label>
                            <input type="text" name="divisi" id="divisi" class="form-control" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="divhead">Division Head</label>
                            <select name="divhead" class="form-control" id="divhead" required>
                            <?php foreach ( $data['divhead'] as $divhead ): ?>
                                <option value="<?= $divhead['nama_user']; ?>"><?= $divhead['nama_user']; ?></option>
                            <?php endforeach; ?>
                            </select>
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