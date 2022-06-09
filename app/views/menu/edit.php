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
                    <h6 class="m-0 font-weight-bold text-primary">Update Data Submenu</h6>
                </div>
                <div class="card-body">
                    <style>
                        form label:not(.form-check-label) {
                            font-weight: bold;
                        }
                    </style>
                    <div class="col-lg">
                        <form action="<?= BASEURL; ?>/menu/updateSubmenu" method="post">
                            <div class="form-group">
                                <label for="title">Nama Submenu</label>
                                <input type="hidden" name="id_submenu" class="form-control" value="<?= $data['submenu']['id_submenu']; ?>">
                                <input type="text" name="title" id="title" class="form-control" value="<?= $data['submenu']['title']; ?>" required readonly>
                            </div>
                            <div class="form-group">
                                <label for="url">URL</label>
                                <input type="text" name="url" id="url" class="form-control" value="<?= $data['submenu']['url']; ?>" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="menu">Parent Menu</label>
                                <select name="menu" class="form-control" id="menu" required>
                                    <?php foreach ($data['datamenu'] as $menu) :
                                        if ($data['submenu']['id_menu'] == $menu['id_menu']) { ?>
                                            <option value="<?= $menu['id_menu']; ?>" <?= 'selected' ?>><?= $menu['nama_menu']; ?></option>
                                        <?php } else { ?>
                                            <option value="<?= $menu['id_menu']; ?>"><?= $menu['nama_menu']; ?></option>
                                        <?php } ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="icon">Icon</label>
                                <input type="text" name="icon" id="icon" class="form-control" value="<?= $data['submenu']['icon']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="sidemenu">Is Sidemenu ?</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="sidemenu" id="ya" value=1 <?= $data['submenu']['is_sidemenu'] == 1 ? 'checked' : '' ?> required>
                                        <label class="form-check-label" for="ya">
                                            Ya
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="sidemenu" id="tidak" value=0 <?= $data['submenu']['is_sidemenu'] == 0 ? 'checked' : '' ?> required>
                                        <label class="form-check-label" for="tidak">
                                            Tidak
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value=1 <?= $data['submenu']['is_active'] == 1 ? 'selected' : '' ?>>Aktif</option>
                                    <option value=0 <?= $data['submenu']['is_active'] == 0 ? 'selected' : '' ?>>Tidak Aktif</option>
                                </select>
                            </div><br>
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