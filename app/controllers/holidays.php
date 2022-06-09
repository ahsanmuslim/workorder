<?php

class holidays extends Controller
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
        $data['holidays'] = $this->models('general_model')->dataholidays();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('general/holidays', $data);
        $this->views('templates/footer');
    }


    public function add_holidays()
    {
        $data['title'] = "General";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('general/add-holidays', $data);
        $this->views('templates/footer');
    }


    public function tambahholidays()
    {
        $tgl = $_POST['tanggal'];

        if ($this->models('general_model')->cekholidays($_POST) > 0) {
            Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'tanggal', 'holidays ' . $tgl . ' sudah ada di Database !');
            header('Location: ' . BASEURL . '/holidays');
            exit;
        } elseif ($this->models('general_model')->tambahholidays($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'ditambahkan', 'success', 'hari libur', '');
            header('Location: ' . BASEURL . '/holidays');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'hari libur', '');
            header('Location: ' . BASEURL . '/holidays');
            exit;
        }
    }


    public function edit_holidays($id)
    {
        $data['title'] = "General";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['holidays'] = $this->models('general_model')->getholidaysbyID($id);
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('general/edit-holidays', $data);
        $this->views('templates/footer');
    }

    public function updateholidays()
    {
        if ($this->models('general_model')->updateholidays($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'diupdate', 'success', 'hari libur', '');
            header('Location: ' . BASEURL . '/holidays');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'diupdate', 'danger', 'hari libur', '');
            header('Location: ' . BASEURL . '/holidays');
            exit;
        }
    }

    //hapus data progress
    public function hapusholidays($id)
    {
        if ($this->models('general_model')->hapusholidays($id) > 0) {
            Flasher::setFlash('Berhasil', 'dihapus', 'success', 'hari libur', '');
            header('Location: ' . BASEURL . '/holidays');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'dihapus', 'danger', 'hari libur', '');
            header('Location: ' . BASEURL . '/holidays');
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
        $this->views('general/import-holidays', $data);
        $this->views('templates/footer');
    }

    public function importData ()
    {
        // var_dump($_FILES);
        if ( $this->models('general_model')->importHolidays() > 0 ){
            Flasher::setFlash('Berhasil', 'diimport', 'success', 'holidays', '');
            header ('Location: '. BASEURL . '/holidays');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'diimport', 'danger','holidays', '');
            header ('Location: '. BASEURL . '/holidays');
            exit;
        }
    }

    public function download ()
    {
        header('Location: ' . BASEURL . '/file/sample/holidays.xlsx');
    }





}
