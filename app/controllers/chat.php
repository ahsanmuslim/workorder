<?php


class chat extends Controller
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
        $data['title'] = "Chat Message";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $id_user = $data['user']['id_user'];
        $data['notif'] = $this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('chat/index', $data);
        $this->views('templates/footer-chat');
    }

    //ambil data chat detail
    public function getChatdetail()
    {
        echo json_encode($this->models('chat_model')->getChatdetail($_POST['id_receiver'], $_POST['id_sender']));
    }

    //simpan pesan terkirim 
    public function saveChat()
    {
        echo $this->models('chat_model')->saveChat($_POST);
    }

    //last activity
    public function updateLastactivity()
    {
        echo $this->models('chat_model')->updateLastactivity($_POST['id_sender']);
    }


    public function readChat()
    {
        echo $this->models('chat_model')->readChat($_POST);
    }

    //getlastchat update
    public function getUpdatelastchat()
    {
        echo json_encode($this->models('chat_model')->getUpdatelastchat($_POST['id_sender']));
    }

    //get user online
    public function getOnline()
    {
        echo json_encode($this->models('chat_model')->getOnline($_POST['id_sender']));
    }
}
