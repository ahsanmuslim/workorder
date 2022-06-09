<?php

class problem extends Controller
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
        $data['title'] = "Problem";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['problem'] = $this->models('problem_model')->dataproblem();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('problem/index', $data);
        $this->views('templates/footer');
    }


    public function tambah()
    {
        $data['title'] = "problem";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $dept = $data['user']['nama_dept'];
        $id_role = $data['user']['role'];
        $data['workorder'] = $this->models('workorder_model')->dataWorkorder($dept, $id_role);
        $data['datauser'] = $this->models('user_model')->dataUser();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('problem/add', $data);
        $this->views('templates/footer');
    }


    public function edit($id_problem)
    {
        $data['title'] = "Corporate";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['problem'] = $this->models('problem_model')->getproblembyID($id_problem);
        $data['datauser'] = $this->models('user_model')->dataUser();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('problem/edit', $data);
        $this->views('templates/footer');
    }


    public function tambahproblem()
    {
        if ($this->models('problem_model')->tambahproblem($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'ditambahkan', 'success', 'problem', '');
            header('Location: ' . BASEURL . '/problem');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'problem', '');
            header('Location: ' . BASEURL . '/problem');
            exit;
        }
    }

    public function updateproblem()
    {
        if ($this->models('problem_model')->updateproblem($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'diupdate', 'success', 'problem', '');
            header('Location: ' . BASEURL . '/problem');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'diupdate', 'danger', 'problem', '');
            header('Location: ' . BASEURL . '/problem');
            exit;
        }
    }

    //hapus data problem
    public function hapus($id_problem)
    {
        if ($this->models('problem_model')->hapusproblem($id_problem) > 0) {
            Flasher::setFlash('Berhasil', 'dihapus', 'success', 'problem', '');
            header('Location: ' . BASEURL . '/problem');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'dihapus', 'danger', 'problem', '');
            header('Location: ' . BASEURL . '/problem');
            exit;
        }
    }
}
