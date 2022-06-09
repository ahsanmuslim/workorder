<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Corporate Data</h1>

    <div class="text-left">
        <a href="<?= BASEURL; ?>/supplier" class="btn btn-warning btn-sm mb-3">
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
                    <h6 class="m-0 font-weight-bold text-primary">Update Supplier</h6>
                </div>
                <div class="card-body">
                    <style>
                        form label:not(.form-check-label) {font-weight:bold;}
                    </style>
                    <div class="col-lg">
                    <form action="<?= BASEURL; ?>/supplier/updateSupplier" method="post">
                        <div class="form-group">
                            <input type="hidden" name="id_supplier" id="id_supplier" class="form-control" value="<?= $data['supplier']['id_supplier'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="supplier">Nama Supplier</label>
                            <input type="text" name="supplier" id="supplier" class="form-control" value="<?= $data['supplier']['nama_supplier'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" name="alamat" id="alamat" rows="3" required><?= $data['supplier']['alamat'] ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="notelp">No Telepon</label>
                            <input type="text" name="notelp" id="notelp" class="form-control" value="<?= $data['supplier']['no_telp'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="pic">PIC</label>
                            <input type="text" name="pic" id="pic" class="form-control" value="<?= $data['supplier']['pic'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="ket">Keterangan</label>
                            <input type="text" name="ket" id="ket" class="form-control" value="<?= $data['supplier']['keterangan'] ?>" required>
                        </div>
                        <br>
                        <div class="form-group text-right">
                            <input type="submit" name="update" value="Update" class="btn btn-info">
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