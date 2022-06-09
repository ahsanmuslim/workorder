<?php

class workorder extends Controller
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
        $data['title'] = "Work Order";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $dept = $data['user']['id_dept'];
        $id_role = $data['user']['role'];
        $data['dataWorkorder'] = $this->models('workorder_model')->dataWorkorder($dept, $id_role);
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('workorder/index', $data);
        $this->views('templates/footer');
    }

    //controller untuk meminta data detail problem
    public function getProblem()
    {
        echo json_encode($this->models('problem_model')->getproblembyWO($_POST['id_wo']));
    }

    public function print($id_wo)
    {
        $data['detailWO'] = $this->models('workorder_model')->getDetailWO($id_wo);
        $data['detailMaterial'] = $this->models('workorder_model')->getDetailRM($id_wo);
        $this->views('workorder/print', $data);
    }

    public function tambah()
    {
        $data['title'] = "Work Order";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['pic'] = $this->models('user_model')->getStaff();
        $data['kategori'] = $this->models('general_model')->datakategori();
        $data['lokasi'] = $this->models('corporate_model')->dataLokasi();
        $data['dept'] = $this->models('corporate_model')->dataDept();
        $data['kategori'] = $this->models('general_model')->datakategori();
        $data['material'] = $this->models('material_model')->dataMaterial();
        $data['teknisi'] = $this->models('teknisi_model')->datateknisi();
        $data['code'] = $this->models('workorder_model')->getKodeWO();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('workorder/add', $data);
        $this->views('templates/footer');
    }


    public function detail($id_wo)
    {
        $data['title'] = "Work Order";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['detailWO'] = $this->models('workorder_model')->getDetailWO($id_wo);
        $data['detailMaterial'] = $this->models('workorder_model')->getDetailRM($id_wo);
        $data['Activity'] = $this->models('workorder_model')->getActivity($id_wo);
        $data['Progress'] = $this->models('workorder_model')->getDetailProgress($id_wo);
        $data['lastprogress'] = $this->models('workorder_model')->getProgress($id_wo);
        $data['detailBeli'] = $this->models('pembelian_model')->detailBelibyWO($id_wo);
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('workorder/detail', $data);
        $this->views('templates/footer');
    }


    public function update($id_wo)
    {
        $data['title'] = "Work Order";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['kategori'] = $this->models('general_model')->datakategori();
        $data['lokasi'] = $this->models('corporate_model')->dataLokasi();
        $data['dept'] = $this->models('corporate_model')->dataDept();
        $data['kategori'] = $this->models('general_model')->datakategori();
        $data['material'] = $this->models('material_model')->dataMaterial();
        $data['detailWO'] = $this->models('workorder_model')->getDetailWO($id_wo);
        $data['detailMaterial'] = $this->models('workorder_model')->getDetailRM($id_wo);
        $data['Activity'] = $this->models('workorder_model')->getActivity($id_wo);
        $data['Progress'] = $this->models('workorder_model')->getDetailProgress($id_wo);
        $data['teknisi'] = $this->models('teknisi_model')->datateknisi();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('workorder/edit', $data);
        $this->views('templates/footer');
    }


    public function approve($id_wo, $id_role, $notes)
    {
        $aksi = 'disetujui';
        $approve = '';
        $id_progress = '';
        
        //script untuk menghitung durasi progres
        if ($id_role  == 3) { //dept head
            $id_progress = 1;
            $approve = 'Dept Head';
        } elseif ($id_role ==7){ //jika Hr Dept Head
            if($notes == 'null'){
                $id_progress = 1;
                $approve = "Dept Head";
            } else {
                $id_progress = 2;//diperiksa
                $approve = 'HR Dept Head';
                $aksi = 'diperiksa';
            }
        } elseif ($id_role == 6) { //admin MTC
            $id_progress = 2;
            $approve = 'Admin MTC';
            $aksi = 'diverifikasi';
        } elseif ($id_role == 5) {
            $id_progress = 3; //div head
            $approve = 'Division Head';
        }
        // var_dump($id_progress);

        $data['wo'] = $this->models('workorder_model')->getDetailWO($id_wo);


        $chat_id = [
            $data['wo']['telegram'], //id telegram dept
            MTCTelegram            //id telegram group MTC   
        ];


        $message = 'Work order sudah ' . $aksi . ' ' . $approve . '.
*' . $data['wo']['id_wo'] . '* => ' . $data['wo']['nama_wo'] . '
PIC : ' . $data['wo']['nama_user'] . ' (' . $data['wo']['nama_dept'] . ')';

        $data['progress'] = $this->models('general_model')->getprogressbyID($id_progress);
        $data['detail'] = $this->models('general_model')->getdetailbyID($id_progress, $id_wo);
        $standard = (int)$data['progress']['target'];

        $startDate = $data['detail']['start'];
        $endDate = date('Y-m-d');
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
        } else {
            $status = 'advance';
        }

        if ($this->models('workorder_model')->approve($id_wo, $id_role, $status, $id_progress, $durasi, $approve) > 0) {
            Flasher::setFlash('', $aksi.' '.$approve, 'success', 'work order', '');
            foreach ($chat_id as $id) {
                BotTelegram::sendMessage($message, $id);
            }
            header('Location: ' . BASEURL . '/workorder');
            exit;
        } else {
            Flasher::setFlash('not', $aksi, 'danger', 'work order', '');
            header('Location: ' . BASEURL . '/workorder');
            exit;
        }
    }

    public function tambahWorkorder()
    {
        // var_dump($_POST);    
        // get data id telegram dept & membuat pesan notifikasi
        $data['dept'] = $this->models('corporate_model')->getIDTelegram($_POST['dept']);
        $chat_id = $data['dept']['telegram'];
        $nama_dept = $data['dept']['nama_dept'];

        $data['user'] = $this->models('user_model')->getUserbyID($_POST['pic']);
        $pic = $data['user']['nama_user'];
        

        $message = 'Work order berhasil dibuat.
*' . $_POST['id_wo'] . '* => ' . $_POST['nama_wo'] . '
PIC : ' . $pic . ' (' . $nama_dept . ')';

        $file_lama = "default.jpg";

        $upload_gambar = $_FILES['drawing']['name'];


        if ($upload_gambar) {

            $ekstensi_std = array('png', 'jpg', 'jpeg');
            $nama_file = $upload_gambar;
            $x = explode('.', $nama_file);
            $ekstensi = strtolower(end($x));
            $ukuran = $_FILES['drawing']['size'];
            $file_temp = $_FILES['drawing']['tmp_name'];
            //untuk mengetahui jumlah material
            $material = array_filter($_POST['material']);
            $count = count($material);

            //mengecek apakah ekstensi gambar sesuai
            if (in_array($ekstensi, $ekstensi_std) === true) {
                if ($ukuran < 2000000) {
                    move_uploaded_file($file_temp, 'img/drawing/' . $nama_file);
                    if ($file_lama != 'default.jpg' && $file_lama != $nama_file) {
                        unlink('img/drawing/' . $file_lama);
                    }
                    if ($this->models('workorder_model')->tambahWorkorder($_POST, $nama_file, $count) > 0 or $upload_gambar) {
                        Flasher::setFlash('Berhasil', 'ditambahkan', 'success', 'workorder', '');
                        BotTelegram::sendMessage($message, $chat_id);
                        header('Location: ' . BASEURL . '/workorder');
                        exit;
                    } else {
                        Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'workorder', '');
                        header('Location: ' . BASEURL . '/workorder');
                        exit;
                    }
                } else {
                    Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'workorder', 'Ukuran gambar terlalu besar !!');
                    header('Location: ' . BASEURL . '/workorder');
                    exit;
                }
            } else {
                Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'workorder', 'Ekstensi gambar tidak sesuai !!');
                header('Location: ' . BASEURL . '/workorder');
                exit;
            }
        } else {
            if ($this->models('workorder_model')->tambahWorkorder($_POST, $nama_file, $count) > 0) {
                Flasher::setFlash('Berhasil', 'ditambahkan', 'success', 'work order', '');
                BotTelegram::sendMessage($message, $chat_id);
                header('Location: ' . BASEURL . '/workorder');
                exit;
            } else {
                Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'workorder', '');
                header('Location: ' . BASEURL . '/workorder');
                exit;
            }
        }

    
    }

    public function updateWorkorder()
    {
        // var_dump($_POST);
        $file_lama = "default.jpg";

        $upload_gambar = $_FILES['drawing']['name'];

        if (empty($upload_gambar)) {

            $nama_file = $_POST['drawing-lama'];

            if ($this->models('workorder_model')->updateWorkorder($_POST, $nama_file) > 0) {
                Flasher::setFlash('Berhasil', 'diupdate', 'success', 'work order', '');
                header('Location: ' . BASEURL . '/workorder');
                // echo "<script>window.location.href='../BASEURL/workorder';</script>";
                exit;
            } else {
                Flasher::setFlash('Gagal', 'diupdate', 'danger', 'workorder', '');
                header('Location: ' . BASEURL . '/workorder');
                // echo "<script>window.location.href='../BASEURL/workorder';</script>";
                exit;
            }
        } else {

            $nama_file = $upload_gambar;
            $ekstensi_std = array('png', 'jpg', 'jpeg');
            $x = explode('.', $nama_file);
            $ekstensi = strtolower(end($x));
            $ukuran = $_FILES['drawing']['size'];
            $file_temp = $_FILES['drawing']['tmp_name'];


            //mengecek apakah ekstensi gambar sesuai
            if (in_array($ekstensi, $ekstensi_std) === true) {
                if ($ukuran < 2000000) {
                    move_uploaded_file($file_temp, 'img/drawing/' . $nama_file);
                    if ($file_lama != 'default.jpg' && $file_lama != $nama_file) {
                        unlink('img/drawing/' . $file_lama);
                    }
                    if ($this->models('workorder_model')->updateWorkorder($_POST, $nama_file) > 0 or $upload_gambar) {
                        Flasher::setFlash('Berhasil', 'diupdate', 'success', 'workorder', '');
                        header('Location: ' . BASEURL . '/workorder');
                        exit;
                    } else {
                        Flasher::setFlash('Gagal', 'diupdate', 'danger', 'workorder', '');
                        header('Location: ' . BASEURL . '/workorder');
                        exit;
                    }
                } else {
                    Flasher::setFlash('Gagal', 'diupdate', 'danger', 'workorder', 'Ukuran gambar terlalu besar !!');
                    header('Location: ' . BASEURL . '/workorder');
                    exit;
                }
            } else {
                Flasher::setFlash('Gagal', 'diupdate', 'danger', 'workorder', 'Ekstensi gambar tidak sesuai !!');
                header('Location: ' . BASEURL . '/workorder');
                exit;
            }
        }
    }

    public function import ()
    {
        $data['title'] = "Work Order";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('workorder/import', $data);
        $this->views('templates/footer');
    }

    public function importData ()
    {
        // var_dump($_FILES);
        if ( $this->models('workorder_model')->importData() > 0 ){
            Flasher::setFlash('Berhasil', 'diimport', 'success', 'work order', '');
            header ('Location: '. BASEURL . '/workorder');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'diimport', 'danger','work order', '');
            header ('Location: '. BASEURL . '/workorder');
            exit;
        }
    }

    public function download ()
    {
        header('Location: ' . BASEURL . '/file/sample/workorder.xlsx');
    }

    public function kirimphoto ()
    {
        $chat_id = '747278008';
        // $file = 'C:\xampp\htdocs\myapps\project-monitoring\public\img\hasil\agp.jpg';
        $file = '/home/workorder/public_html/public/img/hasil/AGP.jpg';
        $caption = 'Test kirim gambar via Telegram';

        BotTelegram::sendPhoto($chat_id, $file, $caption);

        header ('Location: '. BASEURL . '/workorder');
        exit;
    }

}
