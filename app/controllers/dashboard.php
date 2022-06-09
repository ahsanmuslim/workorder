<?php


class dashboard extends Controller
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
        $data['title'] = "Dashboard";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $dept = $data['user']['id_dept'];
        $id_role = $data['user']['role'];
        $data['dataWorkorder'] = $this->models('dashboard_model')->dataWorkorder($dept, $id_role);
        $data['open'] = $this->models('dashboard_model')->workorderOpen($dept, $id_role);
        $data['closed'] = $this->models('dashboard_model')->workorderClosed($dept, $id_role);
        $data['grafikStatus'] = $this->models('dashboard_model')->grafikStatus($dept, $id_role);
        $data['grafikJenis'] = $this->models('dashboard_model')->grafikJenis($dept, $id_role);
        $data['grafikBiaya'] = $this->models('dashboard_model')->grafikBiaya($dept, $id_role);
        $data['grafikWO'] = $this->models('dashboard_model')->grafikWO($dept, $id_role);
        $data['grafikProgress'] = $this->models('dashboard_model')->grafikProgress($dept, $id_role);
        $data['grafikTimeline'] = $this->models('dashboard_model')->grafikTimeline($dept, $id_role);
        $data['grafikLeadtime'] = $this->models('dashboard_model')->grafikLeadtime($dept, $id_role);
        $data['grafikDept'] = $this->models('dashboard_model')->grafikDept();
        $data['grafikbiayaDept'] = $this->models('dashboard_model')->grafikbiayaDept();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('dashboard/index', $data);
        $this->views('templates/footer');
    }
}
