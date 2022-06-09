<?php

class corporate_model {

    private $db;  


    public function __construct ()
    {
        $this->db = new Database();
    }

    public function getIDTelegram($dept)
    {
        $query = "SELECT nama_dept, telegram FROM department WHERE id_dept =:id_dept";
        $this->db->query ($query);
        $this->db->bind ( 'id_dept', $dept );
        return $this->db->single();
    }

    //data Divisi
    public function dataDivisi ()
    {
        $query = 'SELECT * FROM divisi';
        $this->db->query($query);
        return $this->db->resultSet();
    }

    //cek data divisi di dept
    public function cekDatabyID($id_divisi)
    {
        $cekdata = "SELECT * FROM department WHERE id_divisi =:id_divisi";
        $this->db->query($cekdata);
        $this->db->bind('id_divisi',$id_divisi);
        $this->db->execute();
        return $this->db->rowCount();
    }

    //mengambil data divisi berdasarkan ID untuk proses update
    public function getDivisibyID ($id_divisi)
    {
        $this->db->query ('SELECT * FROM divisi WHERE id_divisi =:id_divisi');
        $this->db->bind ( 'id_divisi', $id_divisi );
        return $this->db->single();
    }

    //cek data divisi
    public function cekDivisi ()
    {
        $div = $_POST['divisi'];
        $query = "SELECT count(id_divisi) FROM divisi WHERE nama_divisi = '$div'";
        $this->db->query($query);
        return $this->db->numRow();
    }

