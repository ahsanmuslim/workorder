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

<!-- //row untuk detail work order -->
    <form action="<?= BASEURL; ?>/workorder/updateWorkorder" method="post"  enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg">
            <div class="card mb-4 shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Update Work Order</h6> 
                </div>
                <div class="card-body">
                    <style>
                        label:not(.form-check-label) {font-weight:bold;}
                    </style>
                    <div class="form-group row">
                        <label for="tanggalwo" class="col-sm-2 col-form-label">Tanggal</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" name="tanggalwo" id="tanggalwo" value="<?= $data['detailWO']['tanggal'] ?>" readonly>
                        </div>
                        <label for="id_wo" class="col-sm-2 col-form-label">No Work Order</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="id_wo" id="id_wo" value="<?= $data['detailWO']['id_wo'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_wo" class="col-sm-2 col-form-label">Nama Work Order</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="nama_wo" id="nama_wo" value="<?= $data['detailWO']['nama_wo'] ?>" required>
                        </div>
                        <label for="prioritas" class="col-sm-2 col-form-label">Priority</label>
                        <div class="col-sm-4">
                            <select name="prioritas" class="form-control" id="prioritas">
                            <?php if ($data['user']['role'] == 6 || $data['user']['role'] == 1 )  { ?>                          
                                <option value=0 <?php if($data['detailWO']['prioritas'] == 0) { echo 'selected'; } ?> >Normal</option>
                                <option value=1 <?php if($data['detailWO']['prioritas'] == 1) { echo 'selected'; } ?> >Urgent</option>
                            <?php } else { ?>
                                <option value=0>Normal</option>
                            <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="dept" class="col-sm-2 col-form-label">Department</label>
                        <div class="col-sm-4">
                            <select name="dept" class="form-control" id="dept" required>
                            <?php if ($data['user']['role'] == 6 || $data['user']['role'] == 1 )  { ?> 
                                <?php foreach ( $data['dept'] as $dept ): ?>
                                    <option value="<?= $dept['id_dept']; ?>" <?php if($data['detailWO']['department'] == $dept['id_dept']) { echo 'selected'; } ?> ><?= $dept['nama_dept'];  ?></option>
                                <?php endforeach; ?>
                            <?php } else { ?>
                                <option value="<?= $data['user']['id_dept']; ?>"><?= $data['user']['nama_dept'];  ?></option>
                            <?php } ?>
                            </select>
                        </div>
                        <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
                        <div class="col-sm-4">
                            <select name="kategori" class="form-control" id="kategori" required>
                            <?php foreach ( $data['kategori'] as $kat ): ?>
                                <option value="<?= $kat['id_kategori']; ?>" <?php if($data['detailWO']['id_kategori'] == $kat['id_kategori'] ){ echo 'selected'; } ?> ><?= $kat['nama_kategori'];  ?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="target" class="col-sm-2 col-form-label">Target Penggunaan</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" name="target" id="target" value="<?= $data['detailWO']['target_selesai'] ?>" readonly>
                        </div>
                        <label for="lokasi" class="col-sm-2 col-form-label">Lokasi</label>
                        <div class="col-sm-4">
                            <select name="lokasi" class="form-control" id="lokasi" required>
                            <?php foreach ( $data['lokasi'] as $loc ): ?>
                                <option value="<?= $loc['id_lokasi']; ?>" <?php if($data['detailWO']['id_lokasi'] == $loc['id_lokasi'] ){ echo 'selected'; } ?> ><?= $loc['nama_lokasi'];  ?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pic" class="col-sm-2 col-form-label">PIC</label>
                        <div class="col-sm-4">
                        <select name="pic" class="form-control" id="pic">
                                <option value="<?=  $data['detailWO']['id_user'] ?>"><?=  $data['detailWO']['nama_user'] ?></option>
                            </select>
                        </div>
                        <label for="biaya" class="col-sm-2 col-form-label">Rencana biaya</label>
                        <div class="col-sm-4">
                        <input type="number" class="form-control" name="biaya" id="biaya" value="<?= $data['detailWO']['plan_biaya'] ?>" readonly>
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label for="teknisi" class="col-sm-2 col-form-label">Teknisi</label>
                        <div class="col-sm-4">
                            <select name="teknisi" class="form-control teknisi-project-handled" id="teknisi" required>
                            <?php if ($data['user']['role'] == 6 || $data['user']['role'] == 1 )  { ?>  
                                <?php foreach ($data['teknisi'] as $tek) : ?>
                                    <option value="<?= $tek['id_teknisi'] ?>" <?php if($tek['id_teknisi']==$data['detailWO']['id_teknisi']){echo 'selected';} ?> ><?= $tek['nama_teknisi'] ?></option>
                                <?php endforeach; ?>
                            <?php } else { ?>
                                    <option value="<?=  $data['detailWO']['id_teknisi'] ?>"><?=  $data['detailWO']['nama_teknisi'] ?></option>
                            <?php } ?>
                            </select>
                        </div>
                        <label for="status" class="col-sm-2 col-form-label">Status WO</label>
                        <div class="col-sm-4">
                            <input type="hidden" class="form-control statuswo" value="<?= $data['detailWO']['status'] ?>">
                            <select name="status" class="form-control" id="status" required>
                            <?php if ($data['user']['role'] == 6 || $data['user']['role'] == 1 )  { ?>
                                <option value="Open" <?php if($data['detailWO']['status']=='Open'){echo 'selected';} ?> >Open</option>
                                <option value="Cancel" <?php if($data['detailWO']['status']=='Cancel'){echo 'selected';} ?> >Cancel</option>
                                <option value="Pending" <?php if($data['detailWO']['status']=='Pending'){echo 'selected';} ?> >Pending</option>
                            <?php } else { ?>
                                <option value="Open">Open</option>
                            <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                        <div class="col-sm-10">
                        <textarea class="form-control" id="deskripsi" name="deskripsi" required><?= $data['detailWO']['deskripsi'] ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- //row untuk drawing -->
    <div class="row">
        <div class="col-lg">
            <div class="card mb-4 shadow">
                <div class="card-header py-3">
                    <div class="row">                    
                        <div class="col-sm-8">
                        <h6 class="m-0 font-weight-bold text-primary">Drawing / Sketch / Ilustrasi / Photo</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-center">
                        <img src="<?= BASEURL; ?>/img/drawing/<?= $data['detailWO']['drawing']; ?>" class="img-preview rounded shadow mt-1 mb-1 text-center" alt="<?= $data['detailWO']['drawing']; ?>">
                    </p>
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
                    <input type="hidden" class="form-control" name="drawing-lama" value="<?= $data['detailWO']['drawing']; ?>" > 
                    <div class="form-group row">
                        <label for="drawing" class="col-sm-2 col-form-label">Drawing / Picture</label>
                        <div class="col-sm-10">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="drawing" name="drawing" onChange ="previewDrawing()"> 
                                <label class="custom-file-label" for="drawing">Pilih file dengan format JPG, JPEG atau PNG</label>
                            </div>
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
                                <!-- //looping data yang ada di base  -->
                                <?php 
                                // var_dump($data['detailMaterial']);
                                $jmldata = count($data['detailMaterial']);
                                for ( $i=0 ; $i<$jmldata ; $i++ ){ ?>
                                <tr id="row<?= $i ?>">
                                    <td><?= $i+1 ?></td>
                                    <td>
                                        <select name="material[]" class="form-control field-material" id="<?= $i ?>" required>
                                            <?php foreach ( $data['material'] as $mat ): 
                                            $selected = '';
                                            if ( $mat['id_material'] == $data['detailMaterial'][$i]['id_material'] ) { $selected = 'selected'; }
                                            ?>
                                            <option value="<?= $mat['id_material']; ?>" <?= $selected ?> ><?= $mat['nama_material'];  ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </td>
                                    <td>
                                        <input type="number" name="qty[]" class="form-control qty<?= $i ?>" id="<?= $i ?>" value="<?= $data['detailMaterial'][$i]['qty_plan'] ?>" required>
                                    </td>
                                    <td>
                                    <input type="text" name="satuan" class="form-control satuan<?= $i ?>" value="<?= $data['detailMaterial'][$i]['satuan'] ?>" readonly>
                                    </td>
                                    <td>
                                    <input type="number" name="harga[]" class="form-control harga<?= $i ?>" value="<?= $data['detailMaterial'][$i]['harga'] ?>" readonly>
                                    </td>
                                    <td>
                                    <input type="number" name="total[]" class="form-control total-biaya" id="total<?= $i ?>" value="<?= $data['detailMaterial'][$i]['qty_plan'] * $data['detailMaterial'][$i]['harga'] ?>" readonly>
                                    </td>
                                    <td>
                                        <button type="button" name="hapus" id="<?= $i ?>" class="btn btn-danger btn-sm hapus-baris"><i class="fas fa-fw fa-trash"></i></button>
                                    </td>
                                </tr>
                                <?php } ?>
                                <!-- looping baris kosong -->
                                <?php for ( $i=$jmldata ; $i<10 ; $i++ ){ ?>
                                <tr id="row<?= $i ?>">
                                    <td><?= $i+1 ?></td>
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
                            <th class="grandtotal"><strong><?= $data['detailWO']['plan_biaya'] ?></strong></th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>
    <div class="form-group text-center">
        <input type="submit" name="Update" value="Update Work Order" class="btn btn-info">
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