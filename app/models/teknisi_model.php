<?php

class teknisi_model {

    private $db;  


    public function __construct ()
    {
        $this->db = new Database();
    }

    //data teknisi
    public function datateknisi ()
    {
        $query = "SELECT teknisi.id_teknisi, nama_teknisi, keahlian, tahun_masuk  
                , COUNT(IF(status = 'Closed',1,NULL)) AS finish 
                , COUNT(IF(status = 'Open',1,NULL)) AS active
                , ROUND(AVG(penilaian)) AS rating 
        FROM teknisi
        LEFT JOIN work_order ON teknisi.id_teknisi=work_order.id_teknisi 
        LEFT JOIN serah_terima ON work_order.id_wo=serah_terima.id_wo 
        GROUP BY nama_teknisi ORDER BY teknisi.id_teknisi";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    //mengambil data teknisi berdasarkan ID untuk proses update
    public function getteknisibyID ($id_teknisi)
    {
        $this->db->query ('SELECT * FROM teknisi WHERE id_teknisi =:id_teknisi');
        $this->db->bind ( 'id_teknisi', $id_teknisi );
        return $this->db->single();
    }

    //cek data teknisi
    public function cekteknisi ()
    {
        $teknisi = $_POST['teknisi'];
        $query = "SELECT count(id_teknisi) FROM teknisi WHERE nama_teknisi = '$teknisi'";
        $this->db->query($query);
        return $this->db->numRow();
    }

    //tambah data teknisi
    public function tambahteknisi ($data)
    {
        $query = "INSERT INTO teknisi VALUES ( NULL, :nama_teknisi, :keahlian, :tahun)";
        $this->db->query($query);
        $this->db->bind('nama_teknisi', $data['teknisi']);
        $this->db->bind('keahlian', $data['keahlian']);
        $this->db->bind('tahun', $data['tahun']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    //update data teknisi
    public function updateteknisi ($data)
    {
        $query = "UPDATE teknisi SET nama_teknisi =:nama_teknisi, keahlian =:keahlian, tahun_masuk =:tahun WHERE id_teknisi =:id_teknisi";
        $this->db->query($query);
        $this->db->bind('id_teknisi', $data['id_teknisi']);
        $this->db->bind('nama_teknisi', $data['teknisi']);
        $this->db->bind('keahlian', $data['keahlian']);
        $this->db->bind('tahun', $data['tahun']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    //hapus data teknisi
    public function hapusteknisi ($id_teknisi)
    {
        $query = "DELETE FROM teknisi WHERE id_teknisi =:id_teknisi";
        $this->db->query($query);
        $this->db->bind('id_teknisi',$id_teknisi);
        $this->db->execute();
        return $this->db->rowCount();
    }


    //cek data teknisi di workorder sebelum dihapus
    public function cekDatabyID($id_teknisi)
    {
        $cekdata = "SELECT * FROM work_order WHERE id_teknisi =:id_teknisi";
        $this->db->query($cekdata);
        $this->db->bind('id_teknisi',$id_teknisi);
        $this->db->execute();
        return $this->db->rowCount();
    }

    //cek data active project by teknisi
    public function getActiveproject ($id_teknisi)
    {
        $query = "SELECT count(id_wo) FROM work_order JOIN teknisi ON work_order.id_teknisi=teknisi.id_teknisi WHERE work_order.id_teknisi =:id_teknisi AND status='Open'";
        $this->db->query($query);
        $this->db->bind ( 'id_teknisi', $id_teknisi );
        return $this->db->numRow();
    }


}