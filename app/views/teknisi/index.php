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
    <h1 class="h3 mb-2 text-gray-800">Teknisi</h1>

    <div class="text-right">
        <a href="<?= BASEURL; ?>/teknisi" class="btn btn-outline-secondary btn-sm mb-3"><i class="fas fa-sync-alt"></i></a>
        <?php if ($create > 0) { ?>
            <a href="<?= BASEURL; ?>/teknisi/tambah" class="btn btn-primary btn-sm mb-3">
                <span class="icon text-white-50">
                    <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text">Tambah teknisi</span>
            </a> <?php } ?>
    </div>
    <div class="card mb-2 shadow">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data Teknisi</h6>
        </div>
        <div class="card-body">
            <div class="col-lg-8">
                <?php Flasher::flash(); ?>
            </div>
            <div class="table-responsive">
                <table class="table table-hover"  id="tblteknisi">
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
                            <th>Nama teknisi</th>
                            <th>Keahlian</th>
                            <th class="judul">Tahun Masuk</th>
                            <th class="judul">Active Project</th>
                            <th class="judul">Finished Project</th>
                            <th class="judul">Rating</th>
                            <th class="judul"><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($data['teknisi'] as $tek) : ?>
                            <tr>
                                <td class="judul"><?= $no++ ?></td>
                                <td><?= $tek['nama_teknisi']; ?></td>
                                <td><?= $tek['keahlian']; ?></td>
                                <td class="judul"><?= $tek['tahun_masuk']; ?></td>
                                <td class="judul"><?= $tek['active']; ?></td>
                                <td class="judul"><?= $tek['finish']; ?></td>
                                <td>
                                    <?php for ($i = 1; $i <= $tek['rating']; $i++) { ?>
                                        <i class="fas fa-fw fa-star text-warning"></i>
                                    <?php } ?>
                                    <font color="white"><?= $tek['rating']; ?></font>
                                </td>
                                <td class="judul">
                                    <a href="<?= BASEURL; ?>/teknisi/detail/<?= $tek['id_teknisi']; ?>" class="btn btn-info btn-sm"><i class="fas fa-fw fa-search"></i></a>
                                    <?php if ($update > 0) { ?>
                                        <a href="<?= BASEURL; ?>/teknisi/edit/<?= $tek['id_teknisi']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-fw fa-pen"></i></a> <?php } ?>
                                    <?php if ($delete > 0) { ?>
                                        <a href="<?= BASEURL; ?>/teknisi/hapus/<?= $tek['id_teknisi']; ?>" class="btn btn-danger btn-sm tombol-hapus"><i class="fas fa-fw fa-trash-alt"></i></a> <?php } ?>
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