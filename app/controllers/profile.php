<?php

class profile extends Controller
{

    public function __construct()
    {
        $url = $this->parseURL();
        // var_dump($url[1]);

        if (!isset($_SESSION['useractive'])) {
            header('Location: ' . BASEURL . '/auth');
            Flasher::setFlash('Anda harus login dahulu !!', 'Akses langsung tidak diijinkan', 'danger', '', '');
        } else {
            $data['user'] = $this->models('user_model')->getUser();
            $id_role = $data['user']['role'];

            $url_menu = $url[0];

            if ($this->models('role_model')->countAccess($id_role, $url_menu) == 0) {
                header('Location: ' . BASEURL . '/auth/blocked');
                exit;
            }
        }
    }


    public function index()
    {
        $data['title'] = "My Profile";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['datarole'] = $this->models('role_model')->getRole();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('user/myprofile', $data);
        $this->views('templates/footer');
    }

    public function update($id_user)
    {
        $data['title'] = "My Profile";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['datarole'] = $this->models('role_model')->getRole();
        $data['datauser'] = $this->models('user_model')->getUserbyID($id_user);
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('user/edit-profile', $data);
        $this->views('templates/footer');
    }

    public function updateProfile()
    {
        $data['datauser'] = $this->models('user_model')->getUserbyID($_POST['id_user']);
        $file_lama = $data['datauser']['profile'];

        $upload_gambar = $_FILES['profile']['name'];


        if ($upload_gambar) {

            $ekstensi_std = array('png', 'jpg');
            $nama_file = $upload_gambar;
            $x = explode('.', $nama_file);
            $ekstensi = strtolower(end($x));
            $ukuran = $_FILES['profile']['size'];
            $file_temp = $_FILES['profile']['tmp_name'];

            if (in_array($ekstensi, $ekstensi_std) === true) {
                if ($ukuran < 2000000) {
                    move_uploaded_file($file_temp, 'img/profile/' . $nama_file);
                    if ($file_lama != 'default.jpg' && $file_lama != $nama_file) {
                        unlink('img/profile/' . $file_lama);
                    }
                    if ($this->models('user_model')->updateProfile($_POST, $nama_file) > 0 or $upload_gambar) {
                        Flasher::setFlash('Berhasil', 'diupdate', 'success', 'profile', '');
                        header('Location: ' . BASEURL . '/profile');
                        exit;
                    } else {
                        Flasher::setFlash('Gagal', 'diupdate', 'danger', 'profile', '');
                        header('Location: ' . BASEURL . '/profile');
                        exit;
                    }
                } else {
                    Flasher::setFlash('Gagal', 'diupdate', 'danger', 'profile', 'Ukuran gambar terlalu besar !!');
                    header('Location: ' . BASEURL . '/profile');
                    exit;
                }
            } else {
                Flasher::setFlash('Gagal', 'diupdate', 'danger', 'profile', 'Ekstensi gambar tidak sesuai !!');
                header('Location: ' . BASEURL . '/profile');
                exit;
            }
        } else {
            if ($this->models('user_model')->updateProfile($_POST, $file_lama) > 0) {
                Flasher::setFlash('Berhasil', 'diupdate', 'success', 'profile', '');
                header('Location: ' . BASEURL . '/profile');
                exit;
            } else {
                Flasher::setFlash('Gagal', 'diupdate', 'danger', 'profile', '');
                header('Location: ' . BASEURL . '/profile');
                exit;
            }
        }
    }

    public function password()
    {
        $data['title'] = "Change Password";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['datarole'] = $this->models('role_model')->getRole();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('user/password', $data);
        $this->views('templates/footer');
    }

    public function updatePassword()
    {
        $data['user'] = $this->models('user_model')->getUser();
        // var_dump($_POST);
        // var_dump(SHA1($_POST['passwordlama']));

        if (SHA1($_POST['passwordlama']) != $data['user']['password']) {
            Flasher::setFlash('Gagal', 'diupdate', 'danger', 'password', 'Password lama tidak sesuai !!');
            header('Location: ' . BASEURL . '/profile/password');
            exit;
        } elseif (SHA1($_POST['passwordbaru']) == $data['user']['password']) {
            Flasher::setFlash('harus berbeda', '', 'danger', 'password baru', 'dengan password lama !!');
            header('Location: ' . BASEURL . '/profile/password');
            exit;
        } elseif ($this->models('user_model')->updatePassword($_POST) > 0) {
            echo "<script>alert('Data password berhasil diupdate !');</script>";
            echo "<script>window.location.href='../BASEURL';</script>";
            exit;
        } else {
            echo "<script>alert('Data password gagal diupdate !');</script>";
            echo "<script>window.location.href='../BASEURL/profile';</script>";
            exit;
        }
    }
}
