<?php

class pembelian extends Controller
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
        $data['title'] = "Purchasing";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['pembelian'] = $this->models('pembelian_model')->dataPembelian();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('pembelian/index', $data);
        $this->views('templates/footer');
    }

    public function detail($id_pembelian)
    {
        $data['title'] = "Purchasing";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['detail'] = $this->models('pembelian_model')->detailPembelian($id_pembelian);
        $data['detailBeli'] = $this->models('pembelian_model')->detailMaterial($id_pembelian);
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('pembelian/detail', $data);
        $this->views('templates/footer');
    }

    public function tambah()
    {
        $data['title'] = "Purchasing";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $dept = $data['user']['nama_dept'];
        $id_role = $data['user']['role'];
        $data['workorder'] = $this->models('workorder_model')->getCashout();
        $data['supplier'] = $this->models('corporate_model')->dataSupplier();
        $data['material'] = $this->models('material_model')->dataMaterial();
        $data['code'] = $this->models('pembelian_model')->getKodebeli();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('pembelian/add', $data);
        $this->views('templates/footer');
    }


    public function update($id_pembelian)
    {
        $data['title'] = "Purchasing";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['supplier'] = $this->models('corporate_model')->dataSupplier();
        $data['material'] = $this->models('material_model')->dataMaterial();
        $data['beli'] = $this->models('pembelian_model')->detailPembelian($id_pembelian);
        $data['detailBeli'] = $this->models('pembelian_model')->detailMaterial($id_pembelian);
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('pembelian/edit', $data);
        $this->views('templates/footer');
    }

    public function tambahPembelian()
    {
        $id_wo = $_POST['id_wo'];
        //script untuk menghitung durasi progres
        $data['progress'] = $this->models('general_model')->getprogressbyID(5);
        $data['detail'] = $this->models('general_model')->getdetailbyID(5, $id_wo);
        $standard = (int)$data['progress']['target'];

        $startDate = $data['detail']['start'];
        $endDate = $_POST['tanggal'];
        $data['libur'] = $this->models('general_model')->dataharilibur($startDate, $endDate);
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

        // get data id telegram dept & membuat pesan notifikasi
        $data['wo'] = $this->models('workorder_model')->getDetailWO($_POST['id_wo']);

        $chat_id = [
            $data['wo']['telegram'], //id telegram dept
            '-485461445'            //id telegram group MTC   
        ];

        $message = 'Work order *' . $id_wo . '* => ' . $data['wo']['nama_wo'] . ' :
Sudah dilakukan proses pembelian material 
Work order masuk dalam waiting list 
Dept. ' . $data['wo']['nama_dept'];

        $count = count($_POST['id_material']);
        if ($this->models('pembelian_model')->tambahPembelian($_POST, $count, $status) > 0) {
            Flasher::setFlash('Berhasil', 'ditambahkan', 'success', 'pembelian', '');
            foreach ($chat_id as $id) {
                BotTelegram::sendMessage($message, $id);
            }
            header('Location: ' . BASEURL . '/pembelian');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'pembelian', '');
            header('Location: ' . BASEURL . '/pembelian');
            exit;
        }
    }

    public function updatePembelian()
    {
        $id_wo = $_POST['id_wo'];
        //script untuk menghitung durasi progres
        $data['progress'] = $this->models('general_model')->getprogressbyID(5);
        $data['detail'] = $this->models('general_model')->getdetailbyID(5, $id_wo);
        $standard = (int)$data['progress']['target'];

        $startDate = $data['detail']['start'];
        $endDate = $_POST['tanggal'];
        $data['libur'] = $this->models('general_model')->dataharilibur($startDate, $endDate);
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

        $count = count($_POST['id_material']);
        if ($this->models('pembelian_model')->updatePembelian($_POST, $count, $status) > 0) {
            Flasher::setFlash('Berhasil', 'diupdate', 'success', 'pembelian', '');
            header('Location: ' . BASEURL . '/pembelian');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'diupdate', 'danger', 'pembelian', '');
            header('Location: ' . BASEURL . '/pembelian');
            exit;
        }
    }


    //hapus data PEMBELIAN
    public function hapus($id_pembelian)
    {
        if ($this->models('pembelian_model')->hapusPembelian($id_pembelian) > 0) {
            Flasher::setFlash('Berhasil', 'dihapus', 'success', 'pembelian', '');
            header('Location: ' . BASEURL . '/pembelian');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'dihapus', 'danger', 'pembelian', '');
            header('Location: ' . BASEURL . '/pembelian');
            exit;
        }
    }

    //controller untuk meminta data plan pembelian work order
    public function getPlanpembelian()
    {
        echo json_encode($this->models('workorder_model')->getWObyID($_POST['id_wo']));
    }

    //controller untuk mengecek apak uang sudah diambil atau belum
    public function getCash()
    {
        echo json_encode($this->models('kaskeluar_model')->getCash($_POST['id_wo']));
    }




}
