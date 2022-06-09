<?php
//script untuk cek user role
$id_role = $data['user']['role'];
$title = $data['title'];
$data['menu'] = $this->models('menu_model')->getMenubyTitle($title);
$controller = $data['menu']['url'];
// var_dump($data['menu']);

//authentifikasi CRUD 
$update = $this->models('role_model')->countUpdate($id_role, $controller);


?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">User Profile</h1>
    <div class="col-lg">
        <?php Flasher::flash(); ?>
    </div>
    <div class="col-lg-12 mt-4">
        <div class="card shadow-lg">
            <div class="card-header text-center">
                <b>My Profile</b>
            </div>
            <div class="card-body">
                <p class="text-center"><img src="<?= BASEURL; ?>/img/profile/<?= $data['user']['profile']; ?>" width="200" class="rounded-circle shadow-lg mt-2 mb-4 text-center" alt="<?= $data['user']['nama_user']; ?>"></p>
                <h4 class="card-title text-center"><b><?= $data['user']['nama_user']; ?> </b> ( <?= $data['user']['username']; ?> ) </h4>
                <hr>
                <p class="card-text mt-3 ml-5"><i class="fas fa-envelope mr-4"></i><?= $data['user']['email']; ?></p>
                <p class="card-text ml-5"><i class="fas fa-phone mr-4"></i><?= $data['user']['no_telp']; ?></p>
                <?php if ($data['user']['role'] == 5) { ?>
                    <p class="card-text ml-5"><i class="fas fa-id-badge mr-4"></i><?= $data['user']['nama_role']; ?> - <?= $data['user']['nama_divisi']; ?></p>
                <?php } else { ?>
                    <p class="card-text ml-5"><i class="fas fa-id-badge mr-4"></i><?= $data['user']['nama_role']; ?> - <?= $data['user']['nama_dept']; ?></p>
                <?php } ?>
                <p class="card-text ml-5"><i class="fas fa-clock mr-4"></i><?= 'Registered since - ' . date('d F Y', strtotime($data['user']['tgl_register'])) ?></p>
                <hr>
                <?php if ($update > 0) { ?>
                    <p class="text-center"><a href="<?= BASEURL; ?>/profile/update/<?= $data['user']['id_user'] ?>" class="btn btn-info mt-3">Edit Profile</a></p>
                <?php } ?>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>