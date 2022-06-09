<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-3 text-gray-800">Reporting Work Order</h1>

    <div class="row">
        <div class="col-lg-6">
            <div class="card mb-0 shadow">
                <div class="card-body">
                    <style>
                        label:not(.form-check-label) {font-weight:bold;}
                    </style>
                    <div class="col-lg">
                        <div class="form-group">
                            <label for="jenisreport" class="col-sm col-form-label">Pilih report</label>
                            <div class="col-sm">
                                <select name="jenisreport" class="form-control" id="jenisreport" required>                             
                                    <option value=0>Report A</option>
                                    <option value=0>Report B</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tglmulai" class="col-sm col-form-label">Dari tanggal</label>
                            <div class="col-sm">
                                <input type="date" class="form-control" name="tglmulai" id="tglmulai" value="<?=date('Y-m-d')?>" required>
                            </div>
                            <label for="tglakhir" class="col-sm col-form-label">Sampai tanggal</label>
                            <div class="col-sm">
                                <input type="date" class="form-control" name="tglakhir" id="tglakhir" value="<?=date('Y-m-d')?>" required>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <input type="submit" name="import" value="Import Data" class="btn btn-info">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>