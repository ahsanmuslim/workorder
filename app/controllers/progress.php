<?php

class progress extends Controller
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
        $data['title'] = "General";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['progress'] = $this->models('general_model')->dataprogress();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('general/progress', $data);
        $this->views('templates/footer');
    }


    public function add_progress()
    {
        $data['title'] = "General";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('general/add-progress', $data);
        $this->views('templates/footer');
    }


    public function tambahprogress()
    {
        $progress = $_POST['progress'];

        if ($this->models('general_model')->cekprogress($_POST) > 0) {
            Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'progress', 'progress ' . $progress . ' sudah ada di Database !');
            header('Location: ' . BASEURL . '/progress');
            exit;
        } elseif ($this->models('general_model')->tambahprogress($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'ditambahkan', 'success', 'progress', '');
            header('Location: ' . BASEURL . '/progress');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'progress', '');
            header('Location: ' . BASEURL . '/progress');
            exit;
        }
    }


    public function edit_progress($id_progress)
    {
        $data['title'] = "General";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['progress'] = $this->models('general_model')->getprogressbyID($id_progress);
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('general/edit-progress', $data);
        $this->views('templates/footer');
    }

    public function updateprogress()
    {
        if ($this->models('general_model')->updateprogress($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'diupdate', 'success', 'progress', '');
            header('Location: ' . BASEURL . '/progress');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'diupdate', 'danger', 'progress', '');
            header('Location: ' . BASEURL . '/progress');
            exit;
        }
    }

    //hapus data progress
    public function hapusprogress($id_progress)
    {
        if ($this->models('general_model')->cekDatabyID($id_progress) > 0) {
            Flasher::setFlash('Tidak bisa', 'dihapus', 'danger', 'progress', 'Data sudah dipakai pada transaksi Work Order.');
            header('Location: ' . BASEURL . '/progress');
            exit;
        } elseif ($this->models('general_model')->hapusprogress($id_progress) > 0) {
            Flasher::setFlash('Berhasil', 'dihapus', 'success', 'progress', '');
            header('Location: ' . BASEURL . '/progress');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'dihapus', 'danger', 'progress', '');
            header('Location: ' . BASEURL . '/progress');
            exit;
        }
    }

    public function import ()
    {
        $data['title'] = "General";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('general/import-progress', $data);
        $this->views('templates/footer');
    }

    public function importData ()
    {
        // var_dump($_FILES);
        if ( $this->models('general_model')->importProgress() > 0 ){
            Flasher::setFlash('Berhasil', 'diimport', 'success', 'detail progress', '');
            header ('Location: '. BASEURL . '/progress');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'diimport', 'danger','detail progress', '');
            header ('Location: '. BASEURL . '/progress');
            exit;
        }
    }

    public function download ()
    {
        header('Location: ' . BASEURL . '/file/sample/detail_progress.xlsx');
    }




}
