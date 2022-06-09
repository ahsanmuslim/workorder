<?php

class material_model {

    private $db;  


    public function __construct ()
    {
        $this->db = new Database();
    }

    //data material
    public function dataMaterial ()
    {
        $query = 'SELECT * FROM material';
        $this->db->query($query);
        return $this->db->resultSet();
    }

    //fungsi untuk create code wo 
    public function getKodematerial()
    {
        // mengambil data wo dengan kode paling besar
        $query = "SELECT max(id_material) as maxCode FROM material";
        $this->db->query($query);
        return $this->db->resultSet();        
    }


    //mengambil data material berdasarkan ID untuk proses update
    public function getMaterialbyID ($id_material)
    {
        $this->db->query ('SELECT * FROM material WHERE id_material =:id_material');
        $this->db->bind ( 'id_material', $id_material );
        return $this->db->single();
    }


    //cek data material
    public function cekMaterial ()
    {
        $mat = $_POST['material'];
        $query = "SELECT count(id_material) FROM material WHERE nama_material = '$mat'";
        $this->db->query($query);
        return $this->db->numRow();
    }

    //tambah data material
    public function tambahMaterial ($data)
    {
        $query = "INSERT INTO material VALUES ( :id_material, :nama_material, :jenis_material, :stok, :satuan, :harga, :keterangan)";
        $this->db->query($query);
        $this->db->bind('id_material', $data['id_material']);
        $this->db->bind('nama_material', $data['material']);
        $this->db->bind('jenis_material', $data['jenis']);
        $this->db->bind('stok', $data['stok']);
        $this->db->bind('satuan', $data['satuan']);
        $this->db->bind('harga', $data['harga']);
        $this->db->bind('keterangan', $data['ket']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    //update data material
    public function updateMaterial ($data)
    {
        $query = "UPDATE material SET nama_material =:nama_material, jenis_material =:jenis_material, stok =:stok, satuan =:satuan, harga =:harga, keterangan =:keterangan WHERE id_material =:id_material";
        $this->db->query($query);
        $this->db->bind('id_material', $data['id_material']);
        $this->db->bind('nama_material', $data['material']);
        $this->db->bind('jenis_material', $data['jenis']);
        $this->db->bind('stok', $data['stok']);
        $this->db->bind('satuan', $data['satuan']);
        $this->db->bind('harga', $data['harga']);
        $this->db->bind('keterangan', $data['ket']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    //hapus data material
    public function hapusMaterial ($id_material)
    {
        $query = "DELETE FROM material WHERE id_material =:id_material";
        $this->db->query($query);
        $this->db->bind('id_material',$id_material);
        $this->db->execute();
        return $this->db->rowCount();
    }


    //cek data material di use_material sebelum dihapus
    public function cekDatabyID($id_material)
    {
        $cekdata = "SELECT * FROM use_material WHERE id_material =:id_material";
        $this->db->query($cekdata);
        $this->db->bind('id_material',$id_material);
        $this->db->execute();
        return $this->db->rowCount();
    }


    public function importData ()
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

        $query_data = "INSERT INTO material VALUES ";

        for ($i=2 ; $i <= count($all_data) ; $i++){
            $id_rm      = $all_data [$i]['A'];
            $nama_material    = $all_data [$i]['B'];
            $jenis_material = $all_data [$i]['C'];
            $stok  = $all_data [$i]['D'];
            $satuan    = $all_data [$i]['E'];
            $harga = $all_data [$i]['F'];
            $keterangan    = $all_data [$i]['G'];


            $query_data .= "('$id_rm', '$nama_material', '$jenis_material', '$stok', '$satuan','$harga', '$keterangan'),";
        }

        $query_data = substr ($query_data, 0, -1);

        $this->db->query($query_data);
        $this->db->execute();

        return $this->db->rowCount();
        unlink($target_file);


    }







}