<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">User Management</h1>

    <div class="text-left">
        <a href="<?= BASEURL; ?>/user" class="btn btn-warning btn-sm mb-3">
            <span class="icon text-white-50">
                <i class="fas fa-angle-double-left"></i>
            </span>
            <span class="text">Kembali</span>
        </a>
    </div>

    <style>
        form label:not(.form-check-label) {
            font-weight: bold;
        }
    </style>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-0 shadow-lg">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Update Data User</h6>
                </div>
                <div class="card-body">
                    <form action="<?= BASEURL; ?>/user/updateData" method="post">
                        <div class="form-group">
                            <input type="hidden" name="id_user" value="<?= $data['datauser']['id_user']; ?>" class="form-control" id="id_user">
                        </div>
                        <div class="form-group">
                            <label for="namauser">Nama User</label>
                            <input type="text" name="namauser" id="namauser" class="form-control" value="<?= $data['datauser']['nama_user']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control" value="<?= $data['datauser']['username']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="<?= $data['datauser']['email']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="dept">Department</label>
                            <select name="dept" class="form-control" id="dept" required>
                                <?php foreach ($data['dept'] as $dept) : ?>
                                    <option value="<?= $dept['id_dept']; ?>" <?= $data['datauser']['id_dept'] == $dept['id_dept'] ? 'selected' : '' ?>><?= $dept['nama_dept']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="level">Level User</label>
                            <div>
                                <?php foreach ($data['datarole'] as $role) : ?>
                                    <?php if ($role['id_role'] != 1) { ?>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="role" id="<?= $role['role']; ?>" value="<?= $role['id_role']; ?>" <?= $data['datauser']['role'] == $role['id_role'] ? 'checked' : '' ?> required>
                                            <label class="form-check-label" for="<?= $role['role']; ?>">
                                                <?= $role['role']; ?>
                                            </label>
                                        </div>
                                    <?php } ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value=1 <?= $data['datauser']['status'] == 1 ? 'selected' : '' ?>>Aktif</option>
                                <option value=0 <?= $data['datauser']['status'] == 0 ? 'selected' : '' ?>>Tidak Aktif</option>
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
<!-- /.container-fluid -->

</div>