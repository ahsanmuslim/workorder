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
    <h1 class="h3 mb-2 text-gray-800">Role Management</h1>

    <div class="text-right">
        <a href="<?= BASEURL; ?>/role" class="btn btn-outline-secondary btn-sm mb-3"><i class="fas fa-sync-alt"></i></a>
        <?php if ($create > 0) { ?>
            <a href="<?= BASEURL; ?>/role/tambah" class="btn btn-primary btn-sm mb-3 tombolTambahRole" data-toggle="modal" data-target="#modalRole">
                <span class="icon text-white-50">
                    <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text">Tambah Role</span>
            </a> <?php } ?>
    </div>
    <div class="card mb-2 shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Role Access</h6>
        </div>
        <div class="card-body">
            <div class="col-lg-7">
                <?php Flasher::flash(); ?>
            </div>
            <div class="col-lg-7">
                <ul class="list-group">
                    <?php foreach ($data['role'] as $role) : ?>
                        <?php if ($role['id_role'] == 1) { ?>
                            <li class="list-group-item">
                                <?= $role['role']; ?>
                                <a href="<?= BASEURL; ?>/role/akses/<?= $role['id_role']; ?>" class="badge badge-primary float-right ml-1">Akses</a>
                            </li>
                        <?php } else { ?>
                            <li class="list-group-item">
                                <?= $role['role']; ?>
                                <a href="<?= BASEURL; ?>/role/akses/<?= $role['id_role']; ?>" class="badge badge-primary float-right ml-1">Akses</a>
                                <?php if ($delete > 0) { ?>
                                    <a href="<?= BASEURL; ?>/role/hapus/<?= $role['id_role']; ?>" class="badge badge-danger float-right ml-1 tombol-hapus">Hapus</a> <?php } ?>
                                <?php if ($update > 0) { ?>
                                    <a href="" class="badge badge-warning float-right ml-1 modalEditRole" data-toggle="modal" data-target="#modalRole" data-id_role="<?= $role['id_role']; ?>">Ubah</a> <?php } ?>
                            </li>
                    <?php }
                    endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>


<!-- Modal -->
<div class="modal fade" id="modalRole" tabindex="-1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="judulModal">Tambah Role</h3>
            </div>
            <div class="modal-body">
                <form action="<?= BASEURL; ?>/role/tambah" method="post">
                    <div class="form-group">
                        <input type="hidden" name="id_role" value="" class="form-control" id="id_role">
                    </div>
                    <div class="form-group">
                        <label for="role">Nama role</label>
                        <input type="text" name="role" class="form-control" id="role" required autofocus>
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