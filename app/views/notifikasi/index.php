<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Notifikasi Center</h1>

	<div class="card mb-2 shadow mt-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Notification Message</h6>
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
                <table class="table table-striped" id="tblnotifikasi">
                    <thead class="thead-light">
                    <style>
                        th.judul , td.judul {text-align: center;}
                    </style>
                        <tr>
                            <th class="judul">No.</th>    
                            <th>Time Created</th>
                            <th>Message</th>
                            <th>Link</th>
                            <th class="judul"><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                    <!-- content -->
                    <?php 
                    $no = 1;
                        foreach ($data['notifAll'] as $n ) :
                            if($n['readed'] == 0){
                                $bold = 'style="font-weight: bold;" class="text-primary"';
                             } else {
                                $bold = "";
                             }
                        ?>
                        <tr>
                            <td <?= $bold ?>><?= $no++; ?></td>
                            <td <?= $bold ?>><?= date('d-m-Y H:i',strtotime($n['tanggal'])) ?></td>
                            <td <?= $bold ?>><?= $n['pesan']; ?></td>
                            <td <?= $bold ?>><a href="<?= BASEURL; ?>/notifikasi/read/<?= $n['link'] ?>/<?= $n['id_notif'] ?>/<?= $n['id_wo'] ?>">Go to link</a></td>
                            <td class="judul">
                            <?php if($n['readed']==1){ ?>
                              <a href="#" class="btn btn-secondary btn-sm"><i class="fas fa-book-open"></i></a>  <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?> 
                    </tbody>
                </table>
            </div>
        </div>
    </div>



  <!-- //footer -->
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->