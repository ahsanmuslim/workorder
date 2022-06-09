<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Kas Keluar</h1>

    <div class="text-left">
        <a href="<?= BASEURL; ?>/kaskeluar" class="btn btn-warning btn-sm mb-3">
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
                    <h6 class="m-0 font-weight-bold text-primary">Update Pengajuan Kas / Dana</h6>
                </div>
                <div class="card-body">
                    <style>
                        form label:not(.form-check-label) {font-weight:bold;}
                    </style>
                    <div class="col-lg">
                    <form action="<?= BASEURL; ?>/kaskeluar/updatekaskeluar" method="post">
                        <div class="form-group">
                            <label for="id_wo">Work Order</label>
                            <input type="hidden" name="id" id="id" class="form-control" value="<?= $data['kaskeluar']['id_dana'] ?>">
                            <select name="id_wo" class="form-control" id="id_wo" readonly>
                                <option value="<?= $data['kaskeluar']['id_wo']; ?>"><?= $data['kaskeluar']['id_wo'].' ';  ?><?= $data['kaskeluar']['nama_wo'];  ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal Pengajuan</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?= $data['kaskeluar']['tgl_pengajuan']?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah Pengajuan</label>
                            <input type="number" name="jumlah" id="jumlah" class="form-control" value="<?= $data['kaskeluar']['jml_pengajuan']?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="tgl_terima">Tanggal Terima</label>
                            <input type="date" name="tgl_terima" id="tgl_terima" class="form-control" value="<?=date('Y-m-d')?>"  readonly>
                        </div>
                        <div class="form-group">
                            <label for="pic">PIC Terima</label>
                            <input type="text" name="pic" id="pic" class="form-control" required>
                        </div>
                        <!--  -->
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