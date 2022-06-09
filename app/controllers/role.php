<?php

class role extends Controller
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
        $data['title'] = "Role Management";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['role'] = $this->models('role_model')->getRole();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('role/index', $data);
        $this->views('templates/footer');
    }

    public function akses($id_role)
    {
        $data['title'] = "Role Management";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['role'] = $this->models('role_model')->getDataRole($id_role);
        $data['activeMenu'] = $this->models('menu_model')->allSubmenuActive();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('role/akses', $data);
        $this->views('templates/footer');
    }


    public function getEdit()
    {
        echo json_encode($this->models('role_model')->getDataRole($_POST['id_role']));
    }

    public function tambah()
    {
        $role = $_POST['role'];

        if ($this->models('role_model')->cekData($_POST) > 0) {
            Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'role', 'Role ' . $role . ' sudah ada di Database !');
            header('Location: ' . BASEURL . '/role');
            exit;
        } elseif ($this->models('role_model')->tambahData($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'ditambahkan', 'success', 'role', '');
            header('Location: ' . BASEURL . '/role');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'role', '');
            header('Location: ' . BASEURL . '/role');
            exit;
        }
    }


    public function hapus($id_role)
    {
        if ($this->models('role_model')->cekDatabyID($id_role) > 0) {
            Flasher::setFlash('Tidak bisa', 'dihapus', 'danger', 'role', 'Data sudah dipakai pada User.');
            header('Location: ' . BASEURL . '/role');
            exit;
        } elseif ($this->models('role_model')->hapusData($id_role) > 0) {
            Flasher::setFlash('Berhasil', 'dihapus', 'success', 'role', '');
            header('Location: ' . BASEURL . '/role');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'dihapus', 'danger', 'role', '');
            header('Location: ' . BASEURL . '/role');
            exit;
        }
    }


    public function update()
    {
        if ($this->models('role_model')->updateData($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'diupdate', 'success', 'role', '');
            header('Location: ' . BASEURL . '/role');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'diupdate', 'danger', 'role', '');
            header('Location: ' . BASEURL . '/role');
            exit;
        }
    }

    public function updateAkses()
    {
        $id_role = $_POST['id_role'];
        $id_submenu = $_POST['ceklist'];
        $count = count($_POST['ceklist']);
        //deklarasi variable cekbox create update delete
        $createlist = "";
        $updatelist = "";
        $deletelist = "";
        $printlist = "";
        if (!empty($_POST['createlist'])) {
            $createlist = $_POST['createlist'];
        }
        if (!empty($_POST['updatelist'])) {
            $updatelist = $_POST['updatelist'];
        }
        if (!empty($_POST['deletelist'])) {
            $deletelist = $_POST['deletelist'];
        }
        if (!empty($_POST['printlist'])) {
            $printlist = $_POST['printlist'];
        }


        if ($this->models('role_model')->updateAkses($id_role, $id_submenu, $count, $createlist, $updatelist, $deletelist, $printlist) > 0) {
            Flasher::setFlash('Berhasil', 'diupdate', 'success', 'role akses', '');
            header('Location: ' . BASEURL . '/role');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'diupdate', 'danger', 'role  akses', '');
            header('Location: ' . BASEURL . '/role');
            exit;
        }
    }
}
