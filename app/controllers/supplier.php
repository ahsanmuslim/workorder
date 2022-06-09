<?php

class supplier extends Controller
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
        $data['supplier'] = $this->models('corporate_model')->dataSupplier();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('corporate/supplier', $data);
        $this->views('templates/footer');
    }


    public function add_supplier()
    {
        $data['title'] = "Corporate";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('corporate/add-supplier', $data);
        $this->views('templates/footer');
    }


    public function tambahSupplier()
    {
        $sup = $_POST['supplier'];

        if ($this->models('corporate_model')->cekSupplier($_POST) > 0) {
            Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'supplier', 'Supplier ' . $sup . ' sudah ada di Database !');
            header('Location: ' . BASEURL . '/supplier');
            exit;
        } elseif ($this->models('corporate_model')->tambahSupplier($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'ditambahkan', 'success', 'supplier', '');
            header('Location: ' . BASEURL . '/supplier');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'supplier', '');
            header('Location: ' . BASEURL . '/supplier');
            exit;
        }
    }


    public function edit_supplier($id_supplier)
    {
        $data['title'] = "Corporate";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['supplier'] = $this->models('corporate_model')->getSupplierbyID($id_supplier);
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('corporate/edit-supplier', $data);
        $this->views('templates/footer');
    }

    public function updateSupplier()
    {
        if ($this->models('corporate_model')->updateSupplier($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'diupdate', 'success', 'supplier', '');
            header('Location: ' . BASEURL . '/supplier');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'diupdate', 'danger', 'supplier', '');
            header('Location: ' . BASEURL . '/supplier');
            exit;
        }
    }

    //hapus data supplier
    public function hapusSupplier($id_supplier)
    {
        if ($this->models('corporate_model')->cekDatasupplierbyID($id_supplier) > 0) {
            Flasher::setFlash('Tidak bisa', 'dihapus', 'danger', 'supplier', 'Data sudah dipakai pada transaksi Pembelian.');
            header('Location: ' . BASEURL . '/supplier');
            exit;
        } elseif ($this->models('corporate_model')->hapusSupplier($id_supplier) > 0) {
            Flasher::setFlash('Berhasil', 'dihapus', 'success', 'supplier', '');
            header('Location: ' . BASEURL . '/supplier');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'dihapus', 'danger', 'supplier', '');
            header('Location: ' . BASEURL . '/supplier');
            exit;
        }
    }

    public function import ()
    {
        $data['title'] = "Supplier";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('corporate/import-supplier', $data);
        $this->views('templates/footer');
    }

    public function importData ()
    {
        // var_dump($_FILES);
        if ( $this->models('corporate_model')->importSupplier() > 0 ){
            Flasher::setFlash('Berhasil', 'diimport', 'success', 'supplier', '');
            header ('Location: '. BASEURL . '/supplier');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'diimport', 'danger','supplier', '');
            header ('Location: '. BASEURL . '/supplier');
            exit;
        }
    }

    public function download ()
    {
        header('Location: ' . BASEURL . '/file/sample/supplier.xlsx');
    }




}
