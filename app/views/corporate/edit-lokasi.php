<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Corporate Data</h1>

    <div class="text-left">
        <a href="<?= BASEURL; ?>/lokasi" class="btn btn-warning btn-sm mb-3">
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
                    <h6 class="m-0 font-weight-bold text-primary">Update Lokasi</h6>
                </div>
                <div class="card-body">
                    <style>
                        form label:not(.form-check-label) {font-weight:bold;}
                    </style>
                    <div class="col-lg">
                    <form action="<?= BASEURL; ?>/lokasi/updateLokasi" method="post">
                        <div class="form-group">
                            <input type="hidden" name="id_lokasi" id="id_lokasi" class="form-control" value="<?= $data['lokasi']['id_lokasi'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="lokasi">Nama Lokasi</label>
                            <input type="text" name="lokasi" id="lokasi" class="form-control" value="<?= $data['lokasi']['nama_lokasi'] ?>" required>
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