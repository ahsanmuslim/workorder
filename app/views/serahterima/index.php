<?php
//script untuk cek user role
$id_role = $data['user']['role'];
$title = $data['title'];
$data['menu'] = $this->models('menu_model')->getMenubyTitle($title);
$controller = $data['menu']['url'];
// var_dump($data['user']['nama_user']);

//authentifikasi CRUD 
$create = $this->models('role_model')->countCreate($id_role, $controller);
$update = $this->models('role_model')->countUpdate($id_role, $controller);
$delete = $this->models('role_model')->countDelete($id_role, $controller);

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Handover Project</h1>

    <div class="text-right">
        <a href="<?= BASEURL; ?>/serahterima" class="btn btn-outline-secondary btn-sm mb-3"><i class="fas fa-sync-alt"></i></a>
        <?php if ($create > 0) { ?>
            <a href="<?= BASEURL; ?>/serahterima/tambah" class="btn btn-primary btn-sm mb-3">
                <span class="icon text-white-50">
                    <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text">Tambah handover</span>
            </a> <?php } ?>
    </div>
    <div class="card mb-2 shadow">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Detail Handover Work Order</h6>
        </div>
        <div class="card-body">
            <div class="col-lg-12">
                <?php Flasher::flash(); ?>
            </div>
            <div class="table-responsive">
                <table class="table table-hover" id="tblserahterima">
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
                            <th>Dept</th>
                            <th>PIC</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Hasil</th>
                            <!-- <th>Komentar</th> -->
                            <th>Penilaian</th>
                            <th class="judul"><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($data['serahterima'] as $srh) : ?>
                            <tr>
                                <td class="judul"><?= $no++ ?></td>
                                <td>
                                    <?= $srh['nama_wo']; ?>
                                    <?php if ($update > 0 && $srh['status'] != 'Closed' && $data['user']['nama_user'] == $srh['nama_user']) { ?>
                                    <a href="<?= BASEURL; ?>/serahterima/edit/<?= $srh['id_serahterima']; ?>"><i class="fas fa-exclamation-circle text-danger ml-3" data-toggle="tooltip" title="Work order yang Anda ajukan sudah selesai, Silahkan diterima !"></i></a>
                                    <?php } ?>
                                </td>
                                <td><?= $srh['kode']; ?></td>
                                <td><?= $srh['nama_user']; ?></td>
                                <td><?= date('d M y', strtotime($srh['tgl_penyerahan'])) ?></td>
                                <td><?= $srh['jam']; ?></td>
                                <td><?= $srh['hasil']; ?></td>
                                <!-- <td><?= $srh['komentar']; ?></td> -->
                                <td>
                                    <?php for ($i = 1; $i <= $srh['penilaian']; $i++) { ?>
                                        <i class="fas fa-fw fa-star text-warning"></i>
                                    <?php } ?>
                                    <font color="white"><?= $srh['penilaian']; ?></font>
                                </td>
                                <td>
                                    <a href="<?= BASEURL; ?>/serahterima/detail/<?= $srh['id_serahterima']; ?>" class="btn btn-info btn-sm"><i class="fas fa-fw fa-eye"></i></i></a>
                                    <?php if ($update > 0 && $srh['status'] != 'Closed' && $data['user']['nama_user'] == $srh['nama_user']) { ?>
                                        <a href="<?= BASEURL; ?>/serahterima/edit/<?= $srh['id_serahterima']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-fw fa-pen"></i></a> <?php } ?>
                                    <?php if ($delete > 0 && $srh['status'] != 'Closed') { ?>
                                        <a href="<?= BASEURL; ?>/serahterima/hapus/<?= $srh['id_serahterima']; ?>" class="btn btn-danger btn-sm tombol-hapus"><i class="fas fa-fw fa-trash-alt"></i></i></a> <?php } ?>
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