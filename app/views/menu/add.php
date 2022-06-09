<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Menu Management</h1>

    <div class="text-left">
        <a href="<?= BASEURL; ?>/menu/submenu" class="btn btn-warning btn-sm mb-3">
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
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Data Submenu</h6>
                </div>
                <div class="card-body">
                    <style>
                        form label:not(.form-check-label) {font-weight:bold;}
                    </style>
                    <div class="col-lg">
                    <form action="<?= BASEURL; ?>/menu/tambahSubmenu" method="post">
                        <div class="form-group">
                            <label for="title">Nama Submenu</label>
                            <input type="text" name="title" id="title" class="form-control" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="url">URL</label>
                            <input type="text" name="url" id="url" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="menu">Parent Menu</label>
                            <select name="menu" class="form-control" id="menu" required>
                            <?php foreach ( $data['datamenu'] as $menu ): ?>
                                <option value="<?= $menu['id_menu']; ?>"><?= $menu['nama_menu']; ?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="icon">Icon</label>
                            <input type="text" name="icon" id="icon" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="admin">Sidemenu ?</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sidemenu" id="ya" value=1 required> 
                                    <label class="form-check-label" for="ya">
                                        Ya
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sidemenu" id="tidak" value=0 required> 
                                    <label class="form-check-label" for="tidak">
                                        Tidak
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value=1>Aktif</option>
                                <option value=0>Tidak Aktif</option>
                            </select>
                        </div><br>
                        <div class="form-group text-right">
                            <a href="<?= BASEURL; ?>/menu/add" class="btn btn-secondary">Reset</a>
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