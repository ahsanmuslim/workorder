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
        <a href="<?= BASEURL; ?>/menu" class="btn btn-outline-secondary btn-sm mb-3"><i class="fas fa-sync-alt"></i></a>
        <?php if ($create > 0) { ?>
            <a href="" class="btn btn-primary btn-sm mb-3 tombolTambahMenu" data-toggle="modal" data-target="#modalMenu">
                <span class="icon text-white-50">
                    <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text">Tambah Menu</span>
            </a> <?php } ?>
    </div>

    <div class="card text-center shadow">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="<?= BASEURL; ?>/menu"><b>Main Menu</b></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASEURL; ?>/menu/submenu"><b>Submenu</b></a>
                </li>
            </ul>
        </div>
        <div class="card-body text-left">
            <div class="col-lg-7">
                <?php Flasher::flash(); ?>
            </div>
            <div class="col-lg-7">
                <ul class="list-group mt-2">
                    <?php foreach ($data['datamenu'] as $menu) : ?>
                        <li class="list-group-item">
                            <?= $menu['nama_menu']; ?>
                            <?php if ($delete > 0) { ?>
                                <a href="<?= BASEURL; ?>/menu/hapusMenu/<?= $menu['id_menu']; ?>" class="badge badge-danger float-right ml-1 tombol-hapus">Hapus</a> <?php } ?>
                            <?php if ($update > 0) { ?>
                                <a href="" class="badge badge-warning float-right ml-1 modalEditMenu" data-toggle="modal" data-target="#modalMenu" data-id_menu="<?= $menu['id_menu']; ?>">Ubah</a> <?php } ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>


<!-- Modal -->
<div class="modal fade" id="modalMenu" tabindex="-1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="judulModal">Tambah Menu</h3>
            </div>
            <div class="modal-body">
                <form action="<?= BASEURL; ?>/menu/tambahMenu" method="post">
                    <div class="form-group">
                        <input type="hidden" name="id_menu" value="" class="form-control" id="id_menu">
                    </div>
                    <div class="form-group">
                        <label for="menu">Nama menu</label>
                        <input type="text" name="menu" class="form-control" id="menu" required autofocus>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Tambah Data</button>
                </form>
            </div>
        </div>
    </div>
</div>