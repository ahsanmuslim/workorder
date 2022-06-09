<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">My Profile</h1>

    <div class="text-left">
        <a href="<?= BASEURL; ?>/profile" class="btn btn-warning btn-sm mb-3">
            <span class="icon text-white-50">
                <i class="fas fa-angle-double-left"></i>
            </span>
            <span class="text">Kembali</span>
        </a>
    </div>

    <style>
        form label:not(.form-check-label) {font-weight:bold;}
    </style>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-0 shadow-lg">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Update Profile</h6>
                </div>
                <div class="card-body">
                    <form action="<?= BASEURL; ?>/profile/updateProfile" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="hidden" name="id_user" value="<?= $data['datauser']['id_user']; ?>" class="form-control" id="id_user">
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control" value="<?= $data['datauser']['username']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="namauser">Nama User</label>
                            <input type="text" name="namauser" id="namauser" class="form-control" value="<?= $data['datauser']['nama_user']; ?>" required pattern="^[a-zA-Z ]*$" onkeyup="checkNama();">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="<?= $data['datauser']['email']; ?>" required onkeyup="checkEmail();" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" >
                        </div>
                        <div class="form-group">
                            <label for="no_telp">No telepon</label>
                            <input type="text" name="no_telp" id="no_telp" class="form-control" value="<?= $data['datauser']['no_telp']; ?>" required pattern="[0]{1}[8]{1}[0-9]{8,10}" onkeyup="checkTelp();">
                        </div>
                        <div class="form-group">
                            <label for="no_telp">Foto profile</label>
                            <div class="col-lg-4">
                                <img src="<?= BASEURL; ?>/img/profile/<?= $data['datauser']['profile']; ?>" class="img-thumbnail mb-3 rounded-circle" alt="<?= $data['datauser']['profile']; ?>">
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="profile" name="profile">
                                <label class="custom-file-label" for="profile">Pilih file</label>
                            </div>
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
<!-- /.container-fluid -->

</div>

<script type="text/javascript">

function checkNama()
{
    var regEmail = new RegExp("^<div a-zA-Z=""></div>");
    var nama = document.getElementById('namauser');

    var good_color = "#D0F8FF";
    var bad_color  = "#FFD0C6";

    if( regEmail.test(nama.value) ){
        nama.style.backgroundColor = good_color;
    }else{
        nama.style.backgroundColor = bad_color;
    }
}

function checkEmail()
{
    var regEmail = new RegExp("[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$");
    var email = document.getElementById('email');

    var good_color = "#D0F8FF";
    var bad_color  = "#FFD0C6";

    if( regEmail.test(email.value) ){
        email.style.backgroundColor = good_color;
    }else{
        email.style.backgroundColor = bad_color;
    }
}

function checkTelp()
{
    var regTelp = new RegExp("[0]{1}[8]{1}[0-9]{9,10}");
    var no_telp  = document.getElementById('no_telp');

    var good_color = "#D0F8FF";
    var bad_color  = "#FFD0C6";

    if( regTelp.test(no_telp.value) ){
        no_telp.style.backgroundColor = good_color;
    }else{
        no_telp.style.backgroundColor = bad_color;
    }
}

</script>