<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>WO Monitoring - <?= $data['title'] ?></title>

  <link rel="icon" type="image/png" href="<?= BASEURL; ?>/img/icon.png">

  <!-- Custom fonts for this template-->
  <link href="<?= BASEURL; ?>/vendor/fortawesome/font-awesome/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="<?= BASEURL; ?>/css/font-google.min.css" rel="stylesheet" type="text/css">
  <!-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,
  800,800i,900,900i" rel="stylesheet"> -->

  <!-- Custom styles for this template-->
  <link href="<?= BASEURL; ?>/css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Sweet alert styles -->
  <link href="<?= BASEURL; ?>/css/sweetalert2.min.css" rel="stylesheet">

  <!-- select2 -->
  <link href="<?= BASEURL; ?>/css/select2.min.css" rel="stylesheet">

  <!-- chat -->
  <link href="<?= BASEURL; ?>/css/chat.min.css" rel="stylesheet">

  <!-- //link untuk memanggil Datatables -->
  <link href="<?= BASEURL; ?>/libs/DataTables/datatables.min.css" rel="stylesheet">


  <!-- Script for Chart js-->
  <link href="<?= BASEURL; ?>/css/Chart.min.css">
  <script type="text/javascript" src="<?= BASEURL; ?>/js/Chart.min.js"></script>
  <script src="<?= BASEURL; ?>/js/popper.min.js"></script>
  <script src="<?= BASEURL; ?>/js/apexcharts.min.js"></script>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= BASEURL; ?>/auth">
        <div class="sidebar-brand-icon">
          <i class="fas fa-laptop-code"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Workshop</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <?php
      //looping data notif 
      $notifwo = 0;
      $notifhandover = 0;
      foreach ($data['notif'] as $notif) {
        if ($notif['link'] == 'workorder') {
          $notifwo++;
        }
        if ($notif['link'] == 'serahterima') {
          $notifhandover++;
        }
      }

      // var_dump($notifhandover);

      foreach ($data['menu'] as $menu) : ?>
        <!-- Heading -->
        <div class="sidebar-heading">
          <?= $menu['nama_menu']; ?>
        </div>

        <?php
        $id_menu = $menu['id_menu'];
        $data['submenu'] = $this->models('menu_model')->submenuActive($id_menu);

        $jml = count($data['submenu']);

        if ($jml == 1) {
          if ($data['title'] == $data['submenu'][0]['title']) { ?>
            <li class="nav-item active">
              <a class="nav-link pb-0 text-warning" href="<?= BASEURL; ?>/<?= $data['submenu'][0]['url']; ?>">
                <i class="<?= $data['submenu'][0]['icon']; ?> text-warning"></i>
                <?php
                if($data['submenu'][0]['title'] == 'Work Order' && $notifwo != 0){ ?>
                  <span class="badge badge-danger badge-samping" data-toggle="tooltip" title="Ada <?= $notifwo ?> Work Order yang harus di Approve"><?= $notifwo ?></span>
                <?php } elseif ($data['submenu'][0]['title'] == 'Handover' && $notifhandover != 0){ ?>
                  <span class="badge badge-danger badge-samping" data-toggle="tooltip" title="Ada <?= $notifhandover ?> Work Order dalam status Handover"><?= $notifhandover ?></span>
                <?php } ?>
                <span><?= $data['submenu'][0]['title']; ?></span></a>
            </li>
          <?php } else { ?>
            <li class="nav-item">
              <a class="nav-link pb-0" href="<?= BASEURL; ?>/<?= $data['submenu'][0]['url'] ?>">
                <i class="<?= $data['submenu'][0]['icon'] ?>"></i>
                <!--menampilkan counter badge -->
                <?php
                if($data['submenu'][0]['title'] == 'Work Order' && $notifwo != 0){ ?>
                  <span class="badge badge-danger badge-samping" data-toggle="tooltip" title="Ada <?= $notifwo ?> Work Order yang harus di Approve"><?= $notifwo ?></span>
                <?php } elseif ($data['submenu'][0]['title'] == 'Handover' && $notifhandover != 0){ ?>
                  <span class="badge badge-danger badge-samping" data-toggle="tooltip" title="Ada <?= $notifhandover ?> Work Order dalam status Handover"><?= $notifhandover ?></span>
                <?php } ?>
                <span><?= $data['submenu'][0]['title'] ?></span></a>
            </li>
            <?php
          }
        } else {
          for ($i = 0; $i < $jml; $i++) {
            if ($i == 0) {
              if ($data['title'] == $data['submenu'][$i]['title']) { ?>
                <li class="nav-item active">
                  <a class="nav-link pb-0 text-warning" href="<?= BASEURL; ?>/<?= $data['submenu'][$i]['url']; ?>">
                    <i class="<?= $data['submenu'][$i]['icon']; ?> text-warning"></i>
                      <!--menampilkan counter badge -->
                      <?php
                      if($data['submenu'][$i]['title'] == 'Work Order' && $notifwo != 0){ ?>
                        <span class="badge badge-danger badge-samping" data-toggle="tooltip" title="Ada <?= $notifwo ?> Work Order yang harus di Approve"><?= $notifwo ?></span>
                      <?php } elseif ($data['submenu'][$i]['title'] == 'Handover' && $notifhandover != 0){ ?>
                        <span class="badge badge-danger badge-samping" data-toggle="tooltip" title="Ada <?= $notifhandover ?> Work Order dalam status Handover"><?= $notifhandover ?></span>
                      <?php } ?>
                    <span><?= $data['submenu'][$i]['title']; ?></span></a>
                </li>
              <?php } else { ?>
                <li class="nav-item">
                  <a class="nav-link pb-0" href="<?= BASEURL; ?>/<?= $data['submenu'][$i]['url'] ?>">
                    <i class="<?= $data['submenu'][$i]['icon'] ?>"></i>
                      <!--menampilkan counter badge -->
                      <?php
                      if($data['submenu'][$i]['title'] == 'Work Order' && $notifwo != 0){ ?>
                        <span class="badge badge-danger badge-samping" data-toggle="tooltip" title="Ada <?= $notifwo ?> Work Order yang harus di Approve"><?= $notifwo ?></span>
                      <?php } elseif ($data['submenu'][$i]['title'] == 'Handover' && $notifhandover != 0){ ?>
                        <span class="badge badge-danger badge-samping" data-toggle="tooltip" title="Ada <?= $notifhandover ?> Work Order dalam status Handover"><?= $notifhandover ?></span>
                      <?php } ?>
                    <span><?= $data['submenu'][$i]['title'] ?></span></a>
                </li>
                <?php }
            } else {
              if ($data['submenu'][$i - 1]['title'] != $data['submenu'][$i]['title']) {
                if ($data['title'] == $data['submenu'][$i]['title']) { ?>
                  <li class="nav-item active">
                    <a class="nav-link pb-0 text-warning" href="<?= BASEURL; ?>/<?= $data['submenu'][$i]['url']; ?>">
                      <i class="<?= $data['submenu'][$i]['icon']; ?> text-warning"></i>
                      <!--menampilkan counter badge -->
                      <?php
                      if($data['submenu'][$i]['title'] == 'Work Order' && $notifwo != 0){ ?>
                        <span class="badge badge-danger badge-samping" data-toggle="tooltip" title="Ada <?= $notifwo ?> Work Order yang harus di Approve"><?= $notifwo ?></span>
                      <?php } elseif ($data['submenu'][$i]['title'] == 'Handover' && $notifhandover != 0){ ?>
                        <span class="badge badge-danger badge-samping" data-toggle="tooltip" title="Ada <?= $notifhandover ?> Work Order dalam status Handover"><?= $notifhandover ?></span>
                      <?php } ?>
                      <span><?= $data['submenu'][$i]['title']; ?></span></a>
                  </li>
                <?php } else { ?>
                  <li class="nav-item">
                    <a class="nav-link pb-0" href="<?= BASEURL; ?>/<?= $data['submenu'][$i]['url'] ?>">
                      <i class="<?= $data['submenu'][$i]['icon'] ?>"></i>
                      <!--menampilkan counter badge -->
                      <?php
                      if($data['submenu'][$i]['title'] == 'Work Order' && $notifwo != 0){ ?>
                        <span class="badge badge-danger badge-samping" data-toggle="tooltip" title="Ada <?= $notifwo ?> Work Order yang harus di Approve"><?= $notifwo ?></span>
                      <?php } elseif ($data['submenu'][$i]['title'] == 'Handover' && $notifhandover != 0){ ?>
                        <span class="badge badge-danger badge-samping" data-toggle="tooltip" title="Ada <?= $notifhandover ?> Work Order dalam status Handover"><?= $notifhandover ?></span>
                      <?php } ?>
                      <span><?= $data['submenu'][$i]['title'] ?></span></a>
                  </li>
        <?php
                }
              }
            }
          }
        }



        ?>

        <!-- Divider -->
        <hr class="sidebar-divider mt-2">
      <?php endforeach; ?>

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand bg-gray-200 topbar mb-3 static-top">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Cari..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>

          <!-- notifikasi  -->
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw" data-toggle="tooltip" title="Notification"></i>
                <!-- Counter - Alerts -->
                <?php
                $jmlnotif = 0;
                foreach ($data['notif'] as $x) {
                  if ($x['readed'] == 0) {
                    $jmlnotif++;
                  }
                }

                if ($jmlnotif > 0) { ?>
                  <span class="badge badge-danger badge-counter"><?= $jmlnotif ?></span>
                <?php } ?>


              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Notification
                </h6>

                <?php
                if ($jmlnotif > 0) {
                  //cek jml data notif apakah lebih dari 3 atau kurang dari 3
                  $looping = 3;
                  if ($jmlnotif < $looping) {
                    $looping = $jmlnotif;
                  }
                  //looping notif
                  for ($i = 0; $i < $looping; $i++) {
                    if ($data['notif'][$i]['readed'] == 0) { ?>
                      <a class="dropdown-item d-flex align-items-center" href="<?= BASEURL; ?>/notifikasi/read/<?= $data['notif'][$i]['link'] ?>/<?= $data['notif'][$i]['id_notif'] ?>/<?= $data['notif'][$i]['id_wo'] ?>">
                        <div class="mr-3">
                          <div class="icon-circle bg-primary">
                            <i class="fas fa-comment-dots text-white"></i>
                            <!-- <i class="fas fa-file-alt text-white"></i> -->
                          </div>
                        </div>
                        <div>
                          <div class="small text-gray-500"><?= date('d M y H:i', strtotime($data['notif'][$i]['tanggal'])) ?></div>
                          <span><?= $data['notif'][$i]['pesan'] ?></span>
                        </div>
                      </a>
                  <?php
                    }
                  }
                } else { ?>
                  <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                      <div class="icon-circle bg-primary">
                        <i class="fas fa-comment-dots text-white"></i>
                      </div>
                    </div>
                    <div>
                      <div class="small text-gray-500">no message here</div>
                    </div>
                  </a>
                <?php } ?>

                <a class="dropdown-item text-center small text-gray-500" href="<?= BASEURL; ?>/notifikasi">Show All Notification</a>
              </div>
            </li>


            <!-- //mesage center -->
            <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-comments fa-fw" data-toggle="tooltip" title="Chat Message"></i>

                <!-- Counter - Messages -->
                <?php
                $jmlchat = count($data['unreaduser']);

                if ($jmlchat > 0) { ?>
                  <span class="badge badge-danger badge-counter"><?= $jmlchat ?></span>
                <?php } ?>

              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                  Chat Message
                </h6>

                <?php

                if ($jmlchat > 0) {
                  //cek jml data notif apakah lebih dari 3 atau kurang dari 3
                  $loopchat = 5;
                  if ($jmlchat < $loopchat) {
                    $loopchat = $jmlchat;
                  }

                  for ($z = 0; $z < $loopchat; $z++) {
                    $userinfo = $this->models('chat_model')->getuserinfo($data['unreaduser'][$z]['from_user']);
                ?>
                    <!-- chat message  -->
                    <a class="dropdown-item d-flex align-items-center" href="<?= BASEURL; ?>/chat/<?= $userinfo['id_user'] ?>">

                      <!-- profile chat user  -->
                      <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="<?= BASEURL; ?>/img/profile/<?= $userinfo['profile'] ?>" alt="">
                        <div class="status-indicator bg-success"></div>
                      </div>

                      <!-- list chat user  -->
                      <div class="font-weight-bold">
                        <div class="text-truncate"><?= $data['unreaduser'][$z]['chat_message'] ?></div>
                        <div class="small text-gray-500"><?= $userinfo['nama_user'] ?> | <?= date('d M g:i A', strtotime($data['unreaduser'][$z]['chat_time'])); ?></div>
                      </div>
                    </a>
                  <?php }
                } else { ?>
                  <!-- jika tidak ada pesan -->
                  <a class="dropdown-item d-flex align-items-center" href="<?= BASEURL; ?>/chat">
                    <div class="mr-3">
                      <div class="icon-circle bg-primary">
                        <i class="fas fa-comments text-white"></i>
                      </div>
                    </div>
                    <div>
                      <div class="small text-gray-500">click here to chat</div>
                    </div>
                  </a>

                <?php  } ?>

                <a class="dropdown-item text-center small text-gray-500" href="<?= BASEURL; ?>/chat">Read More Chat</a>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $data['user']['nama_user']; ?></span>
                <img class="img-profile rounded-circle" src="<?= BASEURL; ?>/img/profile/<?= $data['user']['profile']; ?>" data-profil="<?= $data['user']['profile']; ?>">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="<?= BASEURL; ?>/profile">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  My Profile
                </a>
                <a class="dropdown-item" href="<?= BASEURL; ?>/profile/password">
                  <i class="fas fa-lock fa-sm fa-fw mr-2 text-gray-400"></i>
                  Change Password
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?= BASEURL; ?>auth/logout" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->