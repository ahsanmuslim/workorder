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
$print = $this->models('role_model')->countPrint($id_role, $controller);

?>



<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Kas Keluar</h1>

    <?php
    if ($data['user']['role'] != 4) {
        if (empty($data['woapprove'])) { ?>

            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                <strong>Good work !!!</strong> Semua Approved work order sudah diajukan Dana
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

        <?php } else { ?>

            <!-- table list uwo yang sudah approve -->
            <div class="card mb-4 shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Data work order sudah disetujui ( Approved )</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <table class="table">
                            <tr>
                                <th>#</th>
                                <th>ID Work Order</th>
                                <th>Nama Work Order</th>
                                <th>Tanggal Approve</th>
                                <th class="judul"><i class="fas fa-cog"></i></th>
                            </tr>
                            <?php
                            $no = 1;
                            foreach ($data['woapprove'] as $app) : ?>
                                <tr>
                                    <td class="judul"><?= $no++ ?></td>
                                    <td><?= $app['id_wo'] ?></td>
                                    <td><?= $app['nama_wo'] ?></td>
                                    <td><?= date('d M y', strtotime($app['approve_div'])) ?></td>
                                    <td class="judul">
                                        <?php if ($app['plan_biaya'] == 0) { ?>
                                            <a href="<?= BASEURL; ?>/kaskeluar/nocost/<?= $app['id_wo']; ?>" class="btn btn-danger">Tanpa biaya</a>
                                        <?php } else { ?>
                                            <a href="<?= BASEURL; ?>/kaskeluar/tambah/<?= $app['id_wo']; ?>" class="btn btn-success">Ajukan kas</a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>

    <?php }
    }
    ?>




    <!-- table list untuk monitoring pengajuan dana -->
    <div class="card mb-2 shadow">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Detail Pengeluaran Kas</h6>
        </div>
        <div class="card-body">
            <div class="col-lg-12">
                <?php Flasher::flash(); ?>
            </div>
            <div class="table-responsive">
                <table class="table table-hover" id="tblkaskeluar">
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
                            <th>ID WO</th>
                            <th>Work Order</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Aktual Biaya</th>
                            <th>Selisih</th>
                            <th class="judul">Status</th>
                            <th>Diterima</th>
                            <th>PIC</th>
                            <th class="judul"><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // var_dump($data['kaskeluar']);
                        $no = 1;
                        foreach ($data['kaskeluar'] as $kas) :
                            $id_wo = $kas['id_wo'];
                            $data['progress'] = $this->models('workorder_model')->getProgress($id_wo); // improvement
                            // var_dump($data['progress']);
                        ?>
                            <tr>
                                <td class="judul"><?= $no++ ?></td>
                                <td><?= $kas['id_wo']; ?></td>
                                <td><?= $kas['nama_wo']; ?></td>
                                <td><?= date('d M y', strtotime($kas['tgl_pengajuan'])) ?></td>
                                <td>Rp <?= number_format($kas['jml_pengajuan']); ?></td>
                                <td>Rp <?= number_format($kas['aktual_biaya']); ?></td>
                                <?php
                                $text = "";
                                    if ($kas['aktual_biaya'] > $kas['jml_pengajuan'] ) {
                                        $text = 'text-danger';
                                    } elseif ($kas['aktual_biaya'] < $kas['jml_pengajuan']) {
                                        $text = 'text-primary';
                                    }
                                ?>
                                <td class="<?= $text ?>">
                                    Rp <?= number_format($kas['jml_pengajuan']-$kas['aktual_biaya']); ?>                                    
                                </td>
                                <?php
                                if ($kas['status'] == 'waiting list') { ?>
                                    <td class="judul"><span class="badge badge-pill badge-danger">waiting list</span></td>
                                <?php } elseif ($kas['status'] == 'cash ready') { ?>
                                    <td class="judul"><span class="badge badge-pill badge-success">cash ready</span></td>
                                <?php } elseif ($kas['status'] == 'already taken') { ?>
                                    <td class="judul"><span class="badge badge-pill badge-secondary">already taken</span></td>
                                <?php } ?>
                                <td><?php if (!empty($kas['tgl_terima'])) {
                                        echo date('d M y', strtotime($kas['tgl_terima']));
                                    } ?></td>
                                <td><?= $kas['pic_terima']; ?></td>
                                <td style="text-align: right;">
                                    <?php if ($kas['status'] == 'waiting list' && $data['user']['role'] == 4) { ?>
                                        <a href="<?= BASEURL; ?>/kaskeluar/ready/<?= $kas['id_dana']; ?>/<?= $kas['id_wo']; ?>" class="btn btn-success btn-sm"><i class="fas fa-fw fa-check"></i></a>
                                    <?php } elseif ($kas['status'] == 'cash ready') { ?>
                                        <?php if ($update > 0 && $kas['status'] != 'Closed') { ?>
                                            <a href="<?= BASEURL; ?>/kaskeluar/edit/<?= $kas['id_dana']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-fw fa-pen"></i></a> <?php } ?>
                                    <?php } ?>
                                    <?php if ($delete > 0 && $kas['status'] != 'Closed' && $data['progress']['id_progress'] <= 4) { ?>
                                        <a href="<?= BASEURL; ?>/kaskeluar/hapus/<?= $kas['id_dana']; ?>" class="btn btn-danger btn-sm tombol-hapus"><i class="fas fa-fw fa-trash-alt"></i></a> <?php } ?>
                                    <?php if ($print > 0) { ?>
                                        <a href="<?= BASEURL; ?>/kaskeluar/print/<?= $kas['id_wo']; ?>" target="_blank" class="btn btn-secondary btn-sm"><i class="fas fa-fw fa-print"></i></i></a> <?php } ?>
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