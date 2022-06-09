<?php

class kategori extends Controller
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
        $data['kategori'] = $this->models('general_model')->datakategori();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('general/kategori', $data);
        $this->views('templates/footer');
    }


    public function add_kategori()
    {
        $data['title'] = "General";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('general/add-kategori', $data);
        $this->views('templates/footer');
    }


    public function tambahkategori()
    {
        $kategori = $_POST['kategori'];

        if ($this->models('general_model')->cekkategori($_POST) > 0) {
            Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'kategori', 'kategori ' . $kategori . ' sudah ada di Database !');
            header('Location: ' . BASEURL . '/kategori');
            exit;
        } elseif ($this->models('general_model')->tambahkategori($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'ditambahkan', 'success', 'kategori', '');
            header('Location: ' . BASEURL . '/kategori');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'kategori', '');
            header('Location: ' . BASEURL . '/kategori');
            exit;
        }
    }


    public function edit_kategori($id_kategori)
    {
        $data['title'] = "General";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['kategori'] = $this->models('general_model')->getkategoribyID($id_kategori);
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('general/edit-kategori', $data);
        $this->views('templates/footer');
    }

    public function updatekategori()
    {
        if ($this->models('general_model')->updatekategori($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'diupdate', 'success', 'kategori', '');
            header('Location: ' . BASEURL . '/kategori');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'diupdate', 'danger', 'kategori', '');
            header('Location: ' . BASEURL . '/kategori');
            exit;
        }
    }

    //hapus data kategori
    public function hapuskategori($id_kategori)
    {
        if ($this->models('general_model')->cekDatakategoribyID($id_kategori) > 0) {
            Flasher::setFlash('Tidak bisa', 'dihapus', 'danger', 'kategori', 'Data sudah dipakai pada transaksi Work Order.');
            header('Location: ' . BASEURL . '/kategori');
            exit;
        } elseif ($this->models('general_model')->hapuskategori($id_kategori) > 0) {
            Flasher::setFlash('Berhasil', 'dihapus', 'success', 'kategori', '');
            header('Location: ' . BASEURL . '/kategori');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'dihapus', 'danger', 'kategori', '');
            header('Location: ' . BASEURL . '/kategori');
            exit;
        }
    }
}
