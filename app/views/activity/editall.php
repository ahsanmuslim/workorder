<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Activity</h1>

    <div class="text-left">
        <a href="<?= BASEURL; ?>/workorder/detail/<?= $data['activity'][0]['id_wo'] ?>" class="btn btn-warning btn-sm mb-3">
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
                    <h6 class="m-0 font-weight-bold text-primary">Update Activity : Project -  <?= $data['activity'][0]['nama_wo'] ?> </h6>
                </div>
                <div class="card-body">
                    <style>
                        form label:not(.form-check-label) {font-weight:bold;}
                    </style>
                    <div class="col-lg">
                    <form action="<?= BASEURL; ?>/activity/updateallactivity" method="post">
                        <input type="hidden" name="id_wo" class="form-control" value="<?= $data['activity'][0]['id_wo'] ?>">
                        <?php $jmldata = count($data['activity']); ?>
                        <input type="hidden" name="jmldata" class="form-control" value="<?= $jmldata ?>">
                        <div class="form-group">
                            <table class="table">
                                <tr>
                                    <th>#</th>
                                    <th>Plan date</th>
                                    <th>Actual date</th>
                                    <th>Activity</th>
                                    <th>Status</th>
                                </tr>
                                <?php 
                                for ($i=0 ; $i < $jmldata ; $i++) { ?>
                                <tr>
                                    <td width="5"><?= $i+1 ?></td>
                                    <td width="20">
                                        <input type="date" name="tanggal-<?= $i+1 ?>" class="form-control" value="<?= $data['activity'][$i]['tgl_activity'] ?>" required>
                                        <input type="hidden" name="id-<?= $i+1 ?>" class="form-control" value="<?= $data['activity'][$i]['id_activity'] ?>">
                                    </td>
                                    <td width="20">
                                        <input type="date" name="aktual-<?= $i+1 ?>" class="form-control" value="<?= $data['activity'][$i]['aktual'] ?>">
                                    </td>
                                    <td>
                                        <input type="text" name="activity-<?= $i+1 ?>" class="form-control" value="<?= $data['activity'][$i]['nama_activity'] ?>" required>
                                    </td>
                                    <td>
                                    <select name="status-<?= $i+1 ?>" class="form-control" id="status">
                                        <option value="not started" <?php if( $data['activity'][$i]['status'] == 'not started' ) { echo 'selected';} ?>>not started</option>
                                        <option value="in progress" <?php if( $data['activity'][$i]['status'] == 'in progress' ) { echo 'selected';} ?> >in progress</option>
                                        <option value="completed" <?php if( $data['activity'][$i]['status'] == 'completed' ) { echo 'selected';} ?> >completed</option>
                                    </select>
                                    </td>
                                </tr>
                                <?php } ?>
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