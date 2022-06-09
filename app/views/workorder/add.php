<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Work Order</h1>

    <div class="text-left">
        <a href="<?= BASEURL; ?>/workorder" class="btn btn-warning btn-sm mb-3">
            <span class="icon text-white-50">
                <i class="fas fa-angle-double-left"></i>
            </span>
            <span class="text">Kembali</span>
        </a>
    </div>

<?php 
    // var_dump($data['code']);
    // $kode = $data['code'][0]['maxCode'];
    // $urutan = (int) substr($kode, 3, 4);
    // $urutan++;
    // $huruf = "HM-";
    // $kodeWO = $huruf . sprintf("%04s", $urutan);

    // revisi kode WO
    $tanggal = date('m');
    $year = date('y');
    $month ='';

    switch ($tanggal){
        case '01':
            $month = "I";
            break;
        case '02':
            $month = "II";
            break;
        case '03':
            $month = "III";
            break;
        case '04':
            $month = "IV";
            break;
        case '05':
            $month = "V";
            break;
        case '06':
            $month = "VI";
            break;
        case '07':
            $month = "VII";
            break;
        case '08':
            $month = "VIII";
            break;
        case '09':
            $month = "IX";
            break;
        case '10':
            $month = "X";
            break;
        case '11':
            $month = "X1";
            break;
        case '12':
            $month = "XII";
            break;
    }

    $kode = $data['code'][0]['maxCode'];
    $urutan = (int) $kode;
    $urutan++;
    $huruf = "HM-";
    $kodeWO = $huruf . sprintf("%03s", $urutan) . "-" . $month . "-" . $year;
    // echo $kodeWO;



?>

<!-- //row untuk detail work order -->
    <form action="<?= BASEURL; ?>/workorder/tambahWorkorder" method="post"  enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg">
            <div class="card mb-4 shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Work Order</h6> 
                </div>
                <div class="card-body">
                    <style>
                        label:not(.form-check-label) {font-weight:bold;}
                    </style>
                    <div class="form-group row">
                        <label for="tanggalwo" class="col-sm-2 col-form-label">Tanggal</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" name="tanggalwo" id="tanggalwo" value="<?=date('Y-m-d')?>" required>
                        </div>
                        <label for="id_wo" class="col-sm-2 col-form-label">No Work Order</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="id_wo" id="id_wo" value="<?= $kodeWO ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_wo" class="col-sm-2 col-form-label">Nama Work Order</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="nama_wo" id="nama_wo" autofocus required>
                        </div>
                        <label for="prioritas" class="col-sm-2 col-form-label">Priority</label>
                        <div class="col-sm-4">
                            <select name="prioritas" class="form-control" id="prioritas" required>                             
                                <option value=0>Normal</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="dept" class="col-sm-2 col-form-label">Department</label>
                        <div class="col-sm-4">
                            <select name="dept" class="form-control" id="dept" required>
                            <?php 
                            if ($data['user']['role'] == 1 || $data['user']['role'] == 6) {
                                foreach ( $data['dept'] as $dept ): ?>
                                    <option value="<?= $dept['id_dept']; ?>"><?= $dept['nama_dept'];  ?></option>
                            <?php endforeach; } else { ?>
                                    <option value="<?= $data['user']['id_dept']; ?>"><?= $data['user']['nama_dept'];  ?></option>
                            <?php } ?>
                            </select>
                        </div>
                        <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
                        <div class="col-sm-4">
                            <select name="kategori" class="form-control" id="kategori" required>
                            <?php foreach ( $data['kategori'] as $kat ): ?>
                                <option value="<?= $kat['id_kategori']; ?>"><?= $kat['nama_kategori'];  ?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="target" class="col-sm-2 col-form-label">Target Penggunaan</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" name="target" id="target" required>
                        </div>
                        <label for="lokasi" class="col-sm-2 col-form-label">Lokasi</label>
                        <div class="col-sm-4">
                            <select name="lokasi" class="form-control" id="lokasi" required>
                            <?php foreach ( $data['lokasi'] as $loc ): ?>
                                <option value="<?= $loc['id_lokasi']; ?>"><?= $loc['nama_lokasi'];  ?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pic" class="col-sm-2 col-form-label">PIC</label>
                        <div class="col-sm-4">
                            <select name="pic" class="form-control" id="pic" required>
                                <?php 
                                if ($data['user']['role'] == 1 || $data['user']['role'] == 6) { 
                                    foreach ($data['pic'] as $pic) : ?>
                                        <option value="<?= $pic['id_user'] ?>"><?= $pic['nama_user'] ?></option>
                                    <?php endforeach;
                                } else { ?>
                                    <option value="<?= $data['user']['id_user'] ?>"><?= $data['user']['nama_user'] ?></option>
                                <?php } ?>                               
                            </select>
                        </div>
                        <label for="biaya" class="col-sm-2 col-form-label">Rencana biaya</label>
                        <div class="col-sm-4">
                        <input type="number" class="form-control" name="biaya" id="biaya" value=0 readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="teknisi" class="col-sm-2 col-form-label">Teknisi</label>
                        <div class="col-sm-4">
                            <select name="teknisi" class="form-control" id="teknisi" required>
                                    <option value=""></option>
                                <?php foreach ($data['teknisi'] as $tek) : ?>
                                    <option value="<?= $tek['id_teknisi'] ?>"><?= $tek['nama_teknisi'] ?></option>
                                <?php endforeach;  ?>                            
                            </select>
                            <label class="col-sm-12 text-danger"><small>(pastikan sudah koordinasi dengan teknisi terkait)</small></label>
                        </div>
                    </div>

                    <div class="form-group row mt-0">
                        <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                        <div class="col-sm-10">
                        <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="drawing" class="col-sm-2 col-form-label">Drawing / Picture</label>
                        <div class="col-sm-10">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="drawing" name="drawing" onChange ="previewDrawing()" required> 
                                <label class="custom-file-label" for="drawing">Pilih file dengan format JPG-JPEG-PNG (max 2Mb)</label>
                            </div>
                        </div>                        
                    </div>
                    <div class="form-group row">                      
                        <img class="img-preview img-fluid col-sm-4 rounded mt-1 mb-1">
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
                </div>
            </div>
        </div>
    </div>

