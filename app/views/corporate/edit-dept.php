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
                    <h6 class="m-0 font-weight-bold text-primary">Update Department</h6>
                </div>
                <div class="card-body">
                    <style>
                        form label:not(.form-check-label) {font-weight:bold;}
                    </style>
                    <div class="col-lg">
                    <form action="<?= BASEURL; ?>/department/updateDept" method="post">
                        <div class="form-group">
                            <input type="hidden" name="id_dept" id="id_dept" class="form-control" value="<?= $data['dept']['id_dept'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="nama_dept">Nama Department</label>
                            <input type="text" name="nama_dept" id="nama_dept" class="form-control" value="<?= $data['dept']['nama_dept'] ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="dept_head">Dept Head</label>
                            <select name="dept_head" class="form-control" id="dept_head" required>
                                <?php foreach ( $data['depthead'] as $depthead ): ?>
                                    <option value="<?= $depthead['nama_user']; ?>" <?php if( $data['dept']['dept_head'] == $depthead['nama_user'] ) { echo 'selected';} ?> ><?= $depthead['nama_user']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="divisi">Divisi</label>
                            <select name="divisi" class="form-control" id="divisi" required>
                                <?php foreach ( $data['divisi'] as $div ): ?>
                                    <option value="<?= $div['id_divisi']; ?>" <?php if( $data['dept']['id_divisi'] == $div['id_divisi'] ) { echo 'selected';} ?> ><?= $div['nama_divisi']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="telegram">ID Telegram</label>
                            <input type="text" name="telegram" id="telegram" class="form-control" value="<?= $data['dept']['telegram'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="kode">Kode Dept</label>
                            <input type="text" name="kode" id="kode" class="form-control" value="<?= $data['dept']['kode'] ?>" required>
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