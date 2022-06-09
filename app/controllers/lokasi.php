<?php

class lokasi extends Controller
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
        $data['lokasi'] = $this->models('corporate_model')->dataLokasi();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('corporate/lokasi', $data);
        $this->views('templates/footer');
    }


    public function add_lokasi()
    {
        $data['title'] = "Corporate";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('corporate/add-lokasi', $data);
        $this->views('templates/footer');
    }


    public function tambahLokasi()
    {
        $lok = $_POST['lokasi'];

        if ($this->models('corporate_model')->cekLokasi($_POST) > 0) {
            Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'lokasi', 'Lokasi ' . $lok . ' sudah ada di Database !');
            header('Location: ' . BASEURL . '/lokasi');
            exit;
        } elseif ($this->models('corporate_model')->tambahLokasi($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'ditambahkan', 'success', 'lokasi', '');
            header('Location: ' . BASEURL . '/lokasi');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'lokasi', '');
            header('Location: ' . BASEURL . '/lokasi');
            exit;
        }
    }


    public function edit_lokasi($id_lokasi)
    {
        $data['title'] = "Corporate";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['lokasi'] = $this->models('corporate_model')->getLokasibyID($id_lokasi);
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('corporate/edit-lokasi', $data);
        $this->views('templates/footer');
    }

    public function updateLokasi()
    {
        if ($this->models('corporate_model')->updateLokasi($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'diupdate', 'success', 'lokasi', '');
            header('Location: ' . BASEURL . '/lokasi');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'diupdate', 'danger', 'lokasi', '');
            header('Location: ' . BASEURL . '/lokasi');
            exit;
        }
    }

    //hapus data lokasi
    public function hapusLokasi($id_lokasi)
    {
        if ($this->models('workorder_model')->cekDataLokasi($id_lokasi) > 0) {
            Flasher::setFlash('Tidak bisa', 'dihapus', 'danger', 'lokasi', 'Data sudah dipakai pada transaksi Work Order.');
            header('Location: ' . BASEURL . '/lokasi');
            exit;
        } elseif ($this->models('corporate_model')->hapusLokasi($id_lokasi) > 0) {
            Flasher::setFlash('Berhasil', 'dihapus', 'success', 'lokasi', '');
            header('Location: ' . BASEURL . '/lokasi');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'dihapus', 'danger', 'lokasi', '');
            header('Location: ' . BASEURL . '/lokasi');
            exit;
        }
    }
}
