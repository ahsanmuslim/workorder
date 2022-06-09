<style type="text/css">
    img.zoom {
        -webkit-transition: all .2s ease-in-out;
        -moz-transition: all .2s ease-in-out;
        -o-transition: all .2s ease-in-out;
        -ms-transition: all .2s ease-in-out;
    }
     
    .transisi {
        -webkit-transform: scale(1.2); 
        -moz-transform: scale(1.2);
        -o-transform: scale(1.2);
        transform: scale(1.2);
    }
</style>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Handover</h1>

    <div class="text-left">
        <a href="<?= BASEURL; ?>/serahterima" class="btn btn-warning btn-sm mb-3">
            <span class="icon text-white-50">
                <i class="fas fa-angle-double-left"></i>
            </span>
            <span class="text">Kembali</span>
        </a>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-0 shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Handover Project</h6>
                </div>
                <div class="card-body">
                    <style>
                        form label:not(.form-check-label) {font-weight:bold;}
                    </style>
                    <div class="row">
                        <div class="col-lg-6">
                        <form action="<?= BASEURL; ?>/serahterima/updateserahterima" method="post">
                            <div class="form-group">
                                <label for="id_wo">Work Order</label>
                                <input type="hidden" name="id" id="id" class="form-control" value="<?= $data['handover']['id_serahterima'] ?>" disabled>
                                <input type="text" name="id_wo" id="id_wo" class="form-control" value="<?= $data['handover']['id_wo'].' '.$data['handover']['nama_wo'] ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="tanggal">Tanggal penyerahan</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?= $data['handover']['tgl_penyerahan'] ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="jam">Jam penyerahan</label>
                                <input type="time" name="jam" id="jam" class="form-control" value="<?= $data['handover']['jam'] ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="hasil">Hasil</label>
                                <input type="text" name="status" id="status" class="form-control" value="<?= $data['handover']['hasil'] ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="komentar">Komentar</label>
                                <input type="text" name="komentar" id="komentar" class="form-control" value="<?= $data['handover']['komentar'] ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="penilaian">Penilaian</label>
                                <div>                            
                                    <div class="text-left"> 
                                        <?php for ($i=1; $i<=$data['handover']['penilaian']; $i++){ ?>
                                            <i class="fas fa-fw fa-star text-warning"></i>
                                        <?php } ?>                         
                                    </div>                            
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                            <h6 class="text-center">Gambar hasil project / work order</h6>  
                            <p class="text-center"><img src="<?= BASEURL; ?>/img/hasil/<?= $data['handover']['gambar']; ?>" style="width:100%; height: 100%; max-height: 500px; max-width:600px;" class="rounded zoom shadow img-thumbnail mt-1 mb-1 text-center" alt="<?= $data['handover']['gambar']; ?>"></p>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>