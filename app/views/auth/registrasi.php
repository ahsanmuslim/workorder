<!-- <body class="bg-gradient-primary"> -->
<style type="text/css">
  .background-image {
    /*background: url(<?= BASEURL; ?>/img/beanstalk.png);*/
    background: url(<?= BASEURL; ?>/img/background/drilling.jpg);
    background-size:cover;
    background-attachment: fixed;
    background-position: center;
  }
</style>  
<body class="background-image">

  <div class="container">
  <div class="row h-100 justify-content-center align-items-center">

 <!-- <div class="col-xl-10 col-lg-12 col-md-9"> -->
  <div class="col-xl-8 col-lg-8 col-md-8">

    <div  class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <!-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> -->
          <div class="col-lg-12">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-2">Registration Page</h1>
              </div>
              <!-- //manipulasi style form input -->
              <style type="text/css">
                .selectWrapper{
                  border-radius: 10rem;
                  font-size: 0.8rem;
                  height: 3rem;  
                }
                .selectBox{
                  width:140px;
                  height:40px;
                  border:0px;
                  outline:none;
                }
              </style>
              <hr>
              <form action="<?= BASEURL; ?>/auth/userRegistration" method="post" class=" user needs-validation" novalidate>
                <?php
                use Ramsey\Uuid\Uuid;
                $uuid = Uuid::uuid4()->toString();
                ?>
                <div class="form-group">
                  <?php Flasher::registFlash(); ?>
                  <input type="hidden" name="id_user" value="<?= $uuid; ?>" class="form-control">
                  <input type="text" name="namauser" class="form-control form-control-user" placeholder="Nama Lengkap" required maxLength="50" minLength="3" pattern="^[a-zA-Z ]*$">
                  <div class="valid-feedback ml-2">Looks good!</div>
                  <div class="invalid-feedback ml-2"> 
                  Panjang karakter : 6 ~ 50 & menggunakan huruf semua !!
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" name="username" class="form-control form-control-user" placeholder="Username" required maxLength="10" minLength="3" pattern="^[a-z0-9_.-]*$">
                    <div class="valid-feedback ml-2">Looks good!</div>
                    <div class="invalid-feedback ml-2"> 
                    Gunakan kombinasi huruf kecil & angka !!
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <input type="tel" name="no_telp" class="form-control form-control-user" placeholder="No Telp" required pattern="[0]{1}[8]{1}[0-9]{9,10}">
                    <div class="valid-feedback ml-2">Looks good!</div>
                    <div class="invalid-feedback ml-2"> 
                    Nomor telepon tidak valid !!
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <input type="email" name="email" class="form-control form-control-user" placeholder="Alamat Email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" >
                  <div class="valid-feedback ml-2">Looks good!</div>
                  <div class="invalid-feedback ml-2"> 
                  Email tidak valid !!
                  </div>
                </div>
                <div class="form-group">
                  <select name="dept" class="form-control selectWrapper" id="dept" required>
                  <?php foreach ( $data['dept'] as $dept ): ?>
                      <option class="selectBox" value="<?= $dept['id_dept']; ?>"><?= $dept['nama_dept'];  ?></option>
                  <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" name="password1" id="password1"  class="form-control form-control-user" placeholder="Password" required pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[@#$%^&+=])(?=\S+$).{6,}$">
                    <div class="valid-feedback ml-2">Looks good!</div>
                    <div class="invalid-feedback ml-2"> 
                    Gunakan huruf, angka & spesial (min 6 karakter)<br>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <input type="password" name="password2" id="password2" class="form-control form-control-user" placeholder="Ulangi Password" required pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[@#$%^&+=])(?=\S+$).{6,}$" onkeyup="checkPass();">
                    <div class="valid-feedback ml-2" id="correct-message"></div>
                    <div class="invalid-feedback ml-2" id="wrong-message">Password tidak sama !</div>
                  </div>
                </div>
                <hr>
                <input type="submit" name="registrasi" value="Registrasi Account" class="btn btn-primary btn-user btn-block">
              </form>
              <hr>
              <div class="text-center">
                <a class="small" href="<?= BASEURL; ?>/auth">Sudah punya Account ? Masuk !</a>
              </div>
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
      var password = document.getElementById('password1');
      var confirm  = document.getElementById('password2');
      //Store the Confirmation Message Object ...
      var message1 = document.getElementById('correct-message');
      var message2 = document.getElementById('wrong-message');
      //Set the colors we will be using ...
      var good_color = "#D0F8FF";
      var bad_color  = "#FFD0C6";
      //Compare the values in the password field 
      //and the confirmation field
      if(password.value == confirm.value){
          //The passwords match. 
          //Set the color to the good color and inform
          //the user that they have entered the correct password 
          confirm.style.backgroundColor = good_color;
          message1.innerHTML             = 'Looks good !';
      }else{
          //The passwords do not match.
          //Set the color to the bad color and
          //notify the user.
          confirm.style.backgroundColor = bad_color;
          message2.innerHTML             = 'Password tidak sama !';
      }
  } 

    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
        });
    }, false);
    })();

</script>