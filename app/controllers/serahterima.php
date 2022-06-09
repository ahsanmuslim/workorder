<?php

class serahterima extends Controller
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
        $data['title'] = "Handover";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $dept = $data['user']['id_dept'];
        $id_role = $data['user']['role'];
        $data['serahterima'] = $this->models('serahterima_model')->dataserahterima($dept, $id_role);
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('serahterima/index', $data);
        $this->views('templates/footer');
    }

    public function tambah()
    {
        $data['title'] = "Handover";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['workorder'] = $this->models('workorder_model')->getInprogress();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('serahterima/add', $data);
        $this->views('templates/footer');
    }


    public function edit($id_serahterima)
    {
        $data['title'] = "Handover";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['handover'] = $this->models('serahterima_model')->getserahterimabyID($id_serahterima);
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $data['datauser'] = $this->models('user_model')->dataUser();
        $this->views('templates/header', $data);
        $this->views('serahterima/edit', $data);
        $this->views('templates/footer');
    }


    public function detail($id_serahterima)
    {
        $data['title'] = "Handover";
        $data['menu'] = $this->models('menu_model')->menuActive();
        $data['user'] = $this->models('user_model')->getUser();
        $data['handover'] = $this->models('serahterima_model')->getserahterimabyID($id_serahterima);
        $data['datauser'] = $this->models('user_model')->dataUser();
        $id_user = $data['user']['id_user'];
        $data['notif'] =$this->models('notifikasi_model')->getNotif($id_user);
        $data['userlist'] = $this->models('chat_model')->getUser($id_user);
        $data['unreaduser'] = $this->models('chat_model')->getUnreaduser($id_user);
        $this->views('templates/header', $data);
        $this->views('serahterima/detail', $data);
        $this->views('templates/footer');
    }


    public function tambahserahterima()
    {
        // var_dump($_POST);
        // var_dump($_FILES);
        $id_wo = $_POST['id_wo'];
        //script untuk menghitung durasi progres
        $data['progress'] = $this->models('general_model')->getprogressbyID(7);
        $data['detail'] = $this->models('general_model')->getdetailbyID(7, $id_wo);

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
Sudah selesai dikerjakan. Mohon segera diambil dan konfirmasi bahwa project telah diterima.
Dept. ' . $data['wo']['nama_dept'];

        $file_lama = "default.jpg";
        $upload_gambar = $_FILES['hasil']['name'];

        if ($upload_gambar) {

            $ekstensi_std = array('png', 'jpg', 'jpeg');
            $nama_file = $upload_gambar;
            $x = explode('.', $nama_file);
            $ekstensi = strtolower(end($x));
            $ukuran = $_FILES['hasil']['size'];
            $file_temp = $_FILES['hasil']['tmp_name'];


            //mengecek apakah ekstensi gambar sesuai
            if (in_array($ekstensi, $ekstensi_std) === true) {
                if ($ukuran < 2000000) { //file maksimal 2Mb (standard PHP Upload)
                    move_uploaded_file($file_temp, 'img/hasil/' . $nama_file);
                    if ($file_lama != 'default.jpg' && $file_lama != $nama_file) {
                        unlink('img/hasil/' . $file_lama);
                    }
                    if ($this->models('serahterima_model')->tambahserahterima($_POST, $nama_file, $status, $durasi) > 0 or $upload_gambar) {
                        Flasher::setFlash('Berhasil', 'ditambahkan', 'success', 'handover', '');

                        // $pathfile = 'C:\xampp\htdocs\myapps\project-monitoring\public\img\hasil\\'.$nama_file;
                        $pathfile = '/home/workorder/public_html/public/img/hasil/'.$nama_file;

                        foreach ($chat_id as $id) {
                            BotTelegram::sendPhoto($id, $pathfile, $message);
                        }
                        // BotTelegram::sendPhoto('747278008', $pathfile, $message);

                        header('Location: ' . BASEURL . '/serahterima');
                        exit;
                    } else {
                        Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'handover', '');
                        header('Location: ' . BASEURL . '/serahterima');
                        exit;
                    }
                } else {
                    Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'handover', 'Ukuran gambar terlalu besar !!');
                    header('Location: ' . BASEURL . '/serahterima');
                    exit;
                }
            } else {
                Flasher::setFlash('Gagal', 'ditambahkan', 'danger', 'handover', 'Ekstensi gambar tidak sesuai !!');
                header('Location: ' . BASEURL . '/serahterima');
                exit;
            }
        }
    }

    public function updateserahterima()
    {
        $id_wo = $_POST['id_wo'];
        //script untuk menghitung durasi progres
        $data['progress'] = $this->models('general_model')->getprogressbyID(8);
        $data['detail'] = $this->models('general_model')->getdetailbyID(8, $id_wo);

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
            '-1001218867340'            //id telegram group MTC   
        ];


        $message = 'Work order *' . $id_wo . '* => ' . $data['wo']['nama_wo'] . ' :
Status Closed. Project telah diterima oleh ' . $_POST['nama_user'] . '
Dept. ' . $data['wo']['nama_dept'];

        if ($this->models('serahterima_model')->updateserahterima($_POST, $status, $durasi) > 0) {
            Flasher::setFlash('Berhasil', 'diupdate', 'success', 'serahterima', '');
            foreach ($chat_id as $id) {
                BotTelegram::sendMessage($message, $id);
            }
            header('Location: ' . BASEURL . '/serahterima');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'diupdate', 'danger', 'serahterima', '');
            header('Location: ' . BASEURL . '/serahterima');
            exit;
        }
    }

    //hapus data serahterima
    public function hapus($id_serahterima)
    {
        if ($this->models('serahterima_model')->hapusserahterima($id_serahterima) > 0) {
            Flasher::setFlash('Berhasil', 'dihapus', 'success', 'serahterima', '');
            header('Location: ' . BASEURL . '/serahterima');
            exit;
        } else {
            Flasher::setFlash('Gagal', 'dihapus', 'danger', 'serahterima', '');
            header('Location: ' . BASEURL . '/serahterima');
            exit;
        }
    }
}
