<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">General Data</h1>

    <div class="text-left">
        <a href="<?= BASEURL; ?>/progress" class="btn btn-warning btn-sm mb-3">
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
                    <h6 class="m-0 font-weight-bold text-primary">Update progress</h6>
                </div>
                <div class="card-body">
                    <style>
                        form label:not(.form-check-label) {
                            font-weight: bold;
                        }
                    </style>
                    <div class="col-lg">
                        <form action="<?= BASEURL; ?>/progress/updateprogress" method="post">
                            <div class="form-group">
                                <label for="progress">Progress</label>
                                <input type="hidden" name="id_progress" id="id_progress" class="form-control" value="<?= $data['progress']['id_progress'] ?>">
                                <input type="text" name="progress" id="progress" class="form-control" value="<?= $data['progress']['progress'] ?>" required readonly>
                            </div>
                            <div class="form-group">
                                <label for="target">Target (hari)</label>
                                <input type="number" name="target" id="target" class="form-control" value="<?= $data['progress']['target'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="pic">PIC</label>
                                <input type="text" name="pic" id="pic" class="form-control" value="<?= $data['progress']['pic'] ?>" required>
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