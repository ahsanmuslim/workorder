<?php

//script untuk cek user role
$id_role = $data['role']['id_role'];

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Role Management</h1>

    <div class="text-left">
        <a href="<?= BASEURL; ?>/role" class="btn btn-warning btn-sm mb-3">
            <span class="icon text-white-50">
                <i class="fas fa-angle-double-left"></i>
            </span>
            <span class="text">Kembali</span>
        </a>
    </div>

    <div class="card mb-2 shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Role Access : <?= $data['role']['role']; ?></h6>
        </div>
        <div class="card-body">
            <style>
                th.judul,
                td.judul {
                    text-align: center;
                }
            </style>
            <form name="form_akses" method="post">
                <input type="hidden" name="id_role" value="<?= $data['role']['id_role']; ?>" class="form-control" required>
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-hover" id="tblrole">
                            <thead class="thead-light">
                                <tr>
                                    <th class="judul">#</th>
                                    <th>Submenu</th>
                                    <th>Controller</th>
                                    <th class="judul">Akses</th>
                                    <th class="judul">Create</th>
                                    <th class="judul">Update</th>
                                    <th class="judul">Delete</th>
                                    <th class="judul">Print</th>
                                </tr>
                            </thead>
                            <?php $no = 1;
                            foreach ($data['activeMenu'] as $menu) : ?>
                                <tr>
                                    <?php
                                    $controller = $menu['url'];
                                    $ceklist = "";
                                    if ($this->models('role_model')->countAccess($id_role, $controller) > 0) {
                                        $ceklist = "checked";
                                    }
                                    ?>
                                    <td class="judul"><?= $no++; ?></td>
                                    <td><?= $menu['title']; ?></td>
                                    <td><?= $menu['url']; ?></td>
                                    <td class="judul">
                                        <input type="checkbox" name="ceklist[]" value="<?= $menu['id_submenu'] ?>" class="check" <?= $ceklist; ?>>
                                    </td>

                                    <!-- Script kondisi untuk Create kolom -->
                                    <?php
                                    $cekCreate = '';
                                    $cekUpdate = '';
                                    $cekDelete = '';
                                    $cekPrint = '';
                                    if ($this->models('role_model')->countCreate($id_role, $controller) > 0) {
                                        $cekCreate = 'checked';
                                    }
                                    if ($this->models('role_model')->countUpdate($id_role, $controller) > 0) {
                                        $cekUpdate = 'checked';
                                    }
                                    if ($this->models('role_model')->countDelete($id_role, $controller) > 0) {
                                        $cekDelete = 'checked';
                                    }
                                    if ($this->models('role_model')->countPrint($id_role, $controller) > 0) {
                                        $cekPrint = 'checked';
                                    }
                                    ?>
                                    <td class="judul">
                                        <input type="checkbox" name="createlist[]" value="<?= $menu['id_submenu'] ?>" class="createlist" <?= $cekCreate  ?>>
                                    </td>

                                    <!-- Script kondisi untuk Update kolom -->
                                    <td class="judul">
                                        <input type="checkbox" name="updatelist[]" value="<?= $menu['id_submenu'] ?>" class="updatelist" <?= $cekUpdate  ?>>
                                    </td>

                                    <!-- Script kondisi untuk Delete kolom -->
                                    <td class="judul">
                                        <input type="checkbox" name="deletelist[]" value="<?= $menu['id_submenu'] ?>" class="deletelist" <?= $cekDelete  ?>>
                                    </td>

                                    <!-- Script kondisi untuk print kolom -->
                                    <td class="judul">
                                        <input type="checkbox" name="printlist[]" value="<?= $menu['id_submenu'] ?>" class="printlist" <?= $cekPrint  ?>>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group text-center">
                        <input type="submit" name="editaccess" value="Update Access" onclick="editAkses()" class="btn btn-danger">
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>


<!-- scrip javascript untuk menjalankan validasi check box role akses  -->
<script>
    function editAkses() {

        if ($('.check:checked').length > 0) {
            document.form_akses.action = '<?= BASEURL; ?>/role/updateAkses';
            document.form_akses.submit();
        } else {
            // alert('Pilih dulu Data yang akan Anda UPDATE !!');
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Pilih MINIMAL 1 Role Access !!'
            })
        }

    }
</script>