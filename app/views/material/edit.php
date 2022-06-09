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

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-0 shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Update Material</h6>
                </div>
                <div class="card-body">
                    <style>
                        form label:not(.form-check-label) {font-weight:bold;}
                    </style>
                    <div class="col-lg">
                    <form action="<?= BASEURL; ?>/material/updateMaterial" method="post">
                        <div class="form-group">
                            <input type="hidden" name="id_material" id="id_material" class="form-control" value="<?= $data['material']['id_material'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="material">Nama Material</label>
                            <input type="text" name="material" id="material" class="form-control" value="<?= $data['material']['nama_material'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="jenis">Jenis Material</label>
                            <input type="text" name="jenis" id="jenis" class="form-control" value="<?= $data['material']['jenis_material'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="stok">Stok Awal</label>
                            <input type="number" name="stok" id="stok" class="form-control" value="<?= $data['material']['stok'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="satuan">Satuan</label>
                            <select name="satuan" class="form-control" id="satuan" required>
                                <option value="pcs" <?php if($data['material']['satuan'] == 'pcs') {echo 'selected';} ?> >pcs</option>
                                <option value="lembar" <?php if($data['material']['satuan'] == 'lembar') {echo 'selected';} ?> >lembar</option>
                                <option value="batang" <?php if($data['material']['satuan'] == 'batang') {echo 'selected';} ?> >batang</option>
                                <option value="set" <?php if($data['material']['satuan'] == 'set') {echo 'selected';} ?> >set</option>
                                <option value="unit" <?php if($data['material']['satuan'] == 'unit') {echo 'selected';} ?> >unit</option>
                                <option value="kaleng" <?php if($data['material']['satuan'] == 'kaleng') {echo 'selected';} ?> >kaleng</option>
                                <option value="pail" <?php if($data['material']['satuan'] == 'pail') {echo 'selected';} ?> >pail</option>
                                <option value="kg" <?php if($data['material']['satuan'] == 'kg') {echo 'selected';} ?> >kg</option>
                                <option value="meter" <?php if($data['material']['satuan'] == 'meter') {echo 'selected';} ?> >meter</option>
                                <option value="pack" <?php if($data['material']['satuan'] == 'pack') {echo 'selected';} ?> >pack</option>
                                <option value="box" <?php if($data['material']['satuan'] == 'box') {echo 'selected';} ?> >box</option>
                                <option value="roll" <?php if($data['material']['satuan'] == 'roll') {echo 'selected';} ?> >roll</option>
                                <option value="liter" <?php if($data['material']['satuan'] == 'liter') {echo 'selected';} ?> >liter</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga Material</label>
                            <input type="number" name="harga" id="harga" class="form-control" value="<?= $data['material']['harga'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="ket">Keterangan</label>
                            <input type="text" name="ket" id="ket" class="form-control" value="<?= $data['material']['keterangan'] ?>" required>
                        </div>
                        <br>
                        <div class="form-group text-right">
                            <input type="submit" name="update" value="Update" class="btn btn-info">
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