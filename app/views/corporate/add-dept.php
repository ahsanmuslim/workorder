<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Corporate Data</h1>

    <div class="text-left">
        <a href="<?= BASEURL; ?>/department" class="btn btn-warning btn-sm mb-3">
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
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Department</h6>
                </div>
                <div class="card-body">
                    <style>
                        form label:not(.form-check-label) {font-weight:bold;}
                    </style>
                    <div class="col-lg">
                    <form action="<?= BASEURL; ?>/department/tambahDept" method="post">
                        <div class="form-group">
                            <label for="department">Nama Department</label>
                            <input type="text" name="department" id="department" class="form-control" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="depthead">Dept Head</label>
                            <select name="depthead" class="form-control" id="depthead">
                                <option value=""></option>
                            <?php foreach ( $data['depthead'] as $depthead ): ?>
                                <option value="<?= $depthead['nama_user']; ?>"><?= $depthead['nama_user']; ?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="divisi">Divisi</label>
                            <select name="divisi" class="form-control" id="divisi" required>
                            <?php foreach ( $data['divisi'] as $divisi ): ?>
                                <option value="<?= $divisi['id_divisi']; ?>"><?= $divisi['nama_divisi']; ?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kode">Kode Dept</label>
                            <input type="text" name="kode" id="kode" class="form-control" required>
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