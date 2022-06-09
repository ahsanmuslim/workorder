<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Update Pembelian</h1>

    <div class="text-left">
        <a href="<?= BASEURL; ?>/pembelian" class="btn btn-warning btn-sm mb-3">
            <span class="icon text-white-50">
                <i class="fas fa-angle-double-left"></i>
            </span>
            <span class="text">Kembali</span>
        </a>
    </div>
    <style>
        label:not(.form-check-label) {font-weight:bold;}
    </style>

<!-- //row untuk tambah pembelian -->
<form action="<?= BASEURL; ?>/pembelian/updatePembelian" method="post">
    <div class="row mb-3">
        <div class="col-lg-5">
            <div class="card mb-2 shadow">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="tanggal" class="col-sm-4 col-form-label">Tanggal</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= $data['beli']['tgl_pembelian'] ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="id_wo" class="col-sm-4 col-form-label">ID WO</label>
                        <div class="col-sm-8">
                            <select name="id_wo" class="form-control" id="id_wo" readonly>
                                <option value="<?= $data['beli']['id_wo'] ?>"><?= $data['beli']['nama_wo'] ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="supplier" class="col-sm-4 col-form-label">Supplier</label>
                        <div class="col-sm-8">
                            <select name="supplier" class="form-control" id="supplier" required>
                                <option value=""></option>
                                <?php foreach ( $data['supplier'] as $sp ): ?>
                                <option value="<?= $sp['id_supplier']; ?>" <?php if( $data['beli']['id_supplier'] == $sp['id_supplier'] ) { echo 'selected';} ?> ><?= $sp['nama_supplier'];  ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-2 shadow height=300px">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="material" class="col-sm-3 col-form-label">Material</label>
                        <div class="col-sm-9">
                            <select name="material" class="form-control beli-material" id="beli-material" required>
                            <?php foreach ( $data['material'] as $mat ): ?>
                                <option value="<?= $mat['id_material']; ?>"><?= $mat['nama_material'];  ?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="harga-total" class="col-sm-3 col-form-label">Total</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="harga-total" id="harga-total" value=0 required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Qty.</label>
                        <div class="col-sm-5">
                            <input type="number" class="form-control" name="jumlah-beli" id="jumlah-beli" value=1 required>
                        </div>
                        <div class="col-sm-4">
                            <button type="button" name="add" class="btn btn-info btn-sm add-material" id="add-material"><i class="fas fa-fw fa-cart-plus"></i>Tambah</button>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card mb-2 shadow">
                <div class="card-body">
                    <div class="form-group row">
                        <h5 class="ml-auto">Invoice <b><span><?= $data['beli']['id_pembelian'] ?></span></b></h5>
                        <input type="hidden" name="id_pembelian" value="<?= $data['beli']['id_pembelian'] ?>">
                    </div>
                    <div class="form-group row">
                        <h1 class="ml-auto"><b><span id="grandtotal" class="text-primary grandtotal" style="font-size:50px"><?= $data['beli']['total'] ?></span></b></h1>
                        <input type="hidden" name="grandtotal" class="grandtotal" value="<?= $data['beli']['total'] ?>">           
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- //row untuk detail rincian material -->
    <div class="row">
        <div class="col-lg">
            <div class="card mb-4 shadow">
                <div class="card-body">
                    <input type="hidden" name="jmldata" id="jmldata" value="<?= count($data['detailBeli']) ?>">
                    <div class="table-responsive">
                        <table class="table" id="tbl-pembelian">
                            <thead class="thead-light">
                            <style>
                                th.judul , td.judul {text-align: center;}
                                th.total {text-align: right;}
                            </style>
                                <tr>
                                    <th width="100px">Code</th>
                                    <th>Nama Material</th>
                                    <th width="80px">Qty</th>
                                    <th>Satuan</th>
                                    <th width="150px">Harga</th>
                                    <th width="150px">Subtotal</th>
                                    <th class="judul" width="40px"><i class="fas fa-cog"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            $no = count($data['detailBeli']);
                            for ( $i=0 ; $i < $no ; $i++ ){ ?>
                                <tr  id="row<?= $i+1 ?>">
                                    <td><input size="10" style="border:0;outline:0" name="id_material[]" value="<?= $data['detailBeli'][$i]['id_material'] ?>" readonly></td>
                                    <td><?= $data['detailBeli'][$i]['nama_material'] ?></td>
                                    <td><input size="10" style="border:0;outline:0" name="qty[]" value="<?= $data['detailBeli'][$i]['jumlah'] ?>" readonly></td>
                                    <td><?= $data['detailBeli'][$i]['satuan'] ?></td>
                                    <td><input size="10" style="border:0;outline:0" name="harga[]" value="<?= $data['detailBeli'][$i]['harga'] ?>" readonly></td>
                                    <td>
                                        <input size="10" style="border:0;outline:0" name="total-beli[]" class="subtotal-beli" value="<?= $data['detailBeli'][$i]['harga']*$data['detailBeli'][$i]['jumlah'] ?>" readonly>
                                    </td>
                                    <td><button type="button" name="hapus" id="<?= $i+1 ?>" class="btn btn-danger btn-sm btn_remove"><i class="fas fa-fw fa-trash"></i></button></td>           
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group text-center">
        <input type="submit" name="Update" value="Update Pembelian" class="btn btn-info">
    </div>
</form>


</div>
<!-- /.container-fluid -->

</div>

