<?php

class menu extends Controller
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
        $data['title'] = "Menu Management";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['datamenu'] = $this->models('menu_model')->allMenu();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('menu/index', $data);
        $this->views('templates/footer');
    }

    public function submenu()
    {
        $data['title'] = "Menu Management";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['datamenu'] = $this->models('menu_model')->allSubmenu();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('menu/submenu', $data);
        $this->views('templates/footer');
    }

    public function add()
    {
        $data['title'] = "Menu Management";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['datamenu'] = $this->models('menu_model')->allMenu();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('menu/add', $data);
        $this->views('templates/footer');
    }

    public function edit($id_submenu)
    {
        $data['title'] = "Menu Management";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['datamenu'] = $this->models('menu_model')->allMenu();
        $data['submenu']  = $this->models('menu_model')->getDataSubmenu($id_submenu);
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('menu/edit', $data);
        $this->views('templates/footer');
    }


    public function tambahMenu()
    {
        $menu = $_POST['menu'];

        if ($this->models('menu_model')->cekDataMenu($_POST) > 0) {
            Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'menu', 'Menu ' . $menu . ' sudah ada di Database !');
            header('Location: ' . BASEURL . '/menu');
            exit;
        } elseif ($this->models('menu_model')->tambahDataMenu($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'ditambahkan', 'success', 'menu', '');
            header('Location: ' . BASEURL . '/menu');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'menu', '');
            header('Location: ' . BASEURL . '/menu');
            exit;
        }
    }

    public function tambahSubmenu()
    {
        $url = $_POST['url'];

        if ($this->models('menu_model')->cekDataSubmenu($_POST) > 0) {
            Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'controller', 'Controller ' . $url . ' sudah ada di Database !');
            header('Location: ' . BASEURL . '/menu/submenu');
            exit;
        } elseif ($this->models('menu_model')->tambahDataSubmenu($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'ditambahkan', 'success', 'submenu', '');
            header('Location: ' . BASEURL . '/menu/submenu');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'submenu', '');
            header('Location: ' . BASEURL . '/menu/submenu');
            exit;
        }
    }

    public function getEdit()
    {
        echo json_encode($this->models('menu_model')->getDataMenu($_POST['id_menu']));
    }

    public function updateMenu()
    {
        if ($this->models('menu_model')->updateDataMenu($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'diupdate', 'success', 'menu', '');
            header('Location: ' . BASEURL . '/menu');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'diupdate', 'danger', 'menu', '');
            header('Location: ' . BASEURL . '/menu');
            exit;
        }
    }

    public function hapusMenu($id_menu)
    {
        if ($this->models('menu_model')->cekDatabyIDMenu($id_menu) > 0) {
            Flasher::setFlash('Tidak bisa', 'dihapus', 'danger', 'menu', 'Data sudah dipakai pada Submenu.');
            header('Location: ' . BASEURL . '/menu');
            exit;
        } elseif ($this->models('menu_model')->hapusDataMenu($id_menu) > 0) {
            Flasher::setFlash('Berhasil', 'dihapus', 'success', 'menu', '');
            header('Location: ' . BASEURL . '/menu');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'dihapus', 'danger', 'menu', '');
            header('Location: ' . BASEURL . '/menu');
            exit;
        }
    }

    public function hapusSubmenu($url)
    {
        if (file_exists('../app/controllers/' . $url . '.php')) {
            Flasher::setFlash('Tidak bisa', 'dihapus', 'danger', 'submenu', 'Sudah ada Controller untuk submenu ini !!');
            header('Location: ' . BASEURL . '/menu/submenu');
            exit;
        } elseif ($this->models('menu_model')->hapusDataSubmenu($url) > 0) {
            Flasher::setFlash('Berhasil', 'dihapus', 'success', 'submenu', '');
            header('Location: ' . BASEURL . '/menu/submenu');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'dihapus', 'danger', 'submenu', '');
            header('Location: ' . BASEURL . '/menu/submenu');
            exit;
        }
    }

    public function updateSubmenu()
    {
        if ($this->models('menu_model')->updateDataSubmenu($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'diupdate', 'success', 'submenu', '');
            header('Location: ' . BASEURL . '/menu/submenu');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'diupdate', 'danger', 'submenu', '');
            header('Location: ' . BASEURL . '/menu/submenu');
            exit;
        }
    }
}
