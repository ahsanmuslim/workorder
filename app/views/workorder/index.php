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
    <h1 class="h3 mb-2 text-gray-800">Work Order Monitoring</h1>
    <div class="text-right">
        <a href="<?= BASEURL; ?>/workorder" class="btn btn-outline-secondary btn-sm mb-3"><i class="fas fa-sync-alt"></i></a>
        <!-- //akses create data -->
        <?php if ($create > 0) { ?>
            <a href="<?= BASEURL; ?>/workorder/tambah" class="btn btn-primary btn-sm mb-3">
                <span class="icon text-white-50">
                    <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text">Tambah WO</span>
            </a> <?php } ?>
    </div>
    <div class="card mb-2 shadow">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data Work Order</h6>
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
            <div class="col-lg-8">
                <?php Flasher::flash(); ?>
            </div>
            <div class="table-responsive">
                <table class="table table-hover" id="tblworkorder">
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
                            <th>Tanggal</th>
                            <th>No Work Order</th>
                            <th>Nama Work Order</th>
                            <th>Dept</th>
                            <th>Biaya</th>
                            <th>Aktual</th>
                            <th>Priority</th>
                            <th>Progress</th>
                            <th>Status</th>
                            <th class="judul"><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // var_dump($data['dataWorkorder']);
                        $no = 1;
                        foreach ($data['dataWorkorder'] as $wo) :
                            $id_wo = $wo['id_wo'];
                            $data['progress'] = $this->models('workorder_model')->getProgress($id_wo); // improvement
                            // var_dump($data['progress']);
                        ?>
                            <tr>
                                <td class="judul"><?= $no++ ?></td>
                                <td><?= date('d M y', strtotime($wo['tanggal'])) ?></td>
                                <td>
                                <?php if ($wo['prioritas'] == 1) {
                                   echo  '<i class="btn btn-warning btn-sm fa fa-lightbulb"></i>';
                                } ?>
                                <?= $wo['id_wo']; ?>
                                </td>
                                <td>
                                    <?= $wo['nama_wo']; ?>
                                    <?php 
                                    $tooltip = false;
                                    $aksi = "Approve";
                                    //cek user aktif
                                    if($data['user']['role'] == 6 && $wo['approve_dept'] != null && $wo['verified'] == null){
                                        $tooltip = true;
                                        $aksi = "Verifikasi";
                                    } elseif ($data['user']['role'] == 3 && $wo['approve_dept'] == null) {
                                        $tooltip = true;
                                    } elseif ($data['user']['role'] == 7 && $wo['approve_dept'] == null && $wo['department'] == 16 ) {
                                        $tooltip = true;
                                    } elseif ($data['user']['role'] == 5 && $wo['approve_div'] == null && $wo['approve_hr'] != null) {
                                        $tooltip = true;
                                    } elseif($data['user']['role'] == 7 && $wo['approve_hr'] == null && $wo['verified'] != null) {
                                        $tooltip = true;
                                        $aksi = "Periksa";
                                    }
                                    
                                    if ($tooltip) { ?>
                                    <a href="<?= BASEURL; ?>/workorder/detail/<?= $wo['id_wo']; ?>"><i class="fas fa-exclamation-circle text-danger ml-3" data-toggle="tooltip" title="Work Order ini belum di <?= $aksi ?>"></i></a>
                                    <?php }
                                    
                                    $problem = $this->models('problem_model')->cekproblem($wo['id_wo']);
                                    if ($problem > 0) :
                                    ?>
                                        <a href="" class="modalShowProblem ml-2" data-toggle="modal" data-target=".modalProblem" data-id_wo="<?= $wo['id_wo'] ?>"><i class="fas fa-bug text-danger"></i></a>
                                    <?php endif; ?>
                                </td>
                                <td><?= $wo['nama_dept']; ?></td>
                                <td>Rp <?= number_format($wo['plan_biaya']); ?></td>
                                <td>Rp <?= number_format($wo['act_biaya']); ?></td>
                                <?php
                                if ($wo['prioritas'] == 1) { ?>
                                    <td class="judul"><span class="badge badge-pill badge-danger">Urgent</span></td>
                                <?php } else { ?>
                                    <td class="judul"><span class="badge badge-pill badge-secondary">Normal</span></td>
                                <?php } ?>
                                <td class="judul">
                                <?php if($data['progress']['progress'] == 'Handover' && $wo['status'] == 'Closed') { ?>
                                <span class="badge badge-pill badge-primary">Finish</span>
                                <?php } else { ?>
                                <span class="badge badge-pill badge-success"><?= $data['progress']['progress'] ?></span>
                                <?php } ?>
                                </td>
                                <td class="judul"><?= $wo['status']; ?></td>
                                <td class="text-right">
                                    <?php
                                    // verified
                                    if ( $data['user']['role'] == 6 && $wo['approve_dept'] != null && $wo['verified'] == null ) { ?>
                                        <a href="<?= BASEURL; ?>/workorder/approve/<?= $wo['id_wo']; ?>/<?= $data['user']['role'] ?>/<?= $wo['department'] ?>" class="btn btn-primary btn-sm" id="tombol-approve"><i class="fas fa-fw fa-check-double"></i></a>
                                    <?php }
                                    //approve work order Dept Head Non HR
                                    if ($data['user']['role'] == 3 && $wo['approve_dept'] == null) { ?>
                                        <a href="<?= BASEURL; ?>/workorder/approve/<?= $wo['id_wo']; ?>/<?= $data['user']['role'] ?>/<?= $wo['department'] ?>" class="btn btn-success btn-sm" id="tombol-approve"><i class="fas fa-fw fa-check-double"></i></a>
                                    <?php }
                                    //approve work order oleh HR dept head
                                    if ($data['user']['role'] == 7 && $wo['approve_dept'] == null && $wo['department'] == 16 ) { ?>
                                        <a href="<?= BASEURL; ?>/workorder/approve/<?= $wo['id_wo']; ?>/<?= $data['user']['role'] ?>/null" class="btn btn-success btn-sm" id="tombol-approve"><i class="fas fa-fw fa-check-double"></i></a>
                                    <?php }
                                    //approve semua WO oleh HR Dept Head
                                    if ($data['user']['role'] == 7 && $wo['approve_hr'] == null && $wo['verified'] != null) { ?>
                                        <a href="<?= BASEURL; ?>/workorder/approve/<?= $wo['id_wo']; ?>/<?= $data['user']['role'] ?>/<?= $wo['verified'] ?>" class="btn btn-primary btn-sm" id="tombol-approve"><i class="fas fa-fw fa-clipboard-check"></i></a>
                                    <?php }
                                    //approve work order oleh Division Head
                                    if ($data['user']['role'] == 5 && $wo['approve_div'] == null && $wo['approve_hr'] != null) { ?>
                                        <a href="<?= BASEURL; ?>/workorder/approve/<?= $wo['id_wo']; ?>/<?= $data['user']['role'] ?>/<?= $wo['department'] ?>" class="btn btn-danger btn-sm" id="tombol-approve"><i class="fas fa-fw fa-check-double"></i></a>
                                    <?php }
                                    //akses update data administrator & admin MTC
                                    if ($update > 0 && $wo['status'] != 'Closed' && $data['progress']['id_progress'] <= 3 && ($data['user']['role'] == 6 || $data['user']['role'] == 1) ) { ?>
                                        <a href="<?= BASEURL; ?>/workorder/update/<?= $wo['id_wo']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-fw fa-pen"></i></a>
                                    <?php } ?>
                                    <!-- //akses update Dept Head -->
                                    <?php
                                    if ($update > 0 && $wo['status'] != 'Closed' && $data['progress']['id_progress'] == 1 && $data['user']['role'] == 3 ) { ?>
                                        <a href="<?= BASEURL; ?>/workorder/update/<?= $wo['id_wo']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-fw fa-pen"></i></a>
                                    <?php } ?>
                                    <!--lihat detail wo -->
                                    <a href="<?= BASEURL; ?>/workorder/detail/<?= $wo['id_wo']; ?>" class="btn btn-info btn-sm"><i class="fas fa-fw fa-eye"></i></i></a>
                                    <!-- //akses print data -->
                                    <?php if ($print > 0) { ?>
                                        <a href="<?= BASEURL; ?>/workorder/print/<?= $wo['id_wo']; ?>" target="_blank" class="btn btn-secondary btn-sm"><i class="fas fa-fw fa-print"></i></i></a> <?php } ?>
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


<!-- Modal -->
<div class="modal fade modalProblem" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="table-responsive">
                <table class="table table-hover" id="tblmodalproblem">
                    <thead>
                        <style>
                            th.judul,
                            td.judul {
                                text-align: center;
                            }
                        </style>
                        <tr>
                            <th class="judul">No.</th>
                            <th>No WO</th>
                            <th>Problem</th>
                            <th>Tindak Lanjut</th>
                            <th>PIC</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>