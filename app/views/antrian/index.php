<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Antrian Work Order ( <?= count($data['inprogress']) ?> Active )</small></h1>
    <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
  </div>

  <?php 
  $jmldata = count($data['inprogress']);
  // echo $jmldata;
  $i = 1;
  foreach ($data['inprogress'] as $prog): 

  if ($i++ % 2 == 1){ ?>

  <!-- Content Row -->
  <div class="row mt-2">

    <!-- Total biaya -->
    <div class="col-xl-6 col-md-6 mb-2">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <?php 
                  $id_wo = $prog['id_wo'];
                  $data['pros'] = $this->models('antrian_model')->getActivityprogress($id_wo);
                  $data['act'] = $this->models('antrian_model')->getDataActivity($id_wo);
              ?>
              <div class="h5 font-weight-bold text-primary mb-1"><?= $prog['nama_wo'] ?></div>
              <div class="h5 mb-0 font-weight-bold text-gray-800 mb-1"><?= $prog['nama_dept'] ?></div>
              <div class="h6 mb-0 font-weight-bold text-gray-500"><?= $prog['nama_teknisi'] ?></div>
              <div class="h6 mb-0 mt-1 font-weight text-danger"><small>WO date : <?= date('d M y',strtotime($prog['tanggal'])) ?> ==> Start activity : <?= date('d M y',strtotime($data['act'][0]['tgl_activity'])) ?></small></div>
            </div>
            <div class="col-auto mr-5">
            	<div class="h1 font-weight-bold text-warning"><?= round($data['pros'][0]['pros'] * 100) ?>%</div>
            </div>
            <div class="col-auto">
              <a href="" class="modalShowActivity" data-toggle="modal" data-target=".modalActivity" data-id_wo="<?= $prog['id_wo'] ?>"><i class="fas fa-tasks fa-2x text-gray-300"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>

 	<?php 
	 	if ($i-1 == $jmldata){
	 		echo '</div>';
	 	}

	} else { ?>

	<!-- Total wo -->
    <div class="col-xl-6 col-md-6 mb-2">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <?php 
                  $id_wo = $prog['id_wo'];
                  $data['pros'] = $this->models('antrian_model')->getActivityprogress($id_wo);
                  $data['act'] = $this->models('antrian_model')->getDataActivity($id_wo);
              ?>
              <div class="h5 font-weight-bold text-primary mb-1"><?= $prog['nama_wo'] ?></div>
              <div class="h5 mb-0 font-weight-bold text-gray-800 mb-1"><?= $prog['nama_dept'] ?></div>
              <div class="h6 mb-0 font-weight-bold text-gray-500"><?= $prog['nama_teknisi'] ?></div>
              <div class="h6 mb-0 mt-1 font-weight text-danger"><small>WO date : <?= date('d M y',strtotime($prog['tanggal'])) ?> ==> Start activity : <?= date('d M y',strtotime($data['act'][0]['tgl_activity'])) ?></small></div>
            </div>
            <div class="col-auto mr-5">
            	<div class="h1 font-weight-bold text-warning"><?= round($data['pros'][0]['pros'] * 100) ?>%</div>
            </div>
            <div class="col-auto">
              <a href="" class="modalShowActivity" data-toggle="modal" data-target=".modalActivity" data-id_wo="<?= $prog['id_wo'] ?>"><i class="fas fa-tasks fa-2x text-gray-300"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>


  </div>

<?php 
}
endforeach; ?>


	<div class="card mb-2 shadow mt-4" id="waitinglist">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Waiting List Work Order - Material Ready ( Next Proccess ) </h6>
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
                <table class="table table-hover" id="tblwaitinglist">
                    <thead class="thead-light">
                    <style>
                        th.judul , td.judul {text-align: center;}
                    </style>
                        <tr>
                            <th class="judul">No.</th>    
                            <th>Tanggal</th>
                            <th>No Work Order</th>
                            <th>Nama Work Order</th>
                            <th>Dept</th>
                            <th>Teknisi</th>
                            <th class="judul">Priority</th>
                            <th class="judul">Progress</th>
                            <th class="judul">Estimasi</th>
                            <?php if ($data['user']['role'] == 6 || $data['user']['role'] == 1){ ?>
                            <th class="judul"><i class="fas fa-cog"></i></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $wl = count($data['waitinglist']);
                    $no = 1;
                    if ($wl == 0){
                    echo '<td colspan="8" style="text-align:center">Tidak ada work order dalam status Waiting List</td>';
                    } else {
                        foreach ($data['waitinglist'] as $list ) :
                        ?>
                        <tr>
                        	<?php if($no++ == 1) {  ?>
                            <td class="judul"><span class="btn btn-sm btn-info shadow btn-circle"><i class="fas fa-chevron-up"></i></span></td>
                        	<?php } else { ?>
                        		<td class="judul"><span class="btn btn-sm btn-danger btn-circle"><i class="fas fa-minus"></i></span></td>
                      		<?php } ?>
                            <td><?= date('d M y',strtotime($list['tanggal'])) ?></td>
                            <td><?= $list['id_wo']; ?></td>
                            <td><?= $list['nama_wo']; ?></td>
                            <td><?= $list['kode']; ?></td>
                            <td><?= $list['nama_teknisi']; ?></td>
                            <?php 
                            if ( $list['prioritas'] == 1 ) { ?>
                                <td class="judul"><span class="badge badge-pill badge-danger">Urgent</span></td>
                            <?php } else { ?>
                                <td class="judul"><span class="badge badge-pill badge-secondary">Normal</span></td>
                            <?php } ?>   
                            <td class="judul"><span class="badge badge-pill badge-success"><?= $list['progress'] ?></span></td>            
                            <!-- <td class="judul"><?= $list['status']; ?></td> -->
                            <td class="judul"><?= $list['estimasi']; ?> hari</td>
                            <?php if ($data['user']['role'] == 6 || $data['user']['role'] == 1){ ?>
                            <td><a href="#" class="modalAddEstimasi" data-toggle="modal" data-target=".modalEstimasi" data-id_wo="<?= $list['id_wo']; ?>"><i class="fas fa-fw fa-pen text-warning"></i></a></td>
                            <?php } ?>
                        </tr>
                        <?php endforeach; ?> 
                    <?php } ?> 
                    </tbody>
                </table>
                <!-- <a tabindex="0" role="button" data-toggle="popover" data-trigger="focus" title="Dismissible popover" data-content="And here's some amazing content. It's very engaging. Right?">Dismissible popover</a> -->
            </div>
        </div>
    </div>



  <!-- //footer -->
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->



<!-- Modal untuk list activity-->
<div class="modal fade modalActivity" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      	<div class="table-responsive">
            <table class="table table-hover" id="tblmodalactivity">
                <thead>
                <style>
                    th.judul , td.judul {text-align: center;}
                </style>
                    <tr>
                        <th class="judul">No.</th>    
                        <th>Tanggal</th>
                        <th>Detail Activity</th>
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
            

<!-- Modal edit estimasi pengerjaan-->
<div class="modal fade modalEstimasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Estimasi waktu pengerjaan</h5>
      </div>

      <div class="modal-body">
                <form action="<?= BASEURL; ?>/antrian/estimasi" method="post">
                    <div class="form-group">
                        <input type="hidden" name="id_wo" value="" class="form-control" id="id_wo_estimasi">      
                        <input type="number" name="estimasi" class="form-control" required>
                    </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </div>
  </div>
</div>
