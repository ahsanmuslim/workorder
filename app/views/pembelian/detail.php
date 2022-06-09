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
    <h1 class="h3 mb-2 text-gray-800">Detail Pembelian</h1>

    <div class="text-left">
        <a href="<?= BASEURL; ?>/pembelian" class="btn btn-warning btn-sm mb-3">
            <span class="icon text-white-50">
                <i class="fas fa-angle-double-left"></i>
            </span>
            <span class="text">Kembali</span>
        </a>
    </div>

    <!-- //row untuk detail work order -->
    <div class="row">
        <div class="col-lg">
            <div class="card mb-2 shadow">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-8">
                            <h6 class="m-0 font-weight-bold text-primary">Data pembelian material</h6>
                        </div>
                        <?php if ($update > 0 && $data['detail']['status'] != 'Closed') { ?>
                            <div class="col-sm-4 text-right">
                                <a href="<?= BASEURL; ?>/pembelian/update/<?= $data['detail']['id_pembelian']; ?>"><i class="fas fa-fw fa-pen"></i></a>
                            </div> <?php } ?>
                    </div>
                </div>
                <div class="card-body">
                    <style>
                        label:not(.form-check-label) {
                            font-weight: bold;
                        }
                    </style>
                    <div class="form-group row">
                        <label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="tanggal" id="tanggal" value="<?= date('d M Y', strtotime($data['detail']['tgl_pembelian'])) ?>" disabled>
                        </div>
                        <label for="id_wo" class="col-sm-2 col-form-label">No Work Order</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="id_wo" id="id_wo" value="<?= $data['detail']['id_wo'] ?>" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="id_pembelian" class="col-sm-2 col-form-label">No Pembelian</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="id_pembelian" id="id_pembelian" value="<?= $data['detail']['id_pembelian'] ?>" disabled>
                        </div>
                        <label for="nama_wo" class="col-sm-2 col-form-label">Nama Work Order</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="nama_wo" id="nama_wo" value="<?= $data['detail']['nama_wo'] ?>" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="supplier" class="col-sm-2 col-form-label">Supplier</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="supplier" id="supplier" value="<?= $data['detail']['nama_supplier'] ?>" disabled>
                        </div>
                        <label for="total" class="col-sm-2 col-form-label">Total Pembelian</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="total" id="total" value="Rp <?= number_format($data['detail']['total']) ?>" disabled>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- //row untuk detail rincian material -->
    <div class="row">
        <div class="col-lg">
            <div class="card mb-4 shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-light">
                                <style>
                                    th.judul,
                                    td.judul {
                                        text-align: center;
                                    }

                                    th.total {
                                        text-align: right;
                                    }
                                </style>
                                <tr>
                                    <th class="judul">No.</th>
                                    <th>Nama Material</th>
                                    <th class="judul">Qty</th>
                                    <th>Satuan</th>
                                    <th>Harga satuan</th>
                                    <th>Total Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($data['detailBeli'] as $beli) : ?>
                                    <tr>
                                        <td class="judul"><?= $no++ ?></td>
                                        <td><?= $beli['nama_material']; ?></td>
                                        <td class="judul"><?= $beli['jumlah']; ?></td>
                                        <td><?= $beli['satuan']; ?></td>
                                        <td>Rp <?= number_format($beli['harga']); ?></td>
                                        <td>Rp <?= number_format($beli['harga'] * $beli['jumlah']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <thead>
                                <tr>
                                    <th colspan="5" class="total">Total Pembelian</th>
                                    <th>Rp <?= number_format($data['detail']['total']) ?></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>





</div>
<!-- /.container-fluid -->

</div>