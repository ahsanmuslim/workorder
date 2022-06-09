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

?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Problem</h1>

    <div class="text-right">
        <a href="<?= BASEURL; ?>/problem" class="btn btn-outline-secondary btn-sm mb-3"><i class="fas fa-sync-alt"></i></a>
        <?php if ($create > 0) { ?>
            <a href="<?= BASEURL; ?>/problem/tambah" class="btn btn-primary btn-sm mb-3">
                <span class="icon text-white-50">
                    <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text">Tambah problem</span>
            </a> <?php } ?>
    </div>
    <div class="card mb-2 shadow">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Detail problem Work Order</h6>
        </div>
        <div class="card-body">
            <div class="col-lg-12">
                <?php Flasher::flash(); ?>
            </div>
            <div class="table-responsive">
                <table class="table table-hover" id="tblproblem">
                    <thead class="thead-light">
                        <style>
                            th.judul,
                            td.judul {
                                text-align: center;
                            }
                        </style>
                        <tr>
                            <th class="judul">No.</th>
                            <th>Work Order</th>
                            <th>Problem</th>
                            <th>Tindak lanjut</th>
                            <th>PIC</th>
                            <th>Status</th>
                            <th class="judul"><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($data['problem'] as $prob) : ?>
                            <tr>
                                <td class="judul"><?= $no++ ?></td>
                                <td><?= $prob['id_wo']; ?></td>
                                <td><?= $prob['problem']; ?></td>
                                <td><?= $prob['tindak_lanjut'] ?></td>
                                <td><?= $prob['pic']; ?></td>
                                <td><?= $prob['status']; ?></td>
                                <td class="judul">
                                    <?php if ($update > 0 && $prob['status'] != 'Closed') { ?>
                                        <a href="<?= BASEURL; ?>/problem/edit/<?= $prob['id_problem']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-fw fa-pen"></i></a> <?php } ?>
                                    <?php if ($delete > 0 && $prob['status'] != 'Closed') { ?>
                                        <a href="<?= BASEURL; ?>/problem/hapus/<?= $prob['id_problem']; ?>" class="btn btn-danger btn-sm tombol-hapus"><i class="fas fa-fw fa-trash-alt"></i></i></a> <?php } ?>
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