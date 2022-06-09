<?php


class antrian extends Controller
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
        $data['title'] = "Antrian";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['waitinglist'] = $this->models('antrian_model')->getWOWaitinglist();
        $data['inprogress'] = $this->models('antrian_model')->getWOInprogress();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('antrian/index', $data);
        $this->views('templates/footer');
    }

    //controller untuk meminta data detail activity
    public function getActivity()
    {
        echo json_encode($this->models('antrian_model')->getDataActivity($_POST['id_wo']));
    }

    public function estimasi()
    {
        if ($this->models('workorder_model')->tambahEstimasi($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'ditambahkan', 'success', 'estimasi pengerjaan', '');
            header('Location: ' . BASEURL . '/antrian#waitinglist');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'estimasi pengerjaan', '');
            header('Location: ' . BASEURL . '/antrian#waitinglist');
            exit;
        }
    }

}
