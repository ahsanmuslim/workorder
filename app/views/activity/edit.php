<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Activity</h1>

    <div class="text-left">
        <a href="<?= BASEURL; ?>/activity" class="btn btn-warning btn-sm mb-3">
            <span class="icon text-white-50">
                <i class="fas fa-angle-double-left"></i>
            </span>
            <span class="text">Kembali</span>
        </a>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-0 shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Update Activity : Project -  <?= $data['activity']['nama_wo'] ?> </h6>
                </div>
                <div class="card-body">
                    <style>
                        form label:not(.form-check-label) {font-weight:bold;}
                    </style>
                    <div class="col-lg">
                    <form action="<?= BASEURL; ?>/activity/updateactivity" method="post">
                    <input type="hidden" name="id_wo" class="form-control" value="<?= $data['activity']['id_wo'] ?>">
                    <input type="hidden" name="id_activity" class="form-control" value="<?= $data['activity']['id_activity'] ?>">
                        <div class="form-group">
                            <table class="table">
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th>Aktual</th>
                                    <th>Activity</th>
                                    <th>Status</th>
                                </tr>
                                <tr>
                                    <td width="5">1</td>
                                    <td width="20">
                                        <input type="date" name="tanggal" class="form-control" value="<?= $data['activity']['tgl_activity'] ?>" required>
                                    </td>
                                    <td width="20">
                                        <input type="date" name="aktual" class="form-control" value="<?= $data['activity']['aktual'] ?>" required>
                                    </td>
                                    <td>
                                        <input type="text" name="activity" class="form-control" value="<?= $data['activity']['nama_activity'] ?>" required>
                                    </td>
                                    <td>
                                    <select name="status" class="form-control" id="status" required>
                                        <option value="not started" <?php if( $data['activity']['status'] == 'not started' ) { echo 'selected';} ?>>not started</option>
                                        <option value="in progress" <?php if( $data['activity']['status'] == 'in progress' ) { echo 'selected';} ?> >in progress</option>
                                        <option value="completed" <?php if( $data['activity']['status'] == 'completed' ) { echo 'selected';} ?> >completed</option>
                                    </select>
                                    </td>
                                </tr>
                            </table>
                            <div class="form-group text-right">
                                <input type="submit" name="update" value="Update" class="btn btn-info">
                            </div>
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