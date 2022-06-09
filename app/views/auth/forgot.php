<!-- <body class="bg-gradient-primary"> -->
<style type="text/css">
  .background-image {
    /*background: url(<?= BASEURL; ?>/img/beanstalk.png);*/
    background: url(<?= BASEURL; ?>/img/background/milling-rotation.jpg);
    background-size:cover;
    background-attachment: fixed;
    background-position: center;
  }
</style>  
<body class="background-image">

  <div class="container">

    <!-- Outer Row -->
    <div style="margin-top:60px;" class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-2">Help Page</h1>
                    <p class="mb-4"><small>Masukan email Anda !!<br> Sistem akan mengirimkan link untuk me-reset password</small></p>
                  </div>
                  <hr>
                  <form action="<?= BASEURL; ?>/auth/reset" method="post" class="user">
                    <div class="form-group">
                      <?php Flasher::forgotFlash(); ?>
                      <input type="email" name="email" class="form-control form-control-user" placeholder="Masukan email Anda..." required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" >
                    </div>
                    <hr>
                    <input type="submit" name="reset" value="Reset Password" class="btn btn-primary btn-user btn-block">
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="<?= BASEURL; ?>/auth/registrasi">Buat Account Baru ?</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="<?= BASEURL; ?>/auth/index">Sudah punya Account ? Masuk !</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>
