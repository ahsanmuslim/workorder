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
    <h1 class="h3 mb-2 text-gray-800">General Data</h1>

    <div class="text-right">
        <a href="<?= BASEURL; ?>/holidays" class="btn btn-outline-secondary btn-sm mb-3"><i class="fas fa-sync-alt"></i></a>
        <?php if ($create > 0) { ?>
            <a href="<?= BASEURL; ?>/holidays/add_holidays" class="btn btn-primary btn-sm mb-3">
                <span class="icon text-white-50">
                    <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text">Tambah holidays</span>
            </a> <?php } ?>
    </div>

    <div class="card text-center shadow">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
            	<?php if ($this->models('role_model')->countAccess($id_role, 'kategori') != 0) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASEURL; ?>/kategori"><b>Kategori WO</b></a>
                </li>
                <?php }
				if ($this->models('role_model')->countAccess($id_role, 'progress') != 0) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASEURL; ?>/progress"><b>Progress WO</b></a>
                </li>
                <?php }
                if ($this->models('role_model')->countAccess($id_role, 'holidays') != 0) { ?>
                <li class="nav-item">
                    <a class="nav-link active" href="<?= BASEURL; ?>/holidays"><b>Hari Libur</b></a>
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
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th class="judul"><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($data['holidays'] as $holidays) : ?>
                            <tr>
                                <td class="judul"><?= $no++ ?></td>
                                <td><?= date('d M y', strtotime($holidays['tanggal'])) ?></td>
                                <td><?= $holidays['keterangan']; ?> </td>
                                <td class="judul">
                                    <?php if ($update > 0) { ?>
                                        <a href="<?= BASEURL; ?>/holidays/edit_holidays/<?= $holidays['id']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-fw fa-pen"></i></a> <?php } ?>
                                    <?php if ($delete > 0) { ?>
                                        <a href="<?= BASEURL; ?>/holidays/hapusholidays/<?= $holidays['id']; ?>" class="btn btn-danger btn-sm tombol-hapus"><i class="fas fa-fw fa-trash-alt"></i></i></a> <?php } ?>
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