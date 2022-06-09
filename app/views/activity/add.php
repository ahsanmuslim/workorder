<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Activity</h1>

    <div class="text-left">
        <a href="<?= BASEURL; ?>/activity/generate" class="btn btn-warning btn-sm mb-3">
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
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Activity : Project - <?= $data['wo']['0']['nama_wo'] ?></h6>
                </div>
                <div class="card-body">
                    <style>
                        form label:not(.form-check-label) {font-weight:bold;}
                    </style>
                    <div class="col-lg">
                    <form action="<?= BASEURL; ?>/activity/tambahactivity" method="post">
                        <div class="form-group">
                            <input type="hidden" name="id_wo" value="<?= @$_POST['workorder'] ?>">
                            <input type="hidden" name="totaldata" value="<?=@$_POST['jmldata']?>">
                            <table class="table">
                                <tr>
                                    <th>#</th>
                                    <th>Plan date</th>
                                    <th>Activity</th>
                                    <th>Status</th>
                                </tr>
                                <?php
                                for ($i=1 ; $i<=@$_POST['jmldata']; $i++){ ?>
                                    <tr>
                                        <td width="5"><?=$i?></td>
                                        <td width="20">
                                            <input type="date" name="tanggal-<?=$i?>" class="form-control" required>
                                        </td>
                                        <!-- <td width="20">
                                            <input type="date" name="aktual-<?=$i?>" class="form-control">
                                        </td> -->
                                        <td>
                                            <input type="text" name="activity-<?=$i?>" class="form-control" required>
                                        </td>
                                        <td>
                                        <select name="status-<?=$i?>" class="form-control" id="status">
                                            <option value=""></option>
                                            <option value="not started">not started</option>
                                            <option value="in progress">in progress</option>
                                            <option value="completed">completed</option>
                                        </select>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>
                            <div class="form-group text-right">
                                <input type="submit" name="tambah" value="Tambah" class="btn btn-success">
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