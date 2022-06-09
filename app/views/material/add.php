<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Material</h1>

    <div class="text-left">
        <a href="<?= BASEURL; ?>/material" class="btn btn-warning btn-sm mb-3">
            <span class="icon text-white-50">
                <i class="fas fa-angle-double-left"></i>
            </span>
            <span class="text">Kembali</span>
        </a>
    </div>
    <?php 
    // var_dump($data['code']);

    $kode = $data['code'][0]['maxCode'];
    $urutan = (int) substr($kode, 3, 3);
    $urutan++;
    $huruf = "RM-";
    $kodeMaterial = $huruf . sprintf("%03s", $urutan);
    // echo $kodeBeli;

    ?>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-0 shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Material</h6>
                </div>
                <div class="card-body">
                    <style>
                        form label:not(.form-check-label) {font-weight:bold;}
                    </style>
                    <div class="col-lg">
                    <form action="<?= BASEURL; ?>/material/tambahMaterial" method="post">
                        <div class="form-group">
                            <label for="id_material">ID Material</label>
                            <input type="text" name="id_material" id="id_material" class="form-control" value="<?= $kodeMaterial ?>" readonly autofocus>
                        </div>
                        <div class="form-group">
                            <label for="material">Nama Material</label>
                            <input type="text" name="material" id="material" class="form-control" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="jenis">Jenis Material</label>
                            <input type="text" name="jenis" id="jenis" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="stok">Stok Awal</label>
                            <input type="number" name="stok" id="stok" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="satuan">Satuan</label>
                            <select name="satuan" class="form-control" id="satuan" required>
                                <option value="pcs">pcs</option>
                                <option value="lembar">lembar</option>
                                <option value="batang">batang</option>
                                <option value="set">set</option>
                                <option value="unit">unit</option>
                                <option value="kaleng">kaleng</option>
                                <option value="pail">pail</option>
                                <option value="kg">kg</option>
                                <option value="kg">meter</option>
                                <option value="kg">pack</option>
                                <option value="kg">box</option>
                                <option value="kg">roll</option>    
                                <option value="kg">liter</option>                       
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga Material</label>
                            <input type="number" name="harga" id="harga" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="ket">Keterangan</label>
                            <input type="text" name="ket" id="ket" class="form-control" required>
                        </div>
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