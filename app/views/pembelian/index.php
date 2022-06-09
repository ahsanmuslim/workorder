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
    <h1 class="h3 mb-2 text-gray-800">Pembelian</h1>

    <div class="text-right">
        <a href="<?= BASEURL; ?>/pembelian" class="btn btn-outline-secondary btn-sm mb-3"><i class="fas fa-sync-alt"></i></a>
        <?php if ($create > 0) { ?>
            <a href="<?= BASEURL; ?>/pembelian/tambah" class="btn btn-primary btn-sm mb-3">
                <span class="icon text-white-50">
                    <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text">Tambah Pembelian</span>
            </a> <?php } ?>
    </div>
    <div class="card mb-2 shadow">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data Pembelian Material</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="col-lg-12">
                <?php Flasher::flash(); ?>
            </div>
            <div class="table-responsive">
                <table class="table table-hover" id="tblpembelian">
                    <thead class="thead-light">
                        <style>
                            th.judul,
                            td.judul {
                                text-align: center;
                            }
                        </style>
                        <tr>
                            <th class="judul">No.</th>
                            <th>Tanggal Pembelian</th>
                            <th>No Pembelian</th>
                            <th>Nama Work Order</th>
                            <th>Supplier</th>
                            <th>Total Pembelian</th>
                            <th class="judul"><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($data['pembelian'] as $pb) : ?>
                            <tr>
                                <td class="judul"><?= $no++ ?></td>
                                <td><?= date('d M y', strtotime($pb['tgl_pembelian'])) ?></td>
                                <td><?= $pb['id_pembelian']; ?></td>
                                <td><?= $pb['nama_wo']; ?></td>
                                <td><?= $pb['nama_supplier']; ?></td>
                                <td>Rp <?= number_format($pb['total']); ?></td>
                                <td class="text-right">
                                    <?php if ($update > 0 && $pb['status'] != 'Closed') { ?>
                                        <a href="<?= BASEURL; ?>/pembelian/update/<?= $pb['id_pembelian']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-fw fa-pen"></i></a> <?php } ?>
                                    <a href="<?= BASEURL; ?>/pembelian/detail/<?= $pb['id_pembelian']; ?>" class="btn btn-info btn-sm"><i class="fas fa-fw fa-eye"></i></i></a>
                                    <?php if ($delete > 0 && $pb['status'] != 'Closed') { ?>
                                        <a href="<?= BASEURL; ?>/pembelian/hapus/<?= $pb['id_pembelian']; ?>" class="btn btn-danger btn-sm tombol-hapus"><i class="fas fa-fw fa-trash"></i></a> <?php } ?>
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