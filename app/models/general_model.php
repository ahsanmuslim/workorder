<?php

class general_model {

    private $db;  


    public function __construct ()
    {
        $this->db = new Database();
    }

    //data HARI LIBUR
    public function dataholidays ()
    {
        $query = 'SELECT * FROM holidays';
        $this->db->query($query);
        return $this->db->resultSet();
    }

    //cek data holidays
    public function cekholidays ()
    {
        $tanggal = $_POST['tanggal'];
        $query = "SELECT count(id) FROM holidays WHERE tanggal = '$tanggal'";
        $this->db->query($query);
        return $this->db->numRow();
    }

    //mengambil data holidays berdasarkan ID untuk proses update
    public function getholidaysbyID ($id)
    {
        $this->db->query ('SELECT * FROM holidays WHERE id =:id');
        $this->db->bind ( 'id', $id );
        return $this->db->single();
    }

    //tambah data holidays
    public function tambahholidays ($data)
    {
        $query = "INSERT INTO holidays VALUES ( NULL, :tanggal, :keterangan)";
        $this->db->query($query);
        $this->db->bind('tanggal', $data['tanggal']);
        $this->db->bind('keterangan', $data['keterangan']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    //update data holidays
    public function updateholidays ($data)
    {
        $query = "UPDATE holidays SET tanggal =:tanggal, keterangan =:keterangan WHERE id =:id";
        $this->db->query($query);
        $this->db->bind('id', $data['id']);
        $this->db->bind('tanggal', $data['tanggal']);
        $this->db->bind('keterangan', $data['keterangan']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    //hapus data holidays
    public function hapusholidays ($id)
    {
        $query = "DELETE FROM holidays WHERE id =:id";
        $this->db->query($query);
        $this->db->bind('id',$id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    //data progress
    public function dataprogress ()
    {
        $query = 'SELECT * FROM progress';
        $this->db->query($query);
        return $this->db->resultSet();
    }

    //mengambil data progress berdasarkan ID untuk proses update
    public function getprogressbyID ($id_progress)
    {
        $this->db->query ('SELECT * FROM progress WHERE id_progress =:id_progress');
        $this->db->bind ( 'id_progress', $id_progress );
        return $this->db->single();
    }

    //mengambil data detailprogress
    public function getdetailbyID ($id_progress, $id_wo)
    {
        $this->db->query ('SELECT * FROM detail_progress WHERE id_progress =:id_progress AND id_wo =:id_wo');
        $this->db->bind ( 'id_progress', $id_progress );
        $this->db->bind ( 'id_wo', $id_wo );
        return $this->db->single();
    }

    //hitung data detail progress
    public function numRowProgress ($id_progress, $id_wo)
    {
        $query = "SELECT count(id_detail) FROM detail_progress WHERE id_wo =:id_wo AND id_progress =:id_progress";
        $this->db->query($query);
        $this->db->bind ( 'id_progress', $id_progress );
        $this->db->bind ( 'id_wo', $id_wo );
        return $this->db->numRow();
    }

    //cek data progress
    public function cekprogress ()
    {
        $progress = $_POST['progress'];
        $query = "SELECT count(id_progress) FROM progress WHERE progress = '$progress'";
        $this->db->query($query);
        return $this->db->numRow();
    }

    //tambah data progress
    public function tambahprogress ($data)
    {
        $query = "INSERT INTO progress VALUES ( NULL, :progress, :target, :pic)";
        $this->db->query($query);
        $this->db->bind('progress', $data['progress']);
        $this->db->bind('target', $data['target']);
        $this->db->bind('pic', $data['pic']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    //update data progress
    public function updateprogress ($data)
    {
        $query = "UPDATE progress SET progress =:progress, target =:target, pic =:pic WHERE id_progress =:id_progress";
        $this->db->query($query);
        $this->db->bind('id_progress', $data['id_progress']);
        $this->db->bind('progress', $data['progress']);
        $this->db->bind('target', $data['target']);
        $this->db->bind('pic', $data['pic']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    //hapus data progress
    public function hapusprogress ($id_progress)
    {
        $query = "DELETE FROM progress WHERE id_progress =:id_progress";
        $this->db->query($query);
        $this->db->bind('id_progress',$id_progress);
        $this->db->execute();
        return $this->db->rowCount();
    }


    //cek data progress di use_progress sebelum dihapus
    public function cekDatabyID($id_progress)
    {
        $cekdata = "SELECT * FROM detail_progress WHERE id_progress =:id_progress";
        $this->db->query($cekdata);
        $this->db->bind('id_progress',$id_progress);
        $this->db->execute();
        return $this->db->rowCount();
    }

    //data hari libur nasional
    public function dataharilibur ($startDate, $endDate)
    {
        $query = "SELECT tanggal FROM holidays WHERE tanggal >= '$startDate' AND tanggal <= '$endDate'";
        $this->db->query($query);
        return $this->db->resultSet();
    }



    //data kategori
    public function datakategori ()
    {
        $query = 'SELECT * FROM kategori';
        $this->db->query($query);
        return $this->db->resultSet();
    }

    //mengambil data kategori berdasarkan ID untuk proses update
    public function getkategoribyID ($id_kategori)
    {
        $this->db->query ('SELECT * FROM kategori WHERE id_kategori =:id_kategori');
        $this->db->bind ( 'id_kategori', $id_kategori );
        return $this->db->single();
    }

    //cek data kategori
    public function cekkategori ()
    {
        $kategori = $_POST['kategori'];
        $query = "SELECT count(id_kategori) FROM kategori WHERE nama_kategori = '$kategori'";
        $this->db->query($query);
        return $this->db->numRow();
    }

    //tambah data kategori
    public function tambahkategori ($data)
    {
        $query = "INSERT INTO kategori VALUES ( NULL, :kategori)";
        $this->db->query($query);
        $this->db->bind('kategori', $data['kategori']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    //update data kategori
    public function updatekategori ($data)
    {
        $query = "UPDATE kategori SET nama_kategori =:kategori WHERE id_kategori =:id_kategori";
        $this->db->query($query);
        $this->db->bind('id_kategori', $data['id_kategori']);
        $this->db->bind('kategori', $data['kategori']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    //hapus data kategori
    public function hapuskategori ($id_kategori)
    {
        $query = "DELETE FROM kategori WHERE id_kategori =:id_kategori";
        $this->db->query($query);
        $this->db->bind('id_kategori',$id_kategori);
        $this->db->execute();
        return $this->db->rowCount();
    }


    //cek data kategori di workorder sebelum dihapus
    public function cekDatakategoribyID($id_kategori)
    {
        $cekdata = "SELECT * FROM work_order WHERE id_kategori =:id_kategori";
        $this->db->query($cekdata);
        $this->db->bind('id_kategori',$id_kategori);
        $this->db->execute();
        return $this->db->rowCount();
    }


    public function importProgress ()
    {

        $file           = basename($_FILES['file_import']['name']);
        $ekstensi       = explode(".",$file);
        $file_name      = "file-".round(microtime(true)).".".end($ekstensi);
        $sumber_file    = $_FILES['file_import']['tmp_name'];

        //masuk ke folder file tempfile dari file index.php
        $target_dir     = "file/";
        $target_file    = $target_dir.$file_name;
        $upload         = move_uploaded_file($sumber_file, $target_file);

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $objek = $reader->load($target_file);
        $all_data       = $objek->getActiveSheet()->toArray(null,true,true,true);

        // var_dump($all_data);

        $query_data = "INSERT INTO detail_progress VALUES ";

        for ($i=2 ; $i <= count($all_data) ; $i++){
            $id_progress      = $all_data [$i]['A'];
            $id_wo    = $all_data [$i]['B'];
            $start = $all_data [$i]['C'];
            $finish  = $all_data [$i]['D'];
            $status    = $all_data [$i]['E'];
            $durasi = $all_data [$i]['F'];


            $query_data .= "(NULL, '$id_progress', '$id_wo', '$start', '$finish', '$status','$durasi'),";
        }

        $query_data = substr ($query_data, 0, -1);

        $this->db->query($query_data);
        $this->db->execute();

        return $this->db->rowCount();
        unlink($target_file);


    }


    public function importHolidays ()
    {

        $file           = basename($_FILES['file_import']['name']);
        $ekstensi       = explode(".",$file);
        $file_name      = "file-".round(microtime(true)).".".end($ekstensi);
        $sumber_file    = $_FILES['file_import']['tmp_name'];

        //masuk ke folder file tempfile dari file index.php
        $target_dir     = "file/";
        $target_file    = $target_dir.$file_name;
        $upload         = move_uploaded_file($sumber_file, $target_file);

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $objek = $reader->load($target_file);
        $all_data       = $objek->getActiveSheet()->toArray(null,true,true,true);

        // var_dump($all_data);

        $query_data = "INSERT INTO holidays VALUES ";

        for ($i=2 ; $i <= count($all_data) ; $i++){
            $tanggal      = $all_data [$i]['A'];
            $keterangan    = $all_data [$i]['B'];


            $query_data .= "(NULL, '$tanggal', '$keterangan'),";
        }

        $query_data = substr ($query_data, 0, -1);

        $this->db->query($query_data);
        $this->db->execute();

        return $this->db->rowCount();
        unlink($target_file);


    }



}