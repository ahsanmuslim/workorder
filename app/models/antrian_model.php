<?php

class antrian_model {

    private $table = 'work_order';
    private $db;  


    public function __construct ()
    {
        $this->db = new Database();
    }

    //menampilkan data work order yang dalam proses pengerjaan untuk serah terima Work order
    public function getWOWaitinglist ()
    {
        $query = "SELECT tanggal, id_wo, nama_wo, prioritas, nama_teknisi, status, department, kode, id, progress, estimasi 
        FROM (SELECT a.tanggal, a.prioritas, a.status, a.department, a.nama_wo, a.id_wo, a.id_teknisi, a.estimasi, max(id_progress) AS id FROM work_order a JOIN detail_progress b ON a.id_wo=b.id_wo GROUP BY id_wo) AS wo 
        JOIN progress on id=id_progress 
        JOIN teknisi on teknisi.id_teknisi=wo.id_teknisi 
        JOIN department on wo.department=department.id_dept 
        WHERE id=6 ORDER BY prioritas DESC, tanggal";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    //menampilkan data work order yang dalam proses pengerjaan untuk serah terima Work order
    public function getWOInprogress ()
    {
        $query = "SELECT id_wo, nama_wo, tanggal, id_teknisi, nama_teknisi, department, nama_dept, id, progress, start 
        FROM (SELECT a.id_teknisi, a.department, a.nama_wo, a.id_wo, a.tanggal, max(id_progress) AS id, max(start) AS start, teknisi.nama_teknisi FROM work_order a 
        JOIN detail_progress b ON a.id_wo=b.id_wo 
        JOIN teknisi ON a.id_teknisi=teknisi.id_teknisi GROUP BY id_wo) AS wo 
        JOIN progress on id=id_progress
        JOIN department on department=department.id_dept 
        WHERE id=7";
        $this->db->query($query);
        return $this->db->resultSet();
    }


    public function getActivityprogress ($id_wo)
    {
    	$query = "SELECT nama_wo, count(nama_activity) as ttl, COUNT(CASE WHEN activity.status ='Completed' THEN activity.status ELSE NULL END) as completed,COUNT(CASE WHEN activity.status ='Completed' THEN activity.status ELSE NULL END) / count(nama_activity) as pros FROM work_order JOIN activity ON work_order.id_wo = activity.id_wo WHERE work_order.id_wo =:id_wo";
    	$this->db->query($query);
    	$this->db->bind ( 'id_wo', $id_wo );
    	return $this->db->resultSet();
    }

    public function getDataActivity($id_wo)
    {
    	$query = "SELECT * FROM activity WHERE id_wo =:id_wo ORDER BY tgl_activity ASC";
    	$this->db->query($query);
    	$this->db->bind ( 'id_wo', $id_wo );
    	return $this->db->resultSet();
    }


 }