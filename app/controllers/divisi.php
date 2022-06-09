<?php

class divisi extends Controller
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
        $data['divisi'] = $this->models('corporate_model')->dataDivisi();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('corporate/divisi', $data);
        $this->views('templates/footer');
    }


    public function add_div()
    {
        $data['title'] = "Corporate";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['divhead'] = $this->models('user_model')->getDivhead();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('corporate/add-div', $data);
        $this->views('templates/footer');
    }


    public function edit_div($id_divisi)
    {
        $data['title'] = "Corporate";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['divhead'] = $this->models('user_model')->getDivhead();
        $data['div'] = $this->models('corporate_model')->getDivisibyID($id_divisi);
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('corporate/edit-div', $data);
        $this->views('templates/footer');
    }


    public function tambahDivisi()
    {
        $div = $_POST['divisi'];

        if ($this->models('corporate_model')->cekDivisi($_POST) > 0) {
            Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'divisi', 'Divisi ' . $div . ' sudah ada di Database !');
            header('Location: ' . BASEURL . '/divisi');
            exit;
        } elseif ($this->models('corporate_model')->tambahDivisi($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'ditambahkan', 'success', 'divisi', '');
            header('Location: ' . BASEURL . '/divisi');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'divisi', '');
            header('Location: ' . BASEURL . '/divisi');
            exit;
        }
    }

    public function updateDivisi()
    {
        if ($this->models('corporate_model')->updateDivisi($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'diupdate', 'success', 'divisi', '');
            header('Location: ' . BASEURL . '/divisi');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'diupdate', 'danger', 'divisi', '');
            header('Location: ' . BASEURL . '/divisi');
            exit;
        }
    }

    //hapus data divisi
    public function hapusDivisi($id_divisi)
    {
        if ($this->models('corporate_model')->cekDatabyID($id_divisi) > 0) {
            Flasher::setFlash('Tidak bisa', 'dihapus', 'danger', 'divisi', 'Data sudah dipakai pada data Department.');
            header('Location: ' . BASEURL . '/divisi');
            exit;
        } elseif ($this->models('corporate_model')->hapusDivisi($id_divisi) > 0) {
            Flasher::setFlash('Berhasil', 'dihapus', 'success', 'divisi', '');
            header('Location: ' . BASEURL . '/divisi');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'dihapus', 'danger', 'divisi', '');
            header('Location: ' . BASEURL . '/divisi');
            exit;
        }
    }
}
