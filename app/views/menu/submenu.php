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
    <h1 class="h3 mb-2 text-gray-800">Menu Management</h1>

    <div class="text-right">
        <a href="<?= BASEURL; ?>/menu/submenu" class="btn btn-outline-secondary btn-sm mb-3"><i class="fas fa-sync-alt"></i></a>
        <?php if ($create > 0) { ?>
            <a href="<?= BASEURL; ?>/menu/add" class="btn btn-primary btn-sm mb-3">
                <span class="icon text-white-50">
                    <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text">Tambah Submenu</span>
            </a> <?php } ?>
    </div>

    <div class="card text-center shadow">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASEURL; ?>/menu"><b>Main Menu</b></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="<?= BASEURL; ?>/menu/submenu"><b>Submenu</b></a>
                </li>
            </ul>
        </div>
        <div class="card-body text-left">
            <div class="col-lg-12">
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
                            <th>Title</th>
                            <th>Main menu</th>
                            <th>URL</th>
                            <th>Icon</th>
                            <th class="judul">Sidemenu</th>
                            <th class="judul">Status</th>
                            <th class="judul"><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($data['datamenu'] as $menu) : ?>
                            <tr>
                                <td class="judul"><?= $no++ ?></td>
                                <td><?= $menu['title']; ?></td>
                                <td><?= $menu['nama_menu']; ?></td>
                                <td><?= $menu['url']; ?></td>
                                <td><?= $menu['icon']; ?></td>
                                <?php if ($menu['is_sidemenu'] == 1) { ?>
                                    <td class="judul">Ya</td>
                                <?php } else { ?>
                                    <td class="judul">Tidak</td>
                                <?php } ?>
                                <?php if ($menu['is_active'] == 1) { ?>
                                    <td class="judul">Aktif</td>
                                <?php } else { ?>
                                    <td class="judul">Tidak Aktif</td>
                                <?php } ?>
                                <td class="judul">
                                    <?php if ($update > 0) { ?>
                                        <a href="<?= BASEURL; ?>/menu/edit/<?= $menu['id_submenu']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-fw fa-pen"></i></a> <?php } ?>
                                    <?php if ($delete > 0) { ?>
                                        <a href="<?= BASEURL; ?>/menu/hapusSubmenu/<?= $menu['url']; ?>" class="btn btn-danger btn-sm tombol-hapus"><i class="fas fa-fw fa-trash-alt"></i></i></a> <?php } ?>
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