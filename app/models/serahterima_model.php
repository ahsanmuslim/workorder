<?php

class serahterima_model
{

    private $db;


    public function __construct()
    {
        $this->db = new Database();
    }

    //data serah_terima
    public function dataserahterima($dept, $id_role)
    {
        if ($id_role == 1 || $id_role == 5 || $id_role == 6 || $id_role == 7 || $id_role == 8) {
            $query = 'SELECT serah_terima.id_serahterima, serah_terima.tgl_penyerahan, serah_terima.jam, serah_terima.hasil, serah_terima.komentar,  serah_terima.penilaian, work_order.id_wo, work_order.nama_wo, work_order.department, work_order.status, kode, user.nama_user FROM serah_terima 
            JOIN work_order ON work_order.id_wo=serah_terima.id_wo
            JOIN user ON work_order.create_by = user.id_user 
            JOIN department ON work_order.department=department.id_dept 
            ORDER BY work_order.status, work_order.id_wo DESC';
            $this->db->query($query);
            return $this->db->resultSet();
        } else {
            $query = 'SELECT serah_terima.id_serahterima, serah_terima.tgl_penyerahan, serah_terima.jam, serah_terima.hasil, serah_terima.komentar,  serah_terima.penilaian, work_order.id_wo, work_order.nama_wo, work_order.department, work_order.status, kode, user.nama_user FROM serah_terima 
            JOIN work_order ON work_order.id_wo=serah_terima.id_wo 
            JOIN user ON work_order.create_by = user.id_user 
            JOIN department ON work_order.department=department.id_dept 
            WHERE department =:department  
            ORDER BY work_order.status, work_order.id_wo DESC';
            $this->db->query($query);
            $this->db->bind('department', $dept);
            return $this->db->resultSet();
        }
    }

    //mengambil data serah_terima berdasarkan ID untuk proses update
    public function getserahterimabyID($id_serahterima)
    {
        $query = 'SELECT serah_terima.id_serahterima, serah_terima.tgl_penyerahan, serah_terima.jam, serah_terima.hasil, serah_terima.penilaian, serah_terima.komentar, serah_terima.gambar, work_order.id_wo, work_order.nama_wo, work_order.status FROM serah_terima 
        JOIN work_order ON work_order.id_wo=serah_terima.id_wo 
        WHERE id_serahterima =:id_serahterima';
        $this->db->query($query);
        $this->db->bind('id_serahterima', $id_serahterima);
        return $this->db->single();
    }

    //tambah data serah_terima
    public function tambahserahterima($data, $nama_file, $status, $durasi)
    {
        //update status detail progress In progress menjadi closed
        $progress = "UPDATE detail_progress SET finish =:finish, status =:status, durasi =:durasi WHERE id_wo =:id_wo AND id_progress = 7";
        $this->db->query($progress);
        $this->db->bind('finish', $data['tanggal']);
        $this->db->bind('id_wo', $data['id_wo']);
        $this->db->bind('status', $status);
        $this->db->bind('durasi', $durasi);
        $this->db->execute();

        //insert detail status handover setelah diterima
        $progress = "INSERT INTO detail_progress VALUES (NULL, :id_progress, :id_wo, :start, NULL, NULL, NULL)";
        $this->db->query($progress);
        $this->db->bind('id_progress', 8); //handover
        $this->db->bind('id_wo', $data['id_wo']);
        $this->db->bind('start', $data['tanggal']);
        $this->db->execute();

        $query = "INSERT INTO serah_terima VALUES (NULL, :tgl_penyerahan, :jam, NULL, NULL, NULL, :nama_file, :id_wo)";

        $this->db->query($query);
        $this->db->bind('tgl_penyerahan', $data['tanggal']);
        $this->db->bind('jam', $data['jam']);
        $this->db->bind('nama_file', $nama_file);
        $this->db->bind('id_wo', $data['id_wo']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    //update data serah_terima
    public function updateserahterima($data, $status, $durasi)
    {
        //update status detail progress handover menjadi finish
        $tanggal = date('Y-m-d');
        // echo $status;
        // echo $durasi;
        // var_dump($data);
        $progress = "UPDATE detail_progress SET finish =:finish, status =:status, durasi =:durasi WHERE id_wo =:id_wo AND id_progress = 8";
        $this->db->query($progress);
        $this->db->bind('finish',  $tanggal);
        $this->db->bind('id_wo', $data['id_wo']);
        $this->db->bind('status', $status);
        $this->db->bind('durasi', $durasi);
        $this->db->execute();

        //update status work order menjadi closed karena sudah dilakukan serah terima ke user
        $query = "UPDATE work_order SET status =:status, tgl_selesai =:tanggal WHERE id_wo =:id_wo";
        $this->db->query($query);
        $this->db->bind('status', 'Closed');
        $this->db->bind('tanggal', $tanggal);
        $this->db->bind('id_wo', $data['id_wo']);
        $this->db->execute();

        $query = "UPDATE serah_terima SET hasil =:hasil, penilaian =:penilaian, komentar =:komentar WHERE id_serahterima =:id_serahterima";

        $this->db->query($query);
        $this->db->bind('id_serahterima', $data['id']);
        $this->db->bind('hasil', $data['hasil']);
        $this->db->bind('penilaian', $data['penilaian']);
        $this->db->bind('komentar', $data['komentar']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    //hapus data serah_terima
    public function hapusserahterima($id_serahterima)
    {
        $query = "DELETE FROM serah_terima WHERE id_serahterima =:id_serahterima";
        $this->db->query($query);
        $this->db->bind('id_serahterima', $id_serahterima);
        $this->db->execute();
        return $this->db->rowCount();
    }
}
