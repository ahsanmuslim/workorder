<?php

class dashboard_model {

    private $table = 'work_order';
    private $db;  


    public function __construct ()
    {
        $this->db = new Database();
    }

    //data List up work order
    public function dataWorkorder ($dept, $id_role)
    {
        if ($id_role == 1 || $id_role == 5 || $id_role == 6 || $id_role == 7 || $id_role == 8){ //admin, MTC admin, HR Dept Head & Div head, Section Head MTC

            $query = "SELECT work_order.tanggal, work_order.id_wo, work_order.department, work_order.nama_wo, work_order.plan_biaya, work_order.act_biaya, work_order.prioritas, work_order.status, work_order.approve_dept, work_order.approve_div FROM work_order";
            $this->db->query($query);
            return $this->db->resultSet();

        } else {

            $query = "SELECT work_order.tanggal, work_order.id_wo, work_order.department, work_order.nama_wo, work_order.plan_biaya, work_order.act_biaya, work_order.prioritas, work_order.status, work_order.approve_dept, work_order.approve_div FROM work_order WHERE department =:department";
            $this->db->query($query);
            $this->db->bind ( 'department', $dept );
            return $this->db->resultSet();

        }

    }

    //data list open work order 
    public function workorderOpen ($dept, $id_role)
    {
        if ($id_role == 1 || $id_role == 5 || $id_role == 6 || $id_role == 7  || $id_role == 8){
            $query = "SELECT id_wo, nama_wo, plan_biaya FROM work_order WHERE status = 'Open' ";
            $this->db->query($query);
            return $this->db->resultSet();
        } else {
            $query = "SELECT id_wo, nama_wo, plan_biaya FROM work_order WHERE status = 'Open' AND department =:department";
            $this->db->query($query);
            $this->db->bind ( 'department', $dept );
            return $this->db->resultSet();
        }
    }

    //data list closed work order 
    public function workorderClosed ($dept, $id_role)
    {
        if ($id_role == 1 || $id_role == 5 || $id_role == 6 || $id_role == 7  || $id_role == 8){
            $query = "SELECT id_wo, nama_wo, plan_biaya FROM work_order WHERE status = 'Closed' ";
            $this->db->query($query);
            return $this->db->resultSet();
        } else {
            $query = "SELECT id_wo, nama_wo, plan_biaya FROM work_order WHERE status = 'Closed' AND department =:department";
            $this->db->query($query);
            $this->db->bind ( 'department', $dept );
            return $this->db->resultSet();
        }
    }

    public function grafikStatus ($dept, $id_role)
    {
        if ($id_role == 1 || $id_role == 5 || $id_role == 6 || $id_role == 7  || $id_role == 8){
            $query = "SELECT work_order.status, count(id_wo) as total FROM work_order GROUP BY status";
            $this->db->query($query);
            return $this->db->resultSet();
        } else {
            $query = "SELECT work_order.status, count(id_wo) as total FROM work_order WHERE department =:department GROUP BY status";
            $this->db->query($query);
            $this->db->bind ( 'department', $dept );
            return $this->db->resultSet();
        }
    }

    public function grafikJenis ($dept, $id_role)
    {
        if ($id_role == 1 || $id_role == 5 || $id_role == 6 || $id_role == 7  || $id_role == 8){
            $query = "SELECT kategori.nama_kategori, count(id_wo) as total FROM work_order LEFT JOIN kategori USING(id_kategori) GROUP BY kategori.nama_kategori";
            $this->db->query($query);
            return $this->db->resultSet();
        } else {
            $query = "SELECT kategori.nama_kategori, count(id_wo) as total FROM work_order LEFT JOIN kategori USING(id_kategori) WHERE department =:department GROUP BY kategori.nama_kategori";
            $this->db->query($query);
            $this->db->bind ( 'department', $dept );
            return $this->db->resultSet();
        }
    }

    public function grafikWO ($dept, $id_role)
    {
        if ($id_role == 1 || $id_role == 5 || $id_role == 6 || $id_role == 7  || $id_role == 8){
            $query = "SELECT MONTH(work_order.tanggal) as urutan,YEAR(work_order.tanggal) as tahun, CONCAT(LEFT(MONTHNAME(work_order.tanggal),3),'-',SUBSTRING(YEAR(work_order.tanggal),3,2) ) as bulan, count(id_wo) as total FROM work_order GROUP BY MONTHNAME(work_order.tanggal) ORDER BY tahun, urutan ASC";
            $this->db->query($query);
            return $this->db->resultSet();
        } else {
            $query = "SELECT MONTH(work_order.tanggal) as urutan, YEAR(work_order.tanggal) as tahun, CONCAT(LEFT(MONTHNAME(work_order.tanggal),3),'-',SUBSTRING(YEAR(work_order.tanggal),3,2) ) as bulan, count(id_wo) as total FROM work_order WHERE department =:department GROUP BY MONTHNAME(work_order.tanggal) ORDER BY tahun ASC, urutan ASC";
            $this->db->query($query);
            $this->db->bind ( 'department', $dept );
            return $this->db->resultSet();
        }
    }