<!-- //row untuk detail rincian material -->
    <div class="row">
        <div class="col-lg">
            <div class="card mb-4 shadow">
                <div class="card-header py-3">
                    <div class="row">                    
                        <div class="col-sm-8">
                        <h6 class="m-0 font-weight-bold text-primary">Rincian Material</h6>
                        </div>
                        <div class="col-sm-4 text-right">
                            <a id="tambah-rm" class="text-primary tambah-rm"><i class="fas fa-fw fa-plus-circle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-lg-8">
                        <?php Flasher::flash(); ?>
                    </div>
                    <div class="col-lg">
                        <table class="table" id="tbl-material">
                            <style>
                                th.judul , td.judul {text-align: center;}
                                th.kanan {text-align: right;}
                            </style>
                                <tr>
                                    <th class="judul">No.</th>    
                                    <th width="350px">Nama Material</th>
                                    <th width="100px">Qty (plan)</th>
                                    <th width="100px">Satuan</th>
                                    <th>Harga satuan</th>
                                    <th>Total biaya</th>
                                    <th class="judul"><i class="fas fa-cog"></i></th>
                                </tr>
                            <tbody>
                                <?php for ( $i=1 ; $i<=10 ; $i++ ){ ?>
                                <tr id="row<?= $i ?>">
                                    <td><?= $i ?></td>
                                    <td>
                                        <select name="material[]" class="form-control field-material" id="<?= $i ?>">
                                            <option value=""></option>
                                            <?php foreach ( $data['material'] as $mat ): ?>
                                            <option value="<?= $mat['id_material']; ?>"><?= $mat['nama_material'];  ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </td>
                                    <td>
                                        <input type="number" name="qty[]" class="form-control qty<?= $i ?>" id="<?= $i ?>" value=1>
                                    </td>
                                    <td>
                                    <input type="text" name="satuan" class="form-control satuan<?= $i ?>" readonly>
                                    </td>
                                    <td>
                                    <input type="number" name="harga[]" class="form-control harga<?= $i ?>" readonly>
                                    </td>
                                    <td>
                                    <input type="number" name="total[]" class="form-control total-biaya" id="total<?= $i ?>" readonly>
                                    </td>
                                    <td>
                                        <button type="button" name="hapus" id="<?= $i ?>" class="btn btn-danger btn-sm hapus-baris"><i class="fas fa-fw fa-trash"></i></button>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                            <tr>
                            <th colspan="5" class="kanan">Total Estimasi Biaya</th>
                            <th class="grandtotal"><strong>0</strong></th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>
    <div class="form-group text-center">
        <input type="submit" name="Simpan" value="Simpan Work Order" class="btn btn-success">
    </div>
    </form>                       


</div>
<!-- /.container-fluid -->

</div>

<script type="text/javascript">
    function previewDrawing () {
        const drawing = document.querySelector('#drawing');
        const imgPreview = document.querySelector('.img-preview');

        imgPreview.style.display = 'block';

        const oFreader =  new FileReader();
        oFreader.readAsDataURL(drawing.files[0]);

        oFreader.onload = function(oFREvent){
            imgPreview.src = oFREvent.target.result;
        }

        console.log(drawing.files[0]);
    }
</script>



