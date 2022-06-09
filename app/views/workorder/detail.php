<style type="text/css">
    img.zoom {
        -webkit-transition: all .2s ease-in-out;
        -moz-transition: all .2s ease-in-out;
        -o-transition: all .2s ease-in-out;
        -ms-transition: all .2s ease-in-out;
    }

    .transisi {
        -webkit-transform: scale(1.4);
        -moz-transform: scale(1.4);
        -o-transform: scale(1.4);
        transform: scale(1.4);
    }
</style>

<?php
//script untuk cek user role
$id_role = $data['user']['role'];
$title = $data['title'];
$data['menu'] = $this->models('menu_model')->getMenubyTitle($title);
$controller = $data['menu']['url'];
// var_dump($data['lastprogress']);

//authentifikasi CRUD 
$update = $this->models('role_model')->countUpdate($id_role, $controller);

$askesupdate = 0;
if ($update > 0 && $data['detailWO']['status'] != 'Closed' && $data['lastprogress']['id_progress'] == 1 && $data['user']['role'] == 3) {
    $askesupdate = 1;
}

if ($update > 0 && $data['detailWO']['status'] != 'Closed' && $data['lastprogress']['id_progress'] <= 3 && ($data['user']['role'] == 6 || $data['user']['role'] == 1) ) {
    $askesupdate = 1;
}

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Work Order Detail</h1>

    <div class="row">
        <div class="col-sm-6 text-left">
            <a href="<?= BASEURL; ?>/workorder" class="btn btn-warning btn-sm mb-3">
                <span class="icon text-white-50">
                    <i class="fas fa-angle-double-left"></i>
                </span>
                <span class="text">Kembali</span>
            </a>
        </div>
        <?php 
        $aksi = 'Approve';
        $btn = 'primary';
        $notes = $data['detailWO']['department'];
        //Division Head
        if($data['user']['role'] == 5 && $data['detailWO']['approve_div'] == null && $data['detailWO']['approve_hr'] != null){
            $app = 1;
        //admin MTC
        } elseif ($data['user']['role'] == 6 && $data['detailWO']['verified'] == null && $data['detailWO']['approve_dept'] != null) {
            $app = 1;
            $aksi = 'Verify';
        //Dept Head & HR Dept Head
        } elseif ( ($data['user']['role']  == 3 || $data['user']['role']  == 7) && $data['detailWO']['approve_dept'] == null) {
            $app = 1;
            $btn = 'success';
            $notes = 'null';
        //PROSES CHECK OLEH hr DEPT heAD
        } elseif ( $data['user']['role']  == 7 && $data['detailWO']['approve_hr'] == null && $data['detailWO']['verified'] != null) {
            $app = 1;
            $aksi = 'Check';
            $notes = 'App HR Dept Head';
        } else {
            $app = 0;
        }
        
        if ($app == 1){ ?>
        <div class="col-sm-6 text-right mb-3">
            <a href="<?= BASEURL; ?>/workorder/approve/<?= $data['detailWO']['id_wo']; ?>/<?= $data['user']['role'] ?>/<?= $notes ?>" class="btn btn-<?= $btn ?> btn-icon-split text-right" id="tombol-approve">
                <span class="icon text-white-50">
                    <i class="fas fa-check-double"></i>
                </span>
                <span class="text"><?= $aksi ?> Work Order</span>
            </a>
        </div>
        <?php } ?>
    </div>


    <!-- //row untuk detail work order -->
    <div class="row">
        <div class="col-lg">
            <div class="card mb-4 shadow">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-8">
                            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-chevron-circle-right"></i> <?= $data['detailWO']['nama_wo'] ?></h6>
                        </div>
                        <?php if($askesupdate == 1) { ?>
                            <div class="col-sm-4 text-right">
                                <a href="<?= BASEURL; ?>/workorder/update/<?= $data['detailWO']['id_wo']; ?>"><i class="fas fa-fw fa-pen"></i></a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="card-body">
                    <style>
                        label:not(.form-check-label) {
                            font-weight: bold;
                        }
                    </style>
                    <div class="col-lg-12">
                        <?php Flasher::flash(); ?>
                    </div>
                    <div class="form-group row">
                        <label for="tanggalwo" class="col-sm-2 col-form-label">Tanggal</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="tanggalwo" id="tanggalwo" value="<?= date('d M Y', strtotime($data['detailWO']['tanggal'])) ?>" disabled>
                        </div>
                        <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="kategori" id="kategori" value="<?= $data['detailWO']['nama_kategori'] ?>" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="id_wo" class="col-sm-2 col-form-label">No Work Order</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="id_wo" id="id_wo" value="<?= $data['detailWO']['id_wo'] ?>" disabled>
                        </div>
                        <label for="prioritas" class="col-sm-2 col-form-label">Priority</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="prioritas" id="prioritas" value="<?php if ($data['detailWO']['prioritas'] == 1) {
                                echo 'Urgent';
                            } else {
                                echo 'Normal';
                            } ?>" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="dept" class="col-sm-2 col-form-label">Department</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="dept" id="dept" value="<?= $data['detailWO']['nama_dept'] ?>" disabled>
                        </div>
                        <label for="status" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="status" id="status" value="<?= $data['detailWO']['status'] ?>" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pic" class="col-sm-2 col-form-label">PIC</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="pic" id="pic" value="<?= $data['detailWO']['nama_user'] ?>" disabled>
                        </div>
                        <label for="lokasi" class="col-sm-2 col-form-label">Lokasi</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="lokasi" id="lokasi" value="<?= $data['detailWO']['nama_lokasi'] ?>" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="teknisi" class="col-sm-2 col-form-label">Teknisi</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="teknisi" id="teknisi" value="<?= $data['detailWO']['nama_teknisi'] ?>" disabled>
                        </div>
                        <label for="biaya" class="col-sm-2 col-form-label">Rencana biaya</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="biaya" id="biaya" value="Rp <?= number_format($data['detailWO']['plan_biaya']) ?>" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="deskripsi" name="deskripsi" disabled><?= $data['detailWO']['deskripsi'] ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- //row untuk drawing -->
    <div class="row">
        <div class="col-lg">
            <div class="card mb-4 shadow">
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col-sm-8">
                            <h6 class="m-0 font-weight-bold text-primary">Drawing / Sketch / Ilustrasi / Photo</h6>
                        </div>
                        <?php if($askesupdate == 1) { ?>
                            <div class="col-sm-4 text-right">
                                <a href="<?= BASEURL; ?>/workorder/update/<?= $data['detailWO']['id_wo']; ?>"><i class="fas fa-fw fa-pen"></i></a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-center"><img src="<?= BASEURL; ?>/img/drawing/<?= $data['detailWO']['drawing']; ?>" style="width:100%; height: 100%; max-height: 500px; max-width:500px;" class="rounded shadow mt-1 mb-1 text-center zoom" alt="<?= $data['detailWO']['drawing']; ?>"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- //row untuk detail rincian material -->
    <div class="row">
        <div class="col-lg">
            <div class="card mb-4 shadow">
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col-sm-8">
                            <h6 class="m-0 font-weight-bold text-primary">Rincian Pemakaian Material</h6>
                        </div>
                        <?php if($askesupdate == 1) { ?>
                            <div class="col-sm-4 text-right">
                                <a href="<?= BASEURL; ?>/workorder/update/<?= $data['detailWO']['id_wo']; ?>"><i class="fas fa-fw fa-pen"></i></a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-light">
                                <style>
                                    th.judul,
                                    td.judul {
                                        text-align: center;
                                    }

                                    th.total {
                                        text-align: right;
                                    }
                                </style>
                                <tr>
                                    <th class="judul">No.</th>
                                    <th>Nama Material</th>
                                    <th class="judul">Qty (plan)</th>
                                    <th class="judul">Qty (aktual)</th>
                                    <th>Satuan</th>
                                    <th>Harga satuan</th>
                                    <th>Total biaya</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                if (!empty($data['detailMaterial'])) {
                                    foreach ($data['detailMaterial'] as $material) : ?>
                                        <tr>
                                            <td class="judul"><?= $no++ ?></td>
                                            <td><?= $material['nama_material']; ?></td>
                                            <td class="judul"><?= $material['qty_plan']; ?></td>
                                            <td class="judul"><?= $material['qty_aktual']; ?></td>
                                            <td><?= $material['satuan']; ?></td>
                                            <td>Rp <?= number_format($material['harga_rm']); ?></td>
                                            <td>Rp <?= number_format($material['harga_rm'] * $material['qty_plan']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                            </tbody>
                            <thead>
                                <tr>
                                    <th colspan="6" class="total">Total Estimasi Biaya</th>
                                    <th colspan="2">Rp <?= number_format($material['plan_biaya']) ?></th>
                                </tr>
                            </thead>
                        <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- //row untuk detail pembelian material -->
    <?php if(!empty($data['detailBeli'])) { ?>
    <div class="row">
        <div class="col-lg">
            <div class="card mb-4 shadow">
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col-sm-8">
                            <h6 class="m-0 font-weight-bold text-primary">Rincian Pembelian Material</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-light">
                                <style>
                                    th.judul,
                                    td.judul {
                                        text-align: center;
                                    }
                                    th.total {
                                        text-align: right;
                                    }
                                </style>
                                <tr>
                                    <th class="judul">No.</th>
                                    <th>Tanggal</th>
                                    <th>Nama Material</th>
                                    <th>Supplier</th>
                                    <th class="judul">Qty</th>
                                    <th>Satuan</th>
                                    <th>Harga satuan</th>
                                    <th>Total Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($data['detailBeli'] as $beli) : ?>
                                    <tr>
                                        <td class="judul"><?= $no++ ?></td>
                                        <td><?= date('d M Y', strtotime($beli['tgl_pembelian'])) ?></td>
                                        <td><?= $beli['nama_material']; ?></td>
                                        <td><?= $beli['nama_supplier']; ?></td>
                                        <td class="judul"><?= $beli['jumlah']; ?></td>
                                        <td><?= $beli['satuan']; ?></td>
                                        <td>Rp <?= number_format($beli['harga']); ?></td>
                                        <td>Rp <?= number_format($beli['harga'] * $beli['jumlah']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <thead>
                                <tr>
                                    <th colspan="7" class="total">Total Pembelian</th>
                                    <th>Rp<?= $data['detailWO']['act_biaya'] ?></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php } ?>

    <!-- //row untuk detail activity & progress -->
    <div class="row">

        <div class="col-lg-6">
            <div class="card mb-4 shadow">
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col-sm-8">
                            <h6 class="m-0 font-weight-bold text-primary">Detail Progress Work Order</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-lg">
                        <ul class="list-group">
                            <?php foreach ($data['Progress'] as $prog) :
                                if ($prog['status'] == 'on time') {
                                    $badge = 'success';
                                } elseif ($prog['status'] == 'advance') {
                                    $badge = 'primary';
                                } else {
                                    $badge = 'danger';
                                }
                            ?>
                                <li class="list-group-item">
                                    <span><small><?= date('d M y', strtotime($prog['start'])) ?></small></span>
                                    <span><small> ~ </small></span>
                                    <span><small><?= date('d M y', strtotime($prog['finish'])) ?></small></span>
                                    <span class="ml-4"><?= $prog['progress'] ?></span>
                                    <span class="badge badge-pill badge-<?= $badge ?> float-right ml-1">
                                    <?php if (is_null($prog['status'])) {
                                        echo 'unfinished';
                                    } else {
                                        echo $prog['status'];
                                    } ?></span>
                                    <span class="badge badge-pill badge-secondary float-right ml-1 mr-4"><?= $prog['target'] ?> hari | <?= $prog['durasi'] ?> hari</span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card mb-4 shadow">
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col-sm-8">
                            <h6 class="m-0 font-weight-bold text-primary">Detail Activity Work Order</h6>
                        </div>
                        <?php if ($data['user']['role'] == 6 && $data['detailWO']['status'] != 'Closed' && $data['lastprogress']['id_progress'] >= 6) { ?>
                            <div class="col-sm-4 text-right">
                                <a href="<?= BASEURL; ?>/activity/generate/<?= $data['detailWO']['id_wo'] ?>"><i class="fas fa-fw fa-plus"></i></a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-lg">
                        <ul class="list-group">
                            <?php foreach ($data['Activity'] as $act) :
                                if ($act['status'] == 'completed') {
                                    $tipe = 'secondary';
                                } elseif ($act['status'] == 'in progress') {
                                    $tipe = 'success';
                                } else {
                                    $tipe = 'danger';
                                }
                            ?>
                                <li class="list-group-item">
                                    <?php if ($data['user']['role'] == 6 && $data['detailWO']['status'] != 'Closed') { ?>
                                        <a href="<?= BASEURL; ?>/activity/editall/<?= $data['detailWO']['id_wo'] ?>"><i class="fas fa-fw fa-pen text-warning mr-2"></i></a>
                                    <?php } ?>
                                    <span><?= date('d M Y', strtotime($act['tgl_activity'])) ?></span>
                                    <span class="ml-2"><?= $act['nama_activity'] ?></span>
                                    <span class="badge badge-<?= $tipe ?> float-right ml-1"><?= $act['status'] ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>





</div>
<!-- /.container-fluid -->

</div>