<?php

class activity_model
{

    private $db;


    public function __construct()
    {
        $this->db = new Database();
    }

    //data activity
    public function dataactivity()
    {
        $query = 'SELECT activity.id_activity, activity.aktual, activity.tgl_activity, activity.nama_activity, activity.status, work_order.id_wo, work_order.nama_wo, work_order.status as wo_status, department.kode, teknisi.nama_teknisi FROM activity 
        JOIN work_order ON work_order.id_wo=activity.id_wo 
        JOIN department ON work_order.department=department.id_dept 
        JOIN teknisi ON teknisi.id_teknisi=work_order.id_teknisi 
        ORDER BY work_order.id_wo DESC, activity.status DESC, activity.tgl_activity ASC';
        $this->db->query($query);
        return $this->db->resultSet();
    }

    //mengambil informasi nama wo
    public function getnamaWO($id_wo)
    {
        $query = 'SELECT id_wo, nama_wo FROM work_order WHERE id_wo =:id_wo';
        $this->db->query($query);
        $this->db->bind('id_wo', $id_wo);
        return $this->db->resultSet();
    }

    //menampilkan data work order yang dalam proses waiting list & inprogress untuk tambah activity
    public function getWolist()
    {
        $query = "SELECT id_wo, nama_wo, id, progress FROM (SELECT a.nama_wo, a.id_wo, max(id_progress) AS id FROM work_order a JOIN detail_progress b ON a.id_wo=b.id_wo GROUP BY id_wo) AS wo JOIN progress on id=id_progress WHERE id=6 OR id=7 GROUP BY id_wo";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    //mengambil data activity berdasarkan ID untuk proses update
    public function getactivitybyID($id_activity)
    {
        $query = 'SELECT activity.id_activity, activity.aktual, activity.tgl_activity, activity.nama_activity, activity.status, work_order.id_wo, work_order.nama_wo FROM activity 
        JOIN work_order ON work_order.id_wo=activity.id_wo 
        WHERE id_activity =:id_activity';
        $this->db->query($query);
        $this->db->bind('id_activity', $id_activity);
        return $this->db->single();
    }

    //mengambil data activity berdasarkan id_wo untuk proses update
    public function getactivitybyWO($id_wo)
    {
        $query = "SELECT activity.id_activity, activity.aktual, activity.tgl_activity, activity.nama_activity, activity.status, work_order.id_wo, work_order.nama_wo FROM activity 
        JOIN work_order ON work_order.id_wo=activity.id_wo 
        WHERE work_order.id_wo =:id_wo ORDER BY id_activity";
        $this->db->query($query);
        $this->db->bind('id_wo', $id_wo);
        return $this->db->resultSet();
    }


    //tambah data activity
    public function tambahactivity($data, $status, $durasi, $isNull, $rowInProgress)
    {
        if (is_null($isNull)) {
            //update status detail progress waiting list menjadi closed
            $progress = "UPDATE detail_progress SET finish =:finish, status =:status, durasi =:durasi WHERE id_wo =:id_wo AND id_progress = 6";
            $this->db->query($progress);
            $this->db->bind('finish', $data['tanggal-1']);
            $this->db->bind('id_wo', $data['id_wo']);
            $this->db->bind('status', $status);
            $this->db->bind('durasi', $durasi);
            $this->db->execute();
        }

        //insert detail status in progress setelah waiting list
        if ($rowInProgress == 0) {
            $progress = "INSERT INTO detail_progress VALUES (NULL, :id_progress, :id_wo, :start, NULL, NULL, NULL)";
            $this->db->query($progress);
            $this->db->bind('id_progress', 7); //in progress
            $this->db->bind('id_wo', $data['id_wo']);
            $this->db->bind('start', $data['tanggal-1']);
            $this->db->execute();
        }


        $query = "INSERT INTO activity VALUES (NULL, :tgl_activity, :nama_activity, :status, :id_wo, NULL)";

        $totaldata = $_POST['totaldata'];

        for ($i = 1; $i <= $totaldata; $i++) {

            $this->db->query($query);
            $this->db->bind('tgl_activity', $data['tanggal-' . $i]);
            $this->db->bind('nama_activity', $data['activity-' . $i]);
            $this->db->bind('status', $data['status-' . $i]);
            $this->db->bind('id_wo', $data['id_wo']);
            // $this->db->bind('aktual', $data['aktual-' . $i]);

            $this->db->execute();
        }

        return $this->db->rowCount();
    }

    //update data activity
    public function updateactivity($data)
    {
        $query = "UPDATE activity SET nama_activity =:nama_activity, tgl_activity =:tgl_activity, aktual =:aktual, status =:status WHERE id_activity =:id_activity";
        $this->db->query($query);
        $this->db->bind('id_activity', $data['id_activity']);
        $this->db->bind('nama_activity', $data['activity']);
        $this->db->bind('tgl_activity', $data['tanggal']);
        $this->db->bind('status', $data['status']);
        $this->db->bind('aktual', $data['aktual']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    //update semua activity berdasarkan id_wo dan id_activity
    public function updateallactivity($data)
    {
        $query = "UPDATE activity SET nama_activity =:nama_activity, tgl_activity =:tgl_activity, aktual =:aktual, status =:status 
        WHERE id_activity =:id_activity AND id_wo =:id_wo";

        $ttl = $data['jmldata'];

        for ($i = 1; $i <= $ttl; $i++) {

            $this->db->query($query);
            $this->db->bind('id_activity', $data['id-' . $i]);
            $this->db->bind('nama_activity', $data['activity-' . $i]);
            $this->db->bind('tgl_activity', $data['tanggal-' . $i]);
            $this->db->bind('aktual', $data['aktual-' . $i]);
            $this->db->bind('status', $data['status-' . $i]);
            $this->db->bind('id_wo', $data['id_wo']);
            $this->db->execute();
        }

        return $this->db->rowCount();
    }

    //hapus data activity
    public function hapusactivity($id_activity)
    {
        $query = "DELETE FROM activity WHERE id_activity =:id_activity";
        $this->db->query($query);
        $this->db->bind('id_activity', $id_activity);
        $this->db->execute();
        return $this->db->rowCount();
    }

    //fungsi untuk mengecek apakah semua aktifitas sudah completed 
    public function getCompleted($id_wo)
    {
        $query = "SELECT count(id_activity) FROM activity WHERE id_wo = '$id_wo' AND status != 'Completed'";
        $this->db->query($query);
        return $this->db->numRow();
    }
}
