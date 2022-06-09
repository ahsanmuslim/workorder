<?php

class kaskeluar extends Controller
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
        $data['title'] = "Cash Out";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['kaskeluar'] = $this->models('kaskeluar_model')->datakaskeluar();
        $data['woapprove'] = $this->models('workorder_model')->getDataWOapprove();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('kaskeluar/index', $data);
        $this->views('templates/footer');
    }

    public function tambah($id_wo)
    {
        $data['title'] = "Cash Out";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['workorder'] = $this->models('workorder_model')->getDetailWO($id_wo);
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('kaskeluar/add', $data);
        $this->views('templates/footer');
    }

    public function print($id_wo)
    {
        $data['detailWO'] = $this->models('workorder_model')->getDetailWO($id_wo);
        $data['detailMaterial'] = $this->models('workorder_model')->getDetailRM($id_wo);
        $this->views('workorder/print', $data);
    }

    public function nocost($id_wo)
    {
        // get data id telegram dept & membuat pesan notifikasi
        $data['wo'] = $this->models('workorder_model')->getDetailWO($id_wo);

        $chat_id = [
            $data['wo']['telegram'], //id telegram dept
            '-485461445'            //id telegram group MTC   
        ];

        $message = 'Work order *' . $_POST['id_wo'] . '* => ' . $data['wo']['nama_wo'] . ' :
Tanpa pengajuan biaya, Work order langsung masuk waiting list.
Dept. ' . $data['wo']['nama_dept'];

        if ($this->models('kaskeluar_model')->nocost($id_wo) > 0) {
            Flasher::setFlash('Berhasil', 'diupdate', 'success', '', '');
            foreach ($chat_id as $id) {
                BotTelegram::sendMessage($message, $id);
            }
            header('Location: ' . BASEURL . '/workorder');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'diupdate', 'danger', '', '');
            header('Location: ' . BASEURL . '/workorder');
            exit;
        }
    }

    public function edit($id_dana)
    {
        $data['title'] = "Cash Out";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['kaskeluar'] = $this->models('kaskeluar_model')->getkaskeluarbyID($id_dana);
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('kaskeluar/edit', $data);
        $this->views('templates/footer');
    }


    public function tambahkaskeluar()
    {
        // get data id telegram dept & membuat pesan notifikasi
        $data['wo'] = $this->models('workorder_model')->getDetailWO($_POST['id_wo']);

        $chat_id = [
            $data['wo']['telegram'], //id telegram dept
            '-485461445'            //id telegram group MTC   
        ];

        $message = 'Work order *' . $_POST['id_wo'] . '* => ' . $data['wo']['nama_wo'] . ' :
Sedang dalam proses pengajuan Dana ke Finance.
Dept. ' . $data['wo']['nama_dept'];

        if ($this->models('kaskeluar_model')->tambahkaskeluar($_POST) > 0) {
            Flasher::setFlash('Berhasil', 'ditambahkan', 'success', 'pengajuan kas', '');
            foreach ($chat_id as $id) {
                BotTelegram::sendMessage($message, $id);
            }
            header('Location: ' . BASEURL . '/kaskeluar');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'pengajuan kas', '');
            header('Location: ' . BASEURL . '/kaskeluar');
            exit;
        }
    }

    public function updatekaskeluar()
    {
        //script untuk menghitung durasi progres
        $data['progress'] = $this->models('general_model')->getprogressbyID(4);
        $standard = (int)$data['progress']['target'];

        $startDate = $_POST['tanggal'];
        $endDate = $_POST['tgl_terima'];
        $data['libur'] = $this->models('general_model')->dataharilibur($startDate, $endDate);
        // $endDate = "2021-01-22";
        $holidays = [];

        foreach ($data['libur'] as $libur) :
            $holidays[] = $libur['tanggal'];
        endforeach;

        $durasi = WorkingDay::getWorkingDays($startDate, $endDate, $holidays);
        // echo $durasi;
        $status = 0;
        if ($durasi == $standard) {
            $status = 'on time';
        } elseif ($durasi > $standard) {
            $status = 'overdue';
        } else {
            $status = 'advance';
        }

        // get data id telegram dept & membuat pesan notifikasi
        $data['wo'] = $this->models('workorder_model')->getDetailWO($_POST['id_wo']);

        $chat_id = [
            $data['wo']['telegram'], //id telegram dept
            '-485461445'            //id telegram group MTC   
        ];

        $message = 'Work order *' . $_POST['id_wo'] . '* => ' . $data['wo']['nama_wo'] . '
Dana WO sudah diambil oleh ' . $_POST['pic'] . ' untuk pembelian material 
Dept. ' . $data['wo']['nama_dept'];

        if ($this->models('kaskeluar_model')->updatekaskeluar($_POST, $status, $durasi) > 0) {
            Flasher::setFlash('Berhasil', 'diupdate', 'success', 'kaskeluar', '');
            foreach ($chat_id as $id) {
                BotTelegram::sendMessage($message, $id);
            }
            header('Location: ' . BASEURL . '/kaskeluar');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'diupdate', 'danger', 'kaskeluar', '');
            header('Location: ' . BASEURL . '/kaskeluar');
            exit;
        }
    }


    public function ready($id_dana, $id_wo)
    {
        // get data id telegram dept & membuat pesan notifikasi
        $data['wo'] = $this->models('workorder_model')->getDetailWO($id_wo);

        $chat_id = '-485461445'; //id telegram group MTC 

        $message = 'Work order *' . $data['wo']['id_wo'] . '* => ' . $data['wo']['nama_wo'] . ' :
Dana yang diajukan ke Finance sudah cair. 
Silahkan diambil !
Dept. ' . $data['wo']['nama_dept'];

        if ($this->models('kaskeluar_model')->ready($id_dana) > 0) {
            Flasher::setFlash('Berhasil', 'diupdate', 'success', 'status', '');
            BotTelegram::sendMessage($message, $chat_id);
            header('Location: ' . BASEURL . '/kaskeluar');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'diupdate', 'danger', 'status', '');
            header('Location: ' . BASEURL . '/kaskeluar');
            exit;
        }
    }

    //hapus data kaskeluar
    public function hapus($id_dana)
    {
        if ($this->models('kaskeluar_model')->hapuskaskeluar($id_dana) > 0) {
            Flasher::setFlash('Berhasil', 'dihapus', 'success', 'kaskeluar', '');
            header('Location: ' . BASEURL . '/kaskeluar');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'dihapus', 'danger', 'kaskeluar', '');
            header('Location: ' . BASEURL . '/kaskeluar');
            exit;
        }
    }
}
