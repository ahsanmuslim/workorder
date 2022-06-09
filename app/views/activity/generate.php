<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Generate Activity</h1>

    <div class="text-left">
        <a href="<?= BASEURL; ?>/activity" class="btn btn-warning btn-sm mb-3">
            <span class="icon text-white-50">
                <i class="fas fa-angle-double-left"></i>
            </span>
            <span class="text">Kembali</span>
        </a>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card mb-0 shadow">
                <div class="card-body">
                    <style>
                        form label:not(.form-check-label) {font-weight:bold;}
                    </style>
                    <div class="col-lg">
                    <form action="<?= BASEURL; ?>/activity/tambah" method="post">
                        <div class="form-group">
                            <label for="workorder">Pilih Work Order</label>
                            <select name="workorder" class="form-control" id="workorder" required>
                                <?php foreach ( $data['wo'] as $wl ): ?>
                                    <option value="<?= $wl['id_wo']; ?>"><?= $wl['id_wo'].' ';  ?><?= $wl['nama_wo'];  ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jmldata">Jumlah data activity yang akan di tambahkan</label>
                            <input type="number" name="jmldata" id="jmldata" class="form-control" required>
                        </div>
                        <div class="form-group text-right">
                            <input type="submit" name="generate" value="Generate" class="btn btn-success">
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