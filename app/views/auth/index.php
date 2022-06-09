<!-- <body class="bg-gradient-primary"> -->
<style type="text/css">
  .background-image {
    /*background: url(<?= BASEURL; ?>/img/beanstalk.png);*/
    background: url(<?= BASEURL; ?>/img/background/tools.jpg);
    background-size:cover;
    background-attachment: fixed;
    background-position: center;
  }
</style>  
<body class="background-image">

  <div class="container">

    <!-- Outer Row -->
    <div align="center" style="margin-top:60px;" class="row justify-content-center">

      <!-- <div class="col-xl-10 col-lg-12 col-md-9"> -->
      <div class="col-xl-6 col-lg-6 col-md-6">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
<!--          <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> -->
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Login Page</h1>
                  </div>
                  <div class="row mt-2">
                    <div class="col-lg"> 
                        <?php Flasher::loginFailed(); ?>
                    </div>      
                </div>
                  <hr>
                  <form action="<?= BASEURL; ?>/auth/cekLogin" method="post" class="user">
                    <div class="form-group">
                      <input type="text" name="user" class="form-control form-control-user" id="user" placeholder="Username" required>
                    </div>
                    <div class="form-group">
                      <input type="password" name="pass" class="form-control form-control-user" id="pass" placeholder="Password" required>
                    </div>
                    <hr>
                    <input type="submit" name="login" value="Masuk" class="btn btn-primary btn-user btn-block">
                    <hr>
                  </form>
                  <div class="text-center">
                    <a class="small" href="<?= BASEURL; ?>/auth/registrasi">Buat Account Baru ?</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="<?= BASEURL; ?>/auth/forgotPassword">Lupa Password ?</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

