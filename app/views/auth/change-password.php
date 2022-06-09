<!-- <body class="bg-gradient-primary"> -->
<style type="text/css">
  .background-image {
    /*background: url(<?= BASEURL; ?>/img/beanstalk.png);*/
    background: url(<?= BASEURL; ?>/img/background/cnc.jpg);
    background-size:cover;
    background-attachment: fixed;
    background-position: center;
  }
</style>  
<body class="background-image">

    <div class="container">

        <!-- Outer Row -->
        <div style="margin-top:60px;" class="row justify-content-center">

        <!-- <div class="col-xl-10 col-lg-12 col-md-9"> -->
        <div class="col-xl-6 col-lg-6 col-md-6">  

            <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                <!-- <div class="col-lg-6 d-none d-lg-block bg-change-image"></div> -->
                <div class="col-lg-12">
                    <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900">Reset password</h1>
                        <p class="mb-3"><?= $data['user']['nama_user']; ?> ( <?= $data['user']['username']; ?> )</p>
                    </div>
                    <hr>
                    <form action="<?= BASEURL; ?>/auth/gantiPassword" method="post" class="user">
                        <div class="form-group">
                            <?php Flasher::forgotFlash(); ?>
                            <input type="hidden" name="id_user" class="form-control form-control-user" value="<?= $data['user']['id_user']; ?>" >
                            <input type="email" name="email" class="form-control form-control-user" value="<?= $data['user']['email']; ?>" readonly >
                        </div>
                        <div class="form-group">
                            <input type="password" name="passwordbaru" id="passwordbaru" class="form-control form-control-user" placeholder="Masukan password baru" required pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[@#$%^&+=])(?=\S+$).{6,}$" >
                        </div>
                        <div class="form-group">
                            <input type="password" name="konfirmpassword" id="konfirmpassword" class="form-control form-control-user" placeholder="Ulangi password di atas" required pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[@#$%^&+=])(?=\S+$).{6,}$" onkeyup="checkPass();" >
                        </div>
                        <hr>
                        <input type="submit" name="change" value="Change Password" class="btn btn-primary btn-user btn-block">
                    </form>
                    </div>
                </div>
                </div>
            </div>
            </div>

        </div>

        </div>

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
