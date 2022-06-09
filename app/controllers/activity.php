<?php

class activity extends Controller
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
        $data['title'] = "Activity";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['activity'] = $this->models('activity_model')->dataactivity();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('activity/index', $data);
        $this->views('templates/footer');
    }


    public function generate($id_wo = false)
    {
        $data['title'] = "Activity";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $dept = $data['user']['nama_dept'];
        $id_role = $data['user']['role'];
        if ($id_wo == false) {
            $data['wo'] = $this->models('activity_model')->getWolist();
        } else {
            $data['wo'] = $this->models('activity_model')->getnamaWO($id_wo);
        }
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('activity/generate', $data);
        $this->views('templates/footer');
    }


    public function tambah()
    {
        $data['title'] = "Activity";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $id_wo = $_POST['workorder'];
        $data['wo'] = $this->models('activity_model')->getnamaWO($id_wo);
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('activity/add', $data);
        $this->views('templates/footer');
    }


    public function edit($id_activity)
    {
        $data['title'] = "Activity";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['activity'] = $this->models('activity_model')->getactivitybyID($id_activity);
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('activity/edit', $data);
        $this->views('templates/footer');
    }


    public function editall($id_wo)
    {
        $data['title'] = "Activity";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['activity'] = $this->models('activity_model')->getactivitybyWO($id_wo);
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('activity/editall', $data);
        $this->views('templates/footer');
    }



    public function tambahactivity()
    {
        $id_wo = $_POST['id_wo'];
        //script untuk menghitung durasi progres
        $data['progress'] = $this->models('general_model')->getprogressbyID(6);
        $data['detail'] = $this->models('general_model')->getdetailbyID(6, $id_wo);
        $data['inprogress'] = $this->models('general_model')->numRowProgress(7, $id_wo);
        $standard = (int)$data['progress']['target'];

        //cek apakah detail finish sudah ada & progress in progress
        $isNull = $data['detail']['finish'];
        $rowInProgress = $data['inprogress'];

        $startDate = $data['detail']['start'];
        $endDate = $_POST['tanggal-1'];
        $data['libur'] = $this->models('general_model')->dataharilibur($startDate, $endDate);
        // $endDate = "2021-01-22";
        $holidays = [];

        foreach ($data['libur'] as $libur) :
            $holidays[] = $libur['tanggal'];
        endforeach;

        $durasi = WorkingDay::getWorkingDays($startDate, $endDate, $holidays);

        $status = 0;
        if ($durasi == $standard) {
            $status = 'on time';
        } elseif ($durasi > $standard) {
            $status = 'overdue';
        } elseif ($durasi < $standard) {
            $status = 'advance';
        }

        $totaldata = $_POST['totaldata'];

        // get data id telegram dept & membuat pesan notifikasi
        $data['wo'] = $this->models('workorder_model')->getDetailWO($_POST['id_wo']);

        $chat_id = [
            $data['wo']['telegram'], //id telegram dept
            MTCTelegram            //id telegram group MTC   
        ];

        $message = 'Work order *' . $id_wo . '* => ' . $data['wo']['nama_wo'] . '
Sedang dalam proses pengerjaan
Detail aktifitas :
- ' . $_POST['tanggal-1'] . ' => ' . $_POST['activity-1'] . ' (' . $_POST['status-1'] . ')
Dept. ' . $data['wo']['nama_dept'];

        if ($this->models('activity_model')->tambahactivity($_POST, $status, $durasi, $isNull, $rowInProgress) > 0) {
            Flasher::setFlash('Berhasil', 'ditambahkan', 'success', 'activity', '');
            foreach ($chat_id as $id) {
                BotTelegram::sendMessage($message, $id);
            }
            header('Location: ' . BASEURL . '/activity');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'activity', '');
            header('Location: ' . BASEURL . '/activity');
            exit;
        }
    }

    //update all activity by wo
    public function updateallactivity()
    {
        $id_wo = $_POST['id_wo'];
        $jml = $_POST['jmldata'];

        // get data id telegram dept & membuat pesan notifikasi
        $data['wo'] = $this->models('workorder_model')->getDetailWO($id_wo);

        $chat_id = [
            $data['wo']['telegram'], //id telegram dept
            '-485461445'            //id telegram group MTC   
        ];

        $message = 'Work order *' . $id_wo . '* => ' . $data['wo']['nama_wo'] . '
Sedang dalam proses pengerjaan
Detail aktifitas : 
- ' . $_POST['tanggal-' . $jml] . ' => ' . $_POST['activity-' . $jml] . ' (' . $_POST['status-' . $jml] . ')
Dept. ' . $data['wo']['nama_dept'];

        if ($this->models('activity_model')->updateallactivity($_POST) >= 0) {
            Flasher::setFlash('Berhasil', 'diupdate', 'success', 'activity', '');
            foreach ($chat_id as $id) {
                BotTelegram::sendMessage($message, $id);
            }
            header('Location: ' . BASEURL . '/workorder/detail/' . $id_wo);
            exit;
        } else {
            Flasher::setFlash('Gagal', 'diupdate', 'danger', 'activity', '');
            header('Location: ' . BASEURL . '/activity');
            exit;
        }
    }

    //update activity per satu id
    public function updateactivity()
    {
        $id_wo = $_POST['id_wo'];

        // get data id telegram dept & membuat pesan notifikasi
        $data['wo'] = $this->models('workorder_model')->getDetailWO($id_wo);

        $chat_id = [
            $data['wo']['telegram'], //id telegram dept
            '-485461445'            //id telegram group MTC   
        ];

        $message = 'Work order *' . $id_wo . '* => ' . $data['wo']['nama_wo'] . '
Sedang dalam proses pengerjaan
Detail aktifitas : 
- ' . $_POST['tanggal'] . ' => ' . $_POST['activity'] . ' (' . $_POST['status'] . ')
Dept. ' . $data['wo']['nama_dept'];

        if ($this->models('activity_model')->updateactivity($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'diupdate', 'success', 'activity', '');
            foreach ($chat_id as $id) {
                BotTelegram::sendMessage($message, $id);
            }
            header('Location: ' . BASEURL . '/activity');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'diupdate', 'danger', 'activity', '');
            header('Location: ' . BASEURL . '/activity');
            exit;
        }
    }

    //hapus data activity
    public function hapus($id_activity)
    {
        if ($this->models('activity_model')->hapusactivity($id_activity) > 0) {
            Flasher::setFlash('Berhasil', 'dihapus', 'success', 'activity', '');
            header('Location: ' . BASEURL . '/activity');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'dihapus', 'danger', 'activity', '');
            header('Location: ' . BASEURL . '/activity');
            exit;
        }
    }

    public function getCompleted()
    {
        echo json_encode($this->models('activity_model')->getCompleted($_POST['id_wo']));
    }
}
