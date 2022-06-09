<?php

class kaskeluar_model
{

    private $db;


    public function __construct()
    {
        $this->db = new Database();
    }

    //data kas_keluar
    public function datakaskeluar()
    {
        $query = 'SELECT kas_keluar.id_dana, kas_keluar.tgl_pengajuan, kas_keluar.jml_pengajuan, kas_keluar.aktual_biaya, kas_keluar.status, kas_keluar.tgl_terima, kas_keluar.pic_terima, work_order.id_wo, work_order.nama_wo FROM kas_keluar 
        JOIN work_order ON work_order.id_wo=kas_keluar.id_wo 
        ORDER BY kas_keluar.status DESC, tgl_pengajuan DESC';
        $this->db->query($query);
        return $this->db->resultSet();
    }

    //mengambil data kas_keluar berdasarkan ID untuk proses update
    public function getkaskeluarbyID($id_dana)
    {
        $query = 'SELECT kas_keluar.id_dana, kas_keluar.tgl_pengajuan, kas_keluar.jml_pengajuan, kas_keluar.status, kas_keluar.tgl_terima, kas_keluar.pic_terima, work_order.id_wo, work_order.nama_wo FROM kas_keluar 
        JOIN work_order ON work_order.id_wo=kas_keluar.id_wo 
        WHERE id_dana =:id_dana';
        $this->db->query($query);
        $this->db->bind('id_dana', $id_dana);
        return $this->db->single();
    }

    public function getCash ($id_wo)
    {
        $query = 'SELECT * FROM kas_keluar WHERE id_wo =:id_wo AND tgl_terima IS NULL';
        $this->db->query($query);
        $this->db->bind('id_wo', $id_wo);
        return $this->db->single();
    }

    //tambah data kas_keluar
    public function tambahkaskeluar($data)
    {
        $query = "INSERT INTO kas_keluar VALUES (NULL, :tgl_pengajuan, :jml_pengajuan, 0, :status, NULL, NULL, :id_wo)";

        $this->db->query($query);
        $this->db->bind('tgl_pengajuan', $data['tanggal']);
        $this->db->bind('jml_pengajuan', $data['jumlah']);
        $this->db->bind('status', 'waiting list');
        $this->db->bind('id_wo', $data['id_wo']);

        $this->db->execute();

        $progress = "INSERT INTO detail_progress VALUES (NULL, :id_progress, :id_wo, :start, NULL, NULL, NULl)";
        $this->db->query($progress);
        $this->db->bind('id_progress', 4);
        $this->db->bind('id_wo', $data['id_wo']);
        $this->db->bind('start', $data['tanggal']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    //jika Work order no cost
    public function nocost($id_wo)
    {
        $tanggal = date('Y-m-d');

        $progress = "INSERT INTO detail_progress VALUES (NULL, :id_progress, :id_wo, :start, NULL, NULL, NULl)";
        $this->db->query($progress);
        $this->db->bind('id_progress', 6);
        $this->db->bind('id_wo', $id_wo);
        $this->db->bind('start', $tanggal);

        $this->db->execute();

        return $this->db->rowCount();
    }


    //update data kas_keluar
    public function updatekaskeluar($data, $status, $durasi)
    {
        $query = "UPDATE kas_keluar SET status =:status, tgl_terima =:tgl_terima, pic_terima =:pic_terima WHERE id_dana =:id_dana";

        $this->db->query($query);
        $this->db->bind('id_dana', $data['id']);
        $this->db->bind('status', 'already taken');
        $this->db->bind('tgl_terima', $data['tgl_terima']);
        $this->db->bind('pic_terima', $data['pic']);

        $this->db->execute();

        //update status detail progress cash submission menjadi closed
        $progress = "UPDATE detail_progress SET finish =:finish, status =:status, durasi =:durasi WHERE id_wo =:id_wo AND id_progress = 4";
        $this->db->query($progress);
        $this->db->bind('finish', $data['tgl_terima']);
        $this->db->bind('id_wo', $data['id_wo']);
        $this->db->bind('status', $status);
        $this->db->bind('durasi', $durasi);

        $this->db->execute();

        //insert detail status purchase RM setelah uang kas diambil 
        $progress = "INSERT INTO detail_progress VALUES (NULL, :id_progress, :id_wo, :start, NULL, NULL, NULL)";
        $this->db->query($progress);
        $this->db->bind('id_progress', 5); //is progress purchase material
        $this->db->bind('id_wo', $data['id_wo']);
        $this->db->bind('start', $data['tanggal']);

        $this->db->execute();

        return $this->db->rowCount();
    }


    //update data kas_keluar
    public function ready($id_dana)
    {
        $query = "UPDATE kas_keluar SET status =:status WHERE id_dana =:id_dana";

        $this->db->query($query);
        $this->db->bind('id_dana', $id_dana);
        $this->db->bind('status', 'cash ready');
        $this->db->execute();

        return $this->db->rowCount();
    }

    //hapus data kas_keluar
    public function hapuskaskeluar($id_dana)
    {
        $query = "DELETE FROM kas_keluar WHERE id_dana =:id_dana";
        $this->db->query($query);
        $this->db->bind('id_dana', $id_dana);
        $this->db->execute();


        return $this->db->rowCount();
    }
}
