<?php


class notifikasi extends Controller
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
        $data['title'] = "Notification";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['notifAll'] =$this->models('notifikasi_model')->getNotifAll($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('notifikasi/index', $data);
        $this->views('templates/footer');
    }

    public function read($link, $id_notif, $id_wo)
    {
        // var_dump($link);
        if($link == 'workorder'){
            $this->models('notifikasi_model')->notifReaded($id_notif);
            header('Location: ' . BASEURL . '/'.$link.'/detail/'.$id_wo);
        } elseif($link == 'serahterima'){
            $this->models('notifikasi_model')->notifReaded($id_notif);
            header('Location: ' . BASEURL . '/'.$link.'/edit/'.$id_wo);
        } else {
            header('Location: ' . BASEURL . '/dashboard');
        }
    }


}