    public function grafikBiaya ($dept, $id_role)
    {
        if ($id_role == 1 || $id_role == 5 || $id_role == 6 || $id_role == 7  || $id_role == 8){
            $query = "SELECT MONTH(work_order.tanggal) as urutan, YEAR(work_order.tanggal) as tahun, CONCAT(LEFT(MONTHNAME(work_order.tanggal),3),'-',SUBSTRING(YEAR(work_order.tanggal),3,2) ) as bulan, sum(plan_biaya) as plan, sum(act_biaya) as aktual FROM work_order GROUP BY MONTHNAME(work_order.tanggal) ORDER BY tahun, urutan ASC";
            $this->db->query($query);
            return $this->db->resultSet();
        } else {
            $query = "SELECT MONTH(work_order.tanggal) as urutan, YEAR(work_order.tanggal) as tahun, CONCAT(LEFT(MONTHNAME(work_order.tanggal),3),'-',SUBSTRING(YEAR(work_order.tanggal),3,2) ) as bulan, sum(plan_biaya) as plan, sum(act_biaya) as aktual FROM work_order WHERE department =:department GROUP BY MONTHNAME(work_order.tanggal) ORDER BY tahun, urutan ASC";
            $this->db->query($query);
            $this->db->bind ( 'department', $dept );
            return $this->db->resultSet();
        }
    }

    //grafik untuk menampilkan progress WO perstatus     
    public function grafikProgress ($dept, $id_role)
    {
        if ($id_role == 1 || $id_role == 5 || $id_role == 6 || $id_role == 7  || $id_role == 8){
            $query = "SELECT id_progress, progress, count(id_wo) AS jml FROM progress 
            LEFT JOIN (SELECT a.id_wo, a.nama_wo, max(id_progress) AS id FROM work_order a JOIN detail_progress b ON a.id_wo=b.id_wo WHERE a.status=:status GROUP BY id_wo) AS wo ON id=id_progress GROUP BY progress ORDER BY id_progress ASC";
            $this->db->query($query);
            $this->db->bind ( 'status', 'Open' );
            return $this->db->resultSet();
        } else {
            $query = "SELECT id, progress, count(id_wo) AS jml FROM (SELECT a.id_wo, a.nama_wo, a.department, max(id_progress) AS id FROM work_order a JOIN detail_progress b ON a.id_wo=b.id_wo WHERE a.status=:status GROUP BY id_wo) AS wo JOIN progress ON id=id_progress WHERE department =:department GROUP BY progress ORDER BY id ASC";
            $this->db->query($query);
            $this->db->bind ( 'department', $dept );
            $this->db->bind ( 'status', 'Open' );
            return $this->db->resultSet();
        }
    }

    //grafik untuk menampilkan progress WO perstatus     
    public function grafikTimeline ($dept, $id_role)
    {
        if ($id_role == 1 || $id_role == 5 || $id_role == 6 || $id_role == 7  || $id_role == 8){
            $query = "SELECT nama_wo, tanggal, id, progress, finish FROM ( SELECT a.nama_wo, a.tanggal, max(id_progress) as id, b.finish FROM work_order a JOIN detail_progress b ON a.id_wo=b.id_wo GROUP BY nama_wo) as wo JOIN progress ON id=id_progress ORDER BY tanggal ASC";
            $this->db->query($query);
            return $this->db->resultSet();
        } else {
            $query = "SELECT nama_wo, department, tanggal, id, progress, finish FROM ( SELECT a.nama_wo, a.department, a.tanggal, max(id_progress) as id, b.finish FROM work_order a JOIN detail_progress b ON a.id_wo=b.id_wo GROUP BY nama_wo) as wo JOIN progress ON id=id_progress WHERE department =:department ORDER BY tanggal ASC";
            $this->db->query($query);
            $this->db->bind ( 'department', $dept );
            return $this->db->resultSet();
        }
    }

    //grafik untuk menampilkan leadtime per WO    
    public function grafikLeadtime ($dept, $id_role)
    {
        if ($id_role == 1 || $id_role == 5 || $id_role == 6 || $id_role == 7  || $id_role == 8){
            $query = "SELECT nama_wo, sum(durasi) as leadtime FROM work_order a JOIN detail_progress b ON a.id_wo = b.id_wo GROUP BY nama_wo ORDER BY leadtime DESC LIMIT 20";
            $this->db->query($query);
            return $this->db->resultSet();
        } else {
            $query = "SELECT nama_wo, sum(durasi) as leadtime FROM work_order a JOIN detail_progress b ON a.id_wo = b.id_wo WHERE department =:department GROUP BY nama_wo ORDER BY leadtime DESC LIMIT 20";
            $this->db->query($query);
            $this->db->bind ( 'department', $dept );
            return $this->db->resultSet();
        }
    }


    public function grafikDept ()
    {
        $query = "SELECT nama_dept, kode, count(id_wo) as jml FROM department LEFT JOIN work_order ON work_order.department=department.id_dept GROUP BY nama_dept ORDER BY jml DESC";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function grafikbiayaDept ()
    {
        $query = "SELECT nama_dept, kode, sum(act_biaya) as biaya FROM department LEFT JOIN work_order ON work_order.department=department.id_dept GROUP BY nama_dept ORDER BY biaya DESC";
        $this->db->query($query);
        return $this->db->resultSet();
    }



}