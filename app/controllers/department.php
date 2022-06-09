<?php

class department extends Controller
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
        $data['title'] = "Corporate";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['dept'] = $this->models('corporate_model')->dataDept();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('corporate/department', $data);
        $this->views('templates/footer');
    }


    public function add_dept()
    {
        $data['title'] = "Corporate";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['depthead'] = $this->models('user_model')->getDepthead();
        $data['divisi'] = $this->models('corporate_model')->dataDivisi();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('corporate/add-dept', $data);
        $this->views('templates/footer');
    }


    public function edit_dept($id_dept)
    {
        $data['title'] = "Corporate";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['dept'] = $this->models('corporate_model')->getDeptbyID($id_dept);
        $data['divisi'] = $this->models('corporate_model')->dataDivisi();
        $data['depthead'] = $this->models('user_model')->getDepthead();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('corporate/edit-dept', $data);
        $this->views('templates/footer');
    }


    public function tambahDept()
    {
        $dept = $_POST['department'];

        if ($this->models('corporate_model')->cekDept($_POST) > 0) {
            Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'department', 'department ' . $dept . ' sudah ada di Database !');
            header('Location: ' . BASEURL . '/department');
            exit;
        } elseif ($this->models('corporate_model')->tambahDept($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'ditambahkan', 'success', 'department', '');
            header('Location: ' . BASEURL . '/department');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'department', '');
            header('Location: ' . BASEURL . '/department');
            exit;
        }
    }

    public function updateDept()
    {
        if ($this->models('corporate_model')->updateDept($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'diupdate', 'success', 'department', '');
            header('Location: ' . BASEURL . '/department');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'diupdate', 'danger', 'department', '');
            header('Location: ' . BASEURL . '/department');
            exit;
        }
    }

    //hapus data department
    public function hapusDept($id_dept)
    {
        if ($this->models('corporate_model')->cekDatauserbyID($id_dept) > 0) {
            Flasher::setFlash('Tidak bisa', 'dihapus', 'danger', 'department', 'Data sudah dipakai pada data User.');
            header('Location: ' . BASEURL . '/department');
            exit;
        } elseif ($this->models('corporate_model')->hapusDept($id_dept) > 0) {
            Flasher::setFlash('Berhasil', 'dihapus', 'success', 'department', '');
            header('Location: ' . BASEURL . '/department');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'dihapus', 'danger', 'department', '');
            header('Location: ' . BASEURL . '/department');
            exit;
        }
    }
}
