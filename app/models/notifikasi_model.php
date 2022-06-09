<?php

class notifikasi_model {

    private $table = 'notifikasi';
    private $db;  


    public function __construct ()
    {
        $this->db = new Database();
    }

    //menampilkan notifikasi di task menu
    public function getNotif ($id_user)
    {
        $query = "SELECT * FROM notifikasi WHERE id_user=:id_user AND readed = 0 ORDER BY tanggal DESC";
        $this->db->query($query);
        $this->db->bind('id_user', $id_user);
        return $this->db->resultSet();
    }

    //menampilkan notifikasi di task menu
    public function getNotifAll ($id_user)
    {
        $query = "SELECT * FROM notifikasi WHERE id_user=:id_user ORDER BY readed, tanggal DESC";
        $this->db->query($query);
        $this->db->bind('id_user', $id_user);
        return $this->db->resultSet();
    }

    public function notifReaded ($id_notif)
    {
        $query = "UPDATE notifikasi SET readed = 1 WHERE id_notif =:id_notif";
        $this->db->query($query);
        $this->db->bind('id_notif', $id_notif);
        $this->db->execute();
        return $this->db->rowCount();
    }
    
    //mengambil data Wo yang belum approve Div Head
    public function getnotyetApproveDiv()
    {
        $query = "SELECT work_order.tanggal, work_order.id_wo, work_order.department, department.nama_dept, work_order.nama_wo, work_order.plan_biaya, work_order.act_biaya, work_order.prioritas, work_order.status, work_order.approve_dept, work_order.approve_div, work_order.approve_hr, work_order.verified FROM work_order JOIN department ON work_order.department=department.id_dept WHERE work_order.approve_hr IS NOT NULL AND approve_div IS NULL ORDER BY status ASC, prioritas DESC, tanggal DESC";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    //mengambil data Wo yang belum approve HR Dept Head
    public function getnotyetApproveHR()
    {
        $query = "SELECT work_order.tanggal, work_order.id_wo, work_order.department, department.nama_dept, work_order.nama_wo, work_order.plan_biaya, work_order.act_biaya, work_order.prioritas, work_order.status, work_order.approve_dept, work_order.approve_div, work_order.verified, work_order.approve_hr FROM work_order JOIN department ON work_order.department=department.id_dept WHERE work_order.verified IS NOT NULL AND approve_hr IS NULL ORDER BY status ASC, prioritas DESC, tanggal DESC";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    //mengambil data Wo yang belum verify
    public function getnotyetVerify()
    {
        $query = "SELECT work_order.tanggal, work_order.id_wo, work_order.department, department.nama_dept, work_order.nama_wo, work_order.plan_biaya, work_order.act_biaya, work_order.prioritas, work_order.status, work_order.approve_dept, work_order.approve_div, work_order.verified, work_order.approve_hr FROM work_order JOIN department ON work_order.department=department.id_dept WHERE work_order.verified IS NULL AND approve_dept IS NOT NULL ORDER BY status ASC, prioritas DESC, tanggal DESC";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    //mengambil data Wo yang belum approve dept
    public function getnotyetApproveDept($dept)
    {
        $query = "SELECT work_order.tanggal, work_order.id_wo, work_order.department, department.nama_dept, work_order.nama_wo, work_order.plan_biaya, work_order.act_biaya, work_order.prioritas, work_order.status, work_order.approve_dept, work_order.approve_div, work_order.verified, work_order.approve_hr, user.nama_user FROM work_order JOIN department ON work_order.department=department.id_dept JOIN user ON work_order.create_by=user.id_user WHERE approve_dept IS NULL AND work_order.department =:dept  ORDER BY status ASC, prioritas DESC, tanggal DESC";
        $this->db->query($query);
        $this->db->bind('dept', $dept);
        return $this->db->resultSet();
    }

    //mengambil data Wo yang belum di receipt
    public function getnotyetReceipt($id_user)
    {
        $query = "SELECT id_wo, nama_wo, status, nomor, tgl_penyerahan, id, progress, id_user, nama_user, email FROM (SELECT a.nama_wo, a.id_wo, a.status, a.create_by AS id_user, c.nama_user, c.email, d.id_serahterima AS nomor, d.tgl_penyerahan, max(id_progress) AS id FROM work_order a JOIN detail_progress b ON a.id_wo=b.id_wo JOIN user c ON a.create_by=c.id_user JOIN serah_terima d ON d.id_wo=a.id_wo GROUP BY id_wo) AS wo JOIN progress on id=id_progress WHERE id=8 AND status ='Open' AND id_user =:id_user";
        $this->db->query($query);
        $this->db->bind('id_user', $id_user);
        return $this->db->resultSet();
    }


    //menambah notifikasi data HR Dept head & Admin MTC & Div HEad
    public function tambahNotif ($data)
    {
        $id_user = $data['user']['id_user'];
        $nama = $data['user']['nama_user'];
        $role = $data['user']['role'];
        $link = 'workorder';
        $jam = intval(date('H'));
        $salam = '';
        $aksi = '';
        if($jam > 0 && $jam < 12){
            $salam = 'Selamat pagi';
        } elseif ($jam >= 12 && $jam < 18){
            $salam = 'Selamat siang';
        } else {
            $salam = 'Selamat malam';
        }

        //menemtukan aksi
        if($role == 5 || $role == 3){
            $aksi = 'disetujui';
        } elseif ($role == 7){
            $aksi = 'diperiksa';
        } elseif ($role == 6){
            $aksi = 'diverifikasi';
        }
        
        //memasukan dta notif ke database
        foreach ($data['approve'] as $app){            
            $pesan = $salam.' Bapak/Ibu '.$nama.', Ada pengajuan work order ('.$app['nama_wo'].') dari Dept '.$app['nama_dept'].' yang harus '.$aksi;

            $query = "INSERT INTO notifikasi VALUES ( NULL, NULL, :pesan, :link, 0, :id_user, :id_wo)";
            $this->db->query($query);
            $this->db->bind('pesan', $pesan);
            $this->db->bind('link', $link);
            $this->db->bind('id_user', $id_user);
            $this->db->bind('id_wo', $app['id_wo']);
            $this->db->execute();
        }

        return $this->db->rowCount();
    }

    //menambah notifikasi data Dept head 
    public function tambahNotifDept ($data)
    {
        $id_user = $data['user']['id_user'];
        $nama = $data['user']['nama_user'];

        $link = 'workorder';
        $jam = intval(date('H'));
        $salam = '';

        if($jam > 0 && $jam < 12){
            $salam = 'Selamat pagi';
        } elseif ($jam >= 12 && $jam < 18){
            $salam = 'Selamat siang';
        } else {
            $salam = 'Selamat malam';
        }

        //memasukan dta notif ke database
        foreach ($data['approveDept'] as $app){            
            $pesan = $salam.' Bapak/Ibu. '.$nama.', Ada pengajuan work order ('.$app['nama_wo'].') dari '.$app['nama_user'].' yang harus disetujui.';

            $query = "INSERT INTO notifikasi VALUES ( NULL, NULL, :pesan, :link, 0, :id_user, :id_wo)";
            $this->db->query($query);
            $this->db->bind('pesan', $pesan);
            $this->db->bind('link', $link);
            $this->db->bind('id_user', $id_user);
            $this->db->bind('id_wo', $app['id_wo']);
            $this->db->execute();
        }

        return $this->db->rowCount();
    }

    //create notifikasi handover 
    public function tambahNotifReceipt($data)
    {
        $id_user = $data['user']['id_user'];
        $nama = $data['user']['nama_user'];

        $link = 'serahterima';
        $jam = intval(date('H'));
        $salam = '';

        if($jam > 0 && $jam < 12){
            $salam = 'Selamat pagi';
        } elseif ($jam >= 12 && $jam < 18){
            $salam = 'Selamat siang';
        } else {
            $salam = 'Selamat malam';
        }

        //memasukan dta notif ke database
        foreach ($data['receipt'] as $rec){            
            $pesan = $salam.' Bapak/Ibu. '.$nama.', Work order ('.$rec['nama_wo'].') yang Anda ajukan telah selesai dikerjakan. Silahkan melakukan proses Handover agar status work order closed.';

            $query = "INSERT INTO notifikasi VALUES ( NULL, NULL, :pesan, :link, 0, :id_user, :nomor)";
            $this->db->query($query);
            $this->db->bind('pesan', $pesan);
            $this->db->bind('link', $link);
            $this->db->bind('id_user', $id_user);
            $this->db->bind('nomor', $rec['nomor']);
            $this->db->execute();
        }

        return $this->db->rowCount();
    }

 }