<?php
//script untuk cek user role
$id_role = $data['user']['role'];
$url = $this->parseURL();
$controller = $url[0];

// echo $controller;

//authentifikasi CRUD 
$create = $this->models('role_model')->countCreate($id_role, $controller);
$update = $this->models('role_model')->countUpdate($id_role, $controller);
$delete = $this->models('role_model')->countDelete($id_role, $controller);

?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Corporate Data</h1>

    <div class="text-right">
        <a href="<?= BASEURL; ?>/department" class="btn btn-outline-secondary btn-sm mb-3"><i class="fas fa-sync-alt"></i></a>
        <?php if ($create > 0) { ?>
            <a href="<?= BASEURL; ?>/department/add_dept" class="btn btn-primary btn-sm mb-3">
                <span class="icon text-white-50">
                    <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text">Tambah Dept</span>
            </a>
        <?php } ?>
    </div>

    <div class="card text-center shadow">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <?php if ($this->models('role_model')->countAccess($id_role, 'divisi') != 0) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASEURL; ?>/divisi"><b>Divisi</b></a>
                </li>  
                <?php }
                if ($this->models('role_model')->countAccess($id_role, 'department') != 0) { ?>
                <li class="nav-item">
                    <a class="nav-link active" href="<?= BASEURL; ?>/department"><b>Department</b></a>
                </li>
                <?php }
                if ($this->models('role_model')->countAccess($id_role, 'lokasi') != 0) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASEURL; ?>/lokasi"><b>Lokasi</b></a>
                </li>
                <?php }
                if ($this->models('role_model')->countAccess($id_role, 'supplier') != 0) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASEURL; ?>/supplier"><b>Supplier</b></a>
                </li>
                <?php } ?>
            </ul>
        </div>
        <div class="card-body text-left">
            <div class="col-lg-8">
                <?php Flasher::flash(); ?>
            </div>
            <div class="table-responsive mt-2">
                <table class="table table-hover">
                    <thead class="thead-light">
                        <style>
                            th.judul,
                            td.judul {
                                text-align: center;
                            }
                        </style>
                        <tr>
                            <th class="judul">No.</th>
                            <th>Nama Department</th>
                            <th>Kode</th>
                            <th>Dept Head</th>
                            <th>Divisi</th>
                            <th>Telegram</th>
                            <th class="judul"><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($data['dept'] as $dept) : ?>
                            <tr>
                                <td class="judul"><?= $no++ ?></td>
                                <td><?= $dept['nama_dept']; ?></td>
                                <td><?= $dept['kode']; ?></td>
                                <td><?= $dept['dept_head']; ?></td>
                                <td><?= $dept['nama_divisi']; ?></td>
                                <td><?= $dept['telegram']; ?></td>
                                <td class="judul">
                                    <?php if ($update > 0) { ?>
                                        <a href="<?= BASEURL; ?>/department/edit_dept/<?= $dept['id_dept']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-fw fa-pen"></i></a> <?php } ?>
                                    <?php if ($delete > 0) { ?>
                                        <a href="<?= BASEURL; ?>/department/hapusDept/<?= $dept['id_dept']; ?>" class="btn btn-danger btn-sm tombol-hapus"><i class="fas fa-fw fa-trash-alt"></i></i></a> <?php } ?>
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