<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Problem</h1>

    <div class="text-left">
        <a href="<?= BASEURL; ?>/problem" class="btn btn-warning btn-sm mb-3">
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
                    <h6 class="m-0 font-weight-bold text-primary">Tambah problem</h6>
                </div>
                <div class="card-body">
                    <style>
                        form label:not(.form-check-label) {font-weight:bold;}
                    </style>
                    <div class="col-lg">
                    <form action="<?= BASEURL; ?>/problem/tambahproblem" method="post">
                        <div class="form-group">
                            <label for="id_wo">Work Order</label>
                            <select name="id_wo" class="form-control" id="id_wo" required>
                            <?php foreach ( $data['workorder'] as $wo ): ?>
                                <option value="<?= $wo['id_wo']; ?>"><?= $wo['id_wo'].' ';  ?><?= $wo['nama_wo'];  ?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="problem">Problem</label>
                            <input type="text" name="problem" id="problem" class="form-control" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="tindak_lanjut">Tindak lanjut</label>
                            <input type="text" name="tindak_lanjut" id="tindak_lanjut" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="pic">PIC</label>
                            <select name="pic" class="form-control" id="pic" required>
                            <?php foreach ( $data['datauser'] as $user ): ?>
                                <option value="<?= $user['nama_user']; ?>"><?= $user['nama_user'] ?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control" id="status" required>
                                <option value="Open">Open</option>
                                <option value="Closed">Closed</option>
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