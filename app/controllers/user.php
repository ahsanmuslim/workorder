<?php

class user extends Controller
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
        $data['title'] = "User Management";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['datauser'] = $this->models('user_model')->dataUser();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('user/index', $data);
        $this->views('templates/footer');
    }

    public function tambah()
    {
        $data['title'] = "User Management";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['datarole'] = $this->models('role_model')->getRole();
        $data['dept'] = $this->models('corporate_model')->dataDept();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('user/tambah', $data);
        $this->views('templates/footer');
    }

    public function update($id_user)
    {
        $data['title'] = "User Management";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['datarole'] = $this->models('role_model')->getRole();
        $data['datauser'] = $this->models('user_model')->getUserbyID($id_user);
        $data['dept'] = $this->models('corporate_model')->dataDept();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('user/update', $data);
        $this->views('templates/footer');
    }

    public function tambahData()
    {
        $username = $_POST['username'];

        if ($this->models('user_model')->cekUsername($_POST) > 0) {
            Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'user', 'username ' . $username . ' sudah ada di Database !');
            header('Location: ' . BASEURL . '/user');
            exit;
        } elseif ($this->models('user_model')->cekEmail($_POST) > 0) {
            Flasher::setFlash('Gagal', 'ditambahkan !!', 'danger', 'user', 'Email tidak tersedia !!');
            header('Location: ' . BASEURL . '/user');
            exit;
        } elseif ($this->models('user_model')->tambahData($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'ditambahkan', 'success', 'user', '');
            header('Location: ' . BASEURL . '/user');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'user', '');
            header('Location: ' . BASEURL . '/user');
            exit;
        }
    }

    public function updateData()
    {
        if ($this->models('user_model')->updateData($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'diupdate', 'success', 'user', '');
            header('Location: ' . BASEURL . '/user');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'diupdate', 'danger', 'user', '');
            header('Location: ' . BASEURL . '/user');
            exit;
        }
    }

    public function hapus($id_user)
    {
        if ($this->models('user_model')->cekUserdiWO($id_user) > 0) {
            Flasher::setFlash('Tidak bisa', 'dihapus', 'danger', 'user', 'User sudah dipakai pada data Work order.');
            header('Location: ' . BASEURL . '/user');
            exit;
        } elseif ($this->models('user_model')->hapusData($id_user) > 0) {
            Flasher::setFlash('Berhasil', 'dihapus', 'success', 'user', '');
            header('Location: ' . BASEURL . '/user');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'dihapus', 'danger', 'user', '');
            header('Location: ' . BASEURL . '/user');
            exit;
        }
    }
}
