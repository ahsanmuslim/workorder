<?php

class material extends Controller
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
        $data['title'] = "Material";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['material'] = $this->models('material_model')->dataMaterial();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('material/index', $data);
        $this->views('templates/footer');
    }


    public function tambah()
    {
        $data['title'] = "Material";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['code'] = $this->models('material_model')->getKodematerial();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('material/add', $data);
        $this->views('templates/footer');
    }


    public function edit($id_material)
    {
        $data['title'] = "Material";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['material'] = $this->models('material_model')->getMaterialbyID($id_material);
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('material/edit', $data);
        $this->views('templates/footer');
    }


    public function tambahMaterial()
    {
        $mat = $_POST['material'];

        if ($this->models('material_model')->cekMaterial($_POST) > 0) {
            Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'material', 'Material ' . $mat . ' sudah ada di Database !');
            header('Location: ' . BASEURL . '/material');
            exit;
        } elseif ($this->models('material_model')->tambahMaterial($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'ditambahkan', 'success', 'material', '');
            header('Location: ' . BASEURL . '/material');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'material', '');
            header('Location: ' . BASEURL . '/material');
            exit;
        }
    }

    public function updateMaterial()
    {
        if ($this->models('material_model')->updateMaterial($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'diupdate', 'success', 'material', '');
            header('Location: ' . BASEURL . '/material');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'diupdate', 'danger', 'material', '');
            header('Location: ' . BASEURL . '/material');
            exit;
        }
    }

    //hapus data material
    public function hapus($id_material)
    {
        if ($this->models('material_model')->cekDatabyID($id_material) > 0) {
            Flasher::setFlash('Tidak bisa', 'dihapus', 'danger', 'material', 'Data sudah dipakai pada data use material.');
            header('Location: ' . BASEURL . '/material');
            exit;
        } elseif ($this->models('material_model')->hapusMaterial($id_material) > 0) {
            Flasher::setFlash('Berhasil', 'dihapus', 'success', 'material', '');
            header('Location: ' . BASEURL . '/material');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'dihapus', 'danger', 'material', '');
            header('Location: ' . BASEURL . '/material');
            exit;
        }
    }

    public function getMaterial()
    {
        echo json_encode($this->models('material_model')->getMaterialbyID($_POST['id_material']));
    }

    public function import ()
    {
        $data['title'] = "Material";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('material/import', $data);
        $this->views('templates/footer');
    }

    public function importData ()
    {
        // var_dump($_FILES);
        if ( $this->models('material_model')->importData() > 0 ){
            Flasher::setFlash('Berhasil', 'diimport', 'success', 'material', '');
            header ('Location: '. BASEURL . '/material');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'diimport', 'danger','material', '');
            header ('Location: '. BASEURL . '/material');
            exit;
        }
    }

    public function download ()
    {
        header('Location: ' . BASEURL . '/file/sample/material.xlsx');
    }




}
