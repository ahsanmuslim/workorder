<?php

class teknisi extends Controller
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
        $data['title'] = "Technician";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['teknisi'] = $this->models('teknisi_model')->datateknisi();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('teknisi/index', $data);
        $this->views('templates/footer');
    }


    public function tambah()
    {
        $data['title'] = "Technician";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('teknisi/add', $data);
        $this->views('templates/footer');
    }


    public function edit($id_teknisi)
    {
        $data['title'] = "Technician";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['teknisi'] = $this->models('teknisi_model')->getteknisibyID($id_teknisi);
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('teknisi/edit', $data);
        $this->views('templates/footer');
    }


    public function tambahteknisi()
    {
        $teknisi = $_POST['teknisi'];

        if ($this->models('teknisi_model')->cekteknisi($_POST) > 0) {
            Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'teknisi', 'teknisi ' . $teknisi . ' sudah ada di Database !');
            header('Location: ' . BASEURL . '/teknisi');
            exit;
        } elseif ($this->models('teknisi_model')->tambahteknisi($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'ditambahkan', 'success', 'teknisi', '');
            header('Location: ' . BASEURL . '/teknisi');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'teknisi', '');
            header('Location: ' . BASEURL . '/teknisi');
            exit;
        }
    }

    public function updateteknisi()
    {
        if ($this->models('teknisi_model')->updateteknisi($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'diupdate', 'success', 'teknisi', '');
            header('Location: ' . BASEURL . '/teknisi');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'diupdate', 'danger', 'teknisi', '');
            header('Location: ' . BASEURL . '/teknisi');
            exit;
        }
    }

    //hapus data teknisi
    public function hapus($id_teknisi)
    {
        if ($this->models('teknisi_model')->cekDatabyID($id_teknisi) > 0) {
            Flasher::setFlash('Tidak bisa', 'dihapus', 'danger', 'teknisi', 'Data sudah dipakai pada data work order.');
            header('Location: ' . BASEURL . '/teknisi');
            exit;
        } elseif ($this->models('teknisi_model')->hapusteknisi($id_teknisi) > 0) {
            Flasher::setFlash('Berhasil', 'dihapus', 'success', 'teknisi', '');
            header('Location: ' . BASEURL . '/teknisi');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'dihapus', 'danger', 'teknisi', '');
            header('Location: ' . BASEURL . '/teknisi');
            exit;
        }
    }


    //controller untuk meminta data active project yang dipegang teknisi
    public function getActiveproject()
    {
        echo json_encode($this->models('teknisi_model')->getActiveproject($_POST['id_teknisi']));
    }
}
