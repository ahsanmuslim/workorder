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
        <div class="col-lg-8">
            <div class="card mb-0 shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Handover Project</h6>
                </div>
                <div class="card-body">
                    <style>
                        form label:not(.form-check-label) {font-weight:bold;}
                    </style>
                    <div class="col-lg">
                    <form action="<?= BASEURL; ?>/serahterima/tambahserahterima" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="id_wo">Finished Work Order </label>
                            <select name="id_wo" class="form-control list-wo-finished" id="id_wo" required>
                                <option value=""></option>
                            <?php foreach ( $data['workorder'] as $wo ): ?>
                                <option value="<?= $wo['id_wo']; ?>"><?= $wo['id_wo'].' ';  ?><?= $wo['nama_wo'];  ?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal penyerahan</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?=date('Y-m-d')?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="jam">Jam penyerahan</label>
                            <?php date_default_timezone_set('Asia/Jakarta'); ?>
                            <input type="time" name="jam" id="jam" class="form-control" value="<?= date('H:i') ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="hasil">Image Finished Work Order</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="hasil" name="hasil" onChange="previewHasil()" required> 
                                <label class="custom-file-label" for="hasil">Pilih file dengan format JPG-PNG-JPEG (max 2Mb)</label>
                            </div>
                        </div>
                        <div class="form-group">                      
                            <img class="img-preview img-fluid rounded mt-1 mb-1">
                        </div>
                        <style type="text/css">
                            .img-preview {
                                margin:10px auto 20px;
                                display: block;
                                width:100%; 
                                height: 100%; 
                                max-height: 500px;
                                 max-width:500px;
                            }
                        </style>
                        <!--  -->
                        <br>
                        <div class="form-group text-right">
                            <input type="submit" name="simpan" value="Simpan" class="btn btn-success">
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>

<script type="text/javascript">
    function previewHasil () {
        const hasil = document.querySelector('#hasil');
        const imgPreview = document.querySelector('.img-preview');

        imgPreview.style.display = 'block';

        const oFreader =  new FileReader();
        oFreader.readAsDataURL(hasil.files[0]);

        oFreader.onload = function(oFREvent){
            imgPreview.src = oFREvent.target.result;
        }

        console.log(hasil.files[0]);
    }
</script>