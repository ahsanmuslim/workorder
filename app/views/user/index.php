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
    <h1 class="h3 mb-2 text-gray-800">User Management</h1>

    <div class="text-right">
        <a href="<?= BASEURL; ?>/user" class="btn btn-outline-secondary btn-sm mb-3"><i class="fas fa-sync-alt"></i></a>
        <?php if ($create > 0) { ?>
            <a href="<?= BASEURL; ?>/user/tambah" class="btn btn-primary btn-sm mb-3">
                <span class="icon text-white-50">
                    <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text">Tambah User</span>
            </a> <?php } ?>
    </div>
    <div class="card mb-2 shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Daftar User</h6>
        </div>
        <div class="card-body">
            <div class="col-lg-8">
                <?php Flasher::flash(); ?>
            </div>
            <div class="table-responsive">
                <table id="tbluser" class="table table-hover">
                    <thead class="thead-light">
                        <style>
                            th.judul,
                            td.judul {
                                text-align: center;
                            }
                        </style>
                        <tr>
                            <th class="judul">No.</th>
                            <th>Nama User</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Level</th>
                            <th>Department</th>
                            <th>Register</th>
                            <th class="judul">Status</th>
                            <th class="judul"><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($data['datauser'] as $user) : ?>
                            <tr>
                                <td class="judul"><?= $no++ ?></td>
                                <td><?= $user['nama_user']; ?></td>
                                <td><?= $user['username']; ?></td>
                                <td><?= $user['email']; ?></td>
                                <td><?= $user['role']; ?></td>
                                <td><?= $user['nama_dept']; ?></td>
                                <td><?= date('d M y', strtotime($user['tgl_register'])) ?></td>
                                <td class="judul">
                                    <?php if ($user['status'] == 1) {
                                        echo 'Aktif';
                                    } else {
                                        echo 'Tidak Aktif';
                                    } ?>
                                </td>
                                <?php if ($user['username'] == "admin") { ?>
                                    <td class="judul">
                                        <a href="" class="btn btn-primary btn-sm"><i class="fas fa-fw fa-shield-alt"></i></a>
                                    </td>
                                <?php } else { ?>
                                    <td class="judul">
                                        <?php if ($update > 0) { ?>
                                            <a href="<?= BASEURL; ?>/user/update/<?= $user['id_user']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-fw fa-pen"></i></a> <?php } ?>
                                        <?php if ($delete > 0) { ?>
                                            <a href="<?= BASEURL; ?>/user/hapus/<?= $user['id_user']; ?>" class="btn btn-danger btn-sm tombol-hapus"><i class="fas fa-fw fa-trash-alt"></i></i></a> <?php } ?>
                                    </td>
                                <?php } ?>
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