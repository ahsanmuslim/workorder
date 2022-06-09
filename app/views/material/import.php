<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Import material</h1>
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
                <div class="card-body">
                    <style>
                        form label:not(.form-check-label) {font-weight:bold;}
                    </style>
                    <div class="col-lg">
                    <form action="<?= BASEURL; ?>/material/importdata" method="post"  enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="file_import">Pilih file yang akan diimport</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="file_import" name="file_import" required> 
                                <label class="custom-file-label" for="file_import">Format file harus .xlsx</label>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <!-- <a href="<?= BASEURL; ?>/file/sample/sample.xlsx" class="btn btn-danger mr-2"> -->
                            <a href="<?= BASEURL; ?>/material/download" class="btn btn-danger mr-2">
                                <span class="icon text-white-50">
                                    <i class="fas fa-file-download"></i>
                                </span>
                                <span class="text">Sample File Excel</span>                            
                            </a>
                            <input type="submit" name="import" value="Import Data" class="btn btn-info">
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