    //tambah data divisi
    public function tambahDivisi ($data)
    {
        $query = "INSERT INTO divisi VALUES ( NULL, :nama_divisi, :div_head)";
        $this->db->query($query);
        $this->db->bind('nama_divisi', $data['divisi']);
        $this->db->bind('div_head', $data['divhead']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    //update data divisi
    public function updateDivisi ($data)
    {
        $query = "UPDATE divisi SET nama_divisi =:nama_divisi, div_head =:div_head WHERE id_divisi =:id_divisi";
        $this->db->query($query);
        $this->db->bind('id_divisi', $data['id_div']);
        $this->db->bind('nama_divisi', $data['divisi']);
        $this->db->bind('div_head', $data['divhead']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    //hapus data divisi
    public function hapusDivisi ($id_divisi)
    {
        $query = "DELETE FROM divisi WHERE id_divisi =:id_divisi";
        $this->db->query($query);
        $this->db->bind('id_divisi',$id_divisi);
        $this->db->execute();
        return $this->db->rowCount();
    }


    //data Dept
    public function dataDept ()
    {
        $query = 'SELECT id_dept, nama_dept, dept_head, nama_divisi, telegram, kode FROM department JOIN divisi on department.id_divisi=divisi.id_divisi';
        $this->db->query($query);
        return $this->db->resultSet();
    }

    //mengambil data department berdasarkan ID untuk proses update
    public function getDeptbyID ($id_dept)
    {
        $this->db->query ('SELECT * FROM department WHERE id_dept =:id_dept');
        $this->db->bind ( 'id_dept', $id_dept );
        return $this->db->single();
    }

    //cek data department
    public function cekDept ()
    {
        $dept = $_POST['department'];
        $query = "SELECT count(id_dept) FROM department WHERE nama_dept = '$dept'";
        $this->db->query($query);
        return $this->db->numRow();
    }

    //tambah data department
    public function tambahDept ($data)
    {
        $query = "INSERT INTO department VALUES ( NULL, :nama_dept, :dept_head, :id_divisi, NULl, :kode)";
        $this->db->query($query);
        $this->db->bind('nama_dept', $data['department']);
        $this->db->bind('dept_head', $data['depthead']);
        $this->db->bind('id_divisi', $data['divisi']);
        $this->db->bind('kode', $data['kode']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    //update data department
    public function updateDept ($data)
    {
        $query = "UPDATE department SET nama_dept =:nama_dept, dept_head =:dept_head, id_divisi =:id_divisi, telegram=:telegram, kode=:kode WHERE id_dept =:id_dept";
        $this->db->query($query);
        $this->db->bind('id_dept', $data['id_dept']);
        $this->db->bind('nama_dept', $data['nama_dept']);
        $this->db->bind('dept_head', $data['dept_head']);
        $this->db->bind('id_divisi', $data['divisi']);
        $this->db->bind('telegram', $data['telegram']);
        $this->db->bind('kode', $data['kode']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    //hapus data department
    public function hapusDept ($id_dept)
    {
        $query = "DELETE FROM department WHERE id_dept =:id_dept";
        $this->db->query($query);
        $this->db->bind('id_dept',$id_dept);
        $this->db->execute();
        return $this->db->rowCount();
    }

    //cek data dept di user
    public function cekDatauserbyID($id_dept)
    {
        $cekdata = "SELECT * FROM user WHERE id_dept =:id_dept";
        $this->db->query($cekdata);
        $this->db->bind('id_dept',$id_dept);
        $this->db->execute();
        return $this->db->rowCount();
    }

    //data Lokasi
    public function dataLokasi ()
    {
        $query = 'SELECT * FROM lokasi';
        $this->db->query($query);
        return $this->db->resultSet();
    }

    //mengambil data lokasi berdasarkan ID untuk proses update
    public function getLokasibyID ($id_lokasi)
    {
        $this->db->query ('SELECT * FROM lokasi WHERE id_lokasi =:id_lokasi');
        $this->db->bind ( 'id_lokasi', $id_lokasi );
        return $this->db->single();
    }

    //cek data lokasi
    public function cekLokasi ()
    {
        $lok = $_POST['lokasi'];
        $query = "SELECT count(id_lokasi) FROM lokasi WHERE nama_lokasi = '$lok'";
        $this->db->query($query);
        return $this->db->numRow();
    }

    //tambah data lokasi
    public function tambahLokasi ($data)
    {
        $query = "INSERT INTO lokasi VALUES ( NULL, :nama_lokasi)";
        $this->db->query($query);
        $this->db->bind('nama_lokasi', $data['lokasi']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    //update data lokasi
    public function updateLokasi ($data)
    {
        $query = "UPDATE lokasi SET nama_lokasi =:nama_lokasi WHERE id_lokasi =:id_lokasi";
        $this->db->query($query);
        $this->db->bind('id_lokasi', $data['id_lokasi']);
        $this->db->bind('nama_lokasi', $data['lokasi']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    //hapus data lokasi
    public function hapusLokasi ($id_lokasi)
    {
        $query = "DELETE FROM lokasi WHERE id_lokasi =:id_lokasi";
        $this->db->query($query);
        $this->db->bind('id_lokasi',$id_lokasi);
        $this->db->execute();
        return $this->db->rowCount();
    }
    


    //data Supplier
    public function dataSupplier ()
    {
        $query = 'SELECT * FROM supplier';
        $this->db->query($query);
        return $this->db->resultSet();
    }


    //mengambil data supplier berdasarkan ID untuk proses update
    public function getSupplierbyID ($id_supplier)
    {
        $this->db->query ('SELECT * FROM supplier WHERE id_supplier =:id_supplier');
        $this->db->bind ( 'id_supplier', $id_supplier );
        return $this->db->single();
    }

    //cek data supplier
    public function cekSupplier ()
    {
        $sup = $_POST['supplier'];
        $query = "SELECT count(id_supplier) FROM supplier WHERE nama_supplier = '$sup'";
        $this->db->query($query);
        return $this->db->numRow();
    }

    //tambah data supplier
    public function tambahSupplier ($data)
    {
        $query = "INSERT INTO supplier VALUES ( NULL, :nama_supplier, :alamat, :notelp, :pic, :ket)";
        $this->db->query($query);
        $this->db->bind('nama_supplier', $data['supplier']);
        $this->db->bind('alamat', $data['alamat']);
        $this->db->bind('notelp', $data['notelp']);
        $this->db->bind('pic', $data['pic']);
        $this->db->bind('ket', $data['ket']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    //update data supplier
    public function updateSupplier ($data)
    {
        $query = "UPDATE supplier SET nama_supplier =:nama_supplier, alamat =:alamat, no_telp =:notelp, pic =:pic, keterangan =:ket WHERE id_supplier =:id_supplier";
        $this->db->query($query);
        $this->db->bind('id_supplier', $data['id_supplier']);
        $this->db->bind('nama_supplier', $data['supplier']);
        $this->db->bind('alamat', $data['alamat']);
        $this->db->bind('notelp', $data['notelp']);
        $this->db->bind('pic', $data['pic']);
        $this->db->bind('ket', $data['ket']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    //hapus data supplier
    public function hapusSupplier ($id_supplier)
    {
        $query = "DELETE FROM supplier WHERE id_supplier =:id_supplier";
        $this->db->query($query);
        $this->db->bind('id_supplier',$id_supplier);
        $this->db->execute();
        return $this->db->rowCount();
    }

    //cek data supplier pada table pembelian
    public function cekDatasupplierbyID($id_supplier)
    {
        $cekdata = "SELECT * FROM pembelian WHERE id_supplier =:id_supplier";
        $this->db->query($cekdata);
        $this->db->bind('id_supplier',$id_supplier);
        $this->db->execute();
        return $this->db->rowCount();
    }


    public function importSupplier ()
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

        $query_data = "INSERT INTO supplier VALUES ";

        for ($i=2 ; $i <= count($all_data) ; $i++){
            $nama_supplier      = $all_data [$i]['A'];
            $alamat    = $all_data [$i]['B'];
            $no_telp = $all_data [$i]['C'];
            $pic  = $all_data [$i]['D'];
            $keterangan    = $all_data [$i]['E'];


            $query_data .= "(NULL, '$nama_supplier', '$alamat', '$no_telp', '$pic', '$keterangan'),";
        }

        $query_data = substr ($query_data, 0, -1);

        $this->db->query($query_data);
        $this->db->execute();

        return $this->db->rowCount();
        unlink($target_file);


    }



}