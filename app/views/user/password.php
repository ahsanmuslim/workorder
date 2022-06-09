<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Change Password</h1>

    <div class="text-left">
        <a href="<?= BASEURL; ?>/profile" class="btn btn-warning btn-sm mb-3">
            <span class="icon text-white-50">
                <i class="fas fa-angle-double-left"></i>
            </span>
            <span class="text">Kembali</span>
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-0 shadow-lg">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Update password</h6>
                </div>
                <div class="card-body">
                    <style>
                        form label:not(.form-check-label) {font-weight:bold;}
                    </style>
                    <div class="col-lg">
                        <?php Flasher::flash(); ?>
                    </div>
                    <form action="<?= BASEURL; ?>/profile/updatePassword" method="post">
                        <div class="form-group">
                            <input type="hidden" name="id_user" value="<?= $data['user']['id_user']; ?>" class="form-control" id="id_user">
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" value="<?= $data['user']['username']; ?>" class="form-control" id="username" readonly>
                        </div>
                        <div class="form-group">
                            <label for="passwordlama">Password lama</label>
                            <input type="password" name="passwordlama" id="passwordlama" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="passwordbaru">Password baru</label>
                            <input type="password" name="passwordbaru" id="passwordbaru" class="form-control" pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[@#$%^&+=])(?=\S+$).{6,}$"  placeholder="Harus ada huruf, angka & spesial karakter !" required>
                        </div>
                        <div class="form-group">
                            <label for="konfirmpassword">Konfirmasi password baru</label>
                            <input type="password" name="konfirmpassword" id="konfirmpassword" class="form-control" pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[@#$%^&+=])(?=\S+$).{6,}$"  placeholder="Ulangi password di atas !" onkeyup="checkPass();" required>
                        </div>
                        <br>
                        <div class="form-group text-right">
                            <input type="submit" name="update" value="Update Password" class="btn btn-success">
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

function checkPass()
{
    //Store the password field objects into variables ...
    var password = document.getElementById('passwordbaru');
    var confirm  = document.getElementById('konfirmpassword');

    //Set the colors we will be using ...
    var good_color = "#D0F8FF";
    var bad_color  = "#FFD0C6";
    //Compare the values in the password field 
    //and the confirmation field
    if(password.value == confirm.value){
        //The passwords match. 
        //Set the color to the good color and inform
        confirm.style.backgroundColor = good_color;
    }else{
        //The passwords do not match.
        //Set the color to the bad color and
        confirm.style.backgroundColor = bad_color;
    }
} 

</script>