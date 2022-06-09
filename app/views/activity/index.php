<?php
//script untuk cek user role
$id_role = $data['user']['role'];
$title = $data['title'];
$data['menu'] = $this->models('menu_model')->getMenubyTitle($title);
$controller = $data['menu']['url'];
// var_dump($data['menu']);

//authentifikasi CRUD 
$create = $this->models('role_model')->countCreate($id_role, $controller);
$update = $this->models('role_model')->countUpdate($id_role, $controller);
$delete = $this->models('role_model')->countDelete($id_role, $controller);

// var_dump($data['activity'])
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Activity</h1>

    <div class="text-right">
        <a href="<?= BASEURL; ?>/activity" class="btn btn-outline-secondary btn-sm mb-3"><i class="fas fa-sync-alt"></i></a>
        <?php if ($create > 0) { ?>
            <a href="<?= BASEURL; ?>/activity/generate" class="btn btn-primary btn-sm mb-3">
                <span class="icon text-white-50">
                    <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text">Tambah activity</span>
            </a> <?php } ?>
    </div>
    <div class="card mb-2 shadow">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Detail Activity Work Order</h6>
        </div>
        <div class="card-body">
            <div class="col-lg-12">
                <?php Flasher::flash(); ?>
            </div>
            <div class="table-responsive">
                <table class="table table-hover" id="tblactivity">
                    <thead class="thead-light">
                        <style>
                            th.judul,
                            td.judul {
                                text-align: center;
                            }
                            /* //css untuk horizantal scroll */
                            th, td { white-space: nowrap; }
                            div.dataTables_wrapper {
                                width: 100%;
                                margin: 0 auto;
                            }
                        </style>
                        <tr>
                            <th class="judul">No.</th>
                            <th>Work Order</th>
                            <th>Dept</th>
                            <th>Teknisi</th>
                            <th>Plan date</th>
                            <th>Actual date</th>
                            <th>Detail Activity</th>
                            <th>Status</th>
                            <th class="judul"><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($data['activity'] as $act) : ?>
                            <tr>
                                <td class="judul"><?= $no++ ?></td>
                                <td><?= $act['nama_wo']; ?></td>
                                <td><?= $act['kode']; ?></td>
                                <td><?= $act['nama_teknisi']; ?></td>
                                <td><?= date('d M y', strtotime($act['tgl_activity'])) ?></td>
                                <?php
                                if(is_null($act['aktual'])){
                                    echo '<td>-</td>';
                                } else { ?>
                                    <td><?= date('d M y', strtotime($act['aktual'])) ?></td>
                                <?php } ?>
                                <td><?= $act['nama_activity']; ?></td>
                                <td><?= $act['status']; ?></td>
                                <td class="judul">
                                    <?php if ($update > 0 && $act['wo_status'] != 'Closed') { ?>
                                        <a href="<?= BASEURL; ?>/activity/edit/<?= $act['id_activity']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-fw fa-pen"></i></a> <?php } ?>
                                    <?php if ($delete > 0 && $act['wo_status'] != 'Closed') { ?>
                                        <a href="<?= BASEURL; ?>/activity/hapus/<?= $act['id_activity']; ?>" class="btn btn-danger btn-sm tombol-hapus"><i class="fas fa-fw fa-trash-alt"></i></i></a> <?php } ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>