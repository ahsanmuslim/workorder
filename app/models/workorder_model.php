<?php

class workorder_model {

    private $table = 'work_order';
    private $db;  


    public function __construct ()
    {
        $this->db = new Database();
    }


    public function getUser ()
    {
        if(isset($_SESSION['useractive'])){
            $user = $_SESSION['useractive'];
            $query = "SELECT * FROM ".$this->table." WHERE username = '$user'";
            $this->db->query($query);

            return $this->db->single();        
        }
    }
    
    //data List up work order
    public function dataWorkorder ($dept, $id_role)
    {
        //administrator
        if ($id_role == 1){

            $query = "SELECT work_order.tanggal, work_order.id_wo, work_order.department, department.nama_dept, work_order.nama_wo, work_order.plan_biaya, work_order.act_biaya, work_order.prioritas, work_order.status, work_order.approve_dept, work_order.approve_div, work_order.verified, work_order.approve_hr FROM work_order JOIN department ON work_order.department=department.id_dept ORDER BY  status ASC, prioritas DESC, tanggal DESC";
            $this->db->query($query);
            return $this->db->resultSet();

        //HR Dept head
        } elseif ($id_role == 7){

            $query = "SELECT work_order.tanggal, work_order.id_wo, work_order.department, department.nama_dept, work_order.nama_wo, work_order.plan_biaya, work_order.act_biaya, work_order.prioritas, work_order.status, work_order.approve_dept, work_order.approve_div, work_order.verified, work_order.approve_hr FROM work_order JOIN department ON work_order.department=department.id_dept WHERE verified IS NOT NULL OR (approve_dept IS NULL AND work_order.department =16)ORDER BY  status ASC, prioritas DESC, tanggal DESC";
            $this->db->query($query);
            return $this->db->resultSet();

        //admin MTC
        } elseif ($id_role == 6){

            $query = "SELECT work_order.tanggal, work_order.id_wo, work_order.department, department.nama_dept, work_order.nama_wo, work_order.plan_biaya, work_order.act_biaya, work_order.prioritas, work_order.status, work_order.approve_dept, work_order.approve_div, work_order.verified, work_order.approve_hr FROM work_order JOIN department ON work_order.department=department.id_dept WHERE approve_dept IS NOT NULL ORDER BY status ASC, prioritas DESC, tanggal DESC";
            $this->db->query($query);
            return $this->db->resultSet();

        //Division head
        } elseif ($id_role == 5){

            $query = "SELECT work_order.tanggal, work_order.id_wo, work_order.department, department.nama_dept, work_order.nama_wo, work_order.plan_biaya, work_order.act_biaya, work_order.prioritas, work_order.status, work_order.approve_dept, work_order.approve_div, work_order.verified, work_order.approve_hr FROM work_order JOIN department ON work_order.department=department.id_dept WHERE approve_hr IS NOT NULL ORDER BY status ASC, prioritas DESC, tanggal DESC";
            $this->db->query($query);
            return $this->db->resultSet();

        //user biasa (Staff & Dept Head)
        } else {

            $query = "SELECT work_order.tanggal, work_order.id_wo, work_order.department, department.nama_dept, work_order.nama_wo, work_order.plan_biaya, work_order.act_biaya, work_order.prioritas, work_order.status, work_order.approve_dept, work_order.approve_div, work_order.verified, work_order.approve_hr FROM work_order JOIN department ON work_order.department=department.id_dept WHERE department =:department ORDER BY status ASC, prioritas DESC, tanggal DESC";
            $this->db->query($query);
            $this->db->bind ( 'department', $dept );
            return $this->db->resultSet();

        }
    }

    //menampilkan data work order yang dalam proses pengerjaan untuk serah terima Work order
    public function getInprogress ()
    {
        $query = "SELECT id_wo, nama_wo, id, progress FROM (SELECT a.nama_wo, a.id_wo, max(id_progress) AS id FROM work_order a JOIN detail_progress b ON a.id_wo=b.id_wo GROUP BY id_wo) AS wo JOIN progress on id=id_progress WHERE id=7 AND id_wo NOT IN (SELECT serah_terima.id_wo FROM serah_terima)";
        $this->db->query($query);
        return $this->db->resultSet();
    }


    //menampilkan data work order yang sudah cair duitnya 
    public function getCashout ()
    {
        $query = "SELECT id_wo, nama_wo, status, id, progress FROM (SELECT a.nama_wo, a.id_wo, a.status, max(id_progress) AS id FROM work_order a JOIN detail_progress b ON a.id_wo=b.id_wo GROUP BY id_wo) AS wo JOIN progress on id=id_progress WHERE id>=4 AND status = 'Open'";
        $this->db->query($query);
        return $this->db->resultSet();
    }


    public function getProgress ($id_wo)
    {
        $query = "SELECT work_order.id_wo, detail_progress.id_progress, progress FROM work_order
        join detail_progress on work_order.id_wo=detail_progress.id_wo 
        join progress on detail_progress.id_progress=progress.id_progress 
        WHERE work_order.id_wo =:id_wo AND detail_progress.id_progress IN 
        (SELECT max(detail_progress.id_progress) FROM detail_progress  WHERE detail_progress.id_wo=:id_wo)";
        $this->db->query($query);
        $this->db->bind ( 'id_wo', $id_wo );
        return $this->db->single();
    }


    //fungsi untuk create code wo 
    public function getKodeWO()
    {
        // mengambil data wo dengan kode paling besar
        // $query = "SELECT max(id_wo) as maxCode FROM work_order";
        //perbaikan kode Wo
        $query ="SELECT MAX(SUBSTRING(id_wo,4,3)) as maxCode FROM work_order WHERE YEAR(tanggal)=YEAR(NOW())";
        $this->db->query($query);
        return $this->db->resultSet();        
    }


    //data list open work order 
    public function workorderOpen ()
    {
        $query = "SELECT id_wo, nama_wo, plan_biaya FROM work_order WHERE status = 'Open' ";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function getWObyID ($id_wo)
    {
        $query = "SELECT id_wo, nama_wo, plan_biaya FROM work_order WHERE id_wo =:id_wo ";
        $this->db->query($query);
        $this->db->bind ( 'id_wo', $id_wo );
        return $this->db->single();
    }

    //data detail work order
    public function getDetailWO ($id_wo)
    {
        $query = "SELECT work_order.tanggal, work_order.id_wo, work_order.department, department.nama_dept, department.telegram, work_order.target_selesai, work_order.drawing, work_order.nama_wo, work_order.plan_biaya, work_order.act_biaya, work_order.approve_div, work_order.approve_hr, work_order.approve_dept, work_order.verified, work_order.prioritas, work_order.status, work_order.deskripsi, work_order.id_lokasi, work_order.id_kategori, department.nama_dept, lokasi.nama_lokasi, teknisi.nama_teknisi, teknisi.id_teknisi, user.id_user, user.nama_user, kategori.nama_kategori FROM work_order
        join user on user.id_user=work_order.create_by 
        join department on work_order.department=department.id_dept
        join teknisi on work_order.id_teknisi=teknisi.id_teknisi
        join lokasi on work_order.id_lokasi=lokasi.id_lokasi
        join kategori on work_order.id_kategori=kategori.id_kategori 
        WHERE id_wo =:id_wo";
        $this->db->query($query);
        $this->db->bind ( 'id_wo', $id_wo );
        return $this->db->single();
    }

    //data detail wo yang sudah di approve
    public function getDataWOapprove ()
    {
        // $query = "SELECT work_order.id_wo, work_order.nama_wo, work_order.plan_biaya, detail_progress.finish, progress.progress FROM work_order  
        // JOIN detail_progress on work_order.id_wo=detail_progress.id_wo 
        // JOIN progress on detail_progress.id_progress=progress.id_progress 
        // WHERE detail_progress.id_progress = 3 AND finish IS NOT NULL AND work_order.id_wo NOT IN (SELECT id_wo FROM kas_keluar) AND ";
        $query = "SELECT id_wo, nama_wo, status, plan_biaya, approve_div, id, progress 
        FROM (SELECT a.nama_wo, a.id_wo, a.status, a.plan_biaya, a.approve_div, max(id_progress) AS id FROM work_order a JOIN detail_progress b ON a.id_wo=b.id_wo GROUP BY id_wo) AS wo 
        JOIN progress on id=id_progress WHERE id=3 AND approve_div IS NOT NULL AND id_wo NOT IN (SELECT id_wo FROM kas_keluar)";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    //data detail material work order
    public function getDetailRM ($id_wo)
    {
        $query = "SELECT work_order.id_wo, work_order.plan_biaya, use_material.qty_plan, use_material.id_material, use_material.qty_aktual, use_material.harga_rm, material.nama_material, material.satuan, material.harga, material.keterangan FROM work_order
        join use_material on use_material.id_wo=work_order.id_wo  
        join material on material.id_material=use_material.id_material  
        WHERE work_order.id_wo =:id_wo";
        $this->db->query($query);
        $this->db->bind ( 'id_wo', $id_wo );
        return $this->db->resultSet();
    }

    //data activity work order
    public function getActivity ($id_wo)
    {
        $query = "SELECT * FROM activity WHERE id_wo =:id_wo";
        $this->db->query($query);
        $this->db->bind ( 'id_wo', $id_wo );
        return $this->db->resultSet();
    }

    //data activity detail progress
    public function getDetailProgress ($id_wo)
    {
        $query = "SELECT detail_progress.id_wo, progress.progress, detail_progress.start, detail_progress.finish, progress.target, detail_progress.durasi, detail_progress.status FROM detail_progress
        join progress on progress.id_progress=detail_progress.id_progress  
        WHERE id_wo =:id_wo ORDER BY progress.id_progress ASC";
        $this->db->query($query);
        $this->db->bind ( 'id_wo', $id_wo );
        return $this->db->resultSet();
    }
    


    // query untuk mengecek data foreign key 
    public function cekDataLokasi($id_lokasi)
    {
        $cekdata = "SELECT * FROM work_order WHERE id_lokasi =:id_lokasi";
        $this->db->query($cekdata);
        $this->db->bind('id_lokasi',$id_lokasi);
        $this->db->execute();
        return $this->db->rowCount();
    }

    //tambah data work order
    public function tambahWorkorder ($data, $nama_file)
    {
        $query = "INSERT INTO work_order VALUES ( :id_wo, :nama_wo, :department, :deskripsi, :drawing, :target, NULL, :prioritas, :plan_biaya, 0, :status, :tanggal, NULL, NULL, NULL, :id_user, :id_lokasi, :id_kategori, :id_teknisi, NULL, NULL)";

        $this->db->query($query);
        $this->db->bind('id_wo', $data['id_wo']);
        $this->db->bind('nama_wo', $data['nama_wo']);
        $this->db->bind('department', $data['dept']);
        $this->db->bind('deskripsi', $data['deskripsi']);
        $this->db->bind('drawing', $nama_file);
        $this->db->bind('target', $data['target']);
        $this->db->bind('prioritas', $data['prioritas']);
        $this->db->bind('plan_biaya', $data['biaya']);
        $this->db->bind('status', "Open");
        $this->db->bind('tanggal', $data['tanggalwo']);
        $this->db->bind('id_user', $data['pic']);
        $this->db->bind('id_lokasi', $data['lokasi']);
        $this->db->bind('id_kategori', $data['kategori']);
        $this->db->bind('id_teknisi', $data['teknisi']);
        $this->db->execute();

        for ( $i = 0 ; $i < 10 ; $i++ ){
            if ( !empty($data['material'][$i]) ){
                $query = "INSERT INTO use_material VALUES ( NULL, :id_wo, :id_material, :qty, NULL, NULL, :harga )";
                $this->db->query($query);
                $this->db->bind('id_wo',$data['id_wo']);
                $this->db->bind('id_material',$data['material'][$i]);
                $this->db->bind('qty',$data['qty'][$i]);
                $this->db->bind('harga',$data['harga'][$i]);
                $this->db->execute();
            }
        }


        $queryprogress ="INSERT INTO detail_progress VALUES (NULL, 1, :id_wo, :tanggal, NULL, NULL, NULL)";
        $this->db->query($queryprogress);
        $this->db->bind('id_wo', $data['id_wo']);
        $this->db->bind('tanggal', $data['tanggalwo']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    //update data work order
    public function updateWorkorder ($data, $nama_file)
    {
        // $query = "UPDATE work_order SET department =:department WHERE id_wo =:id_wo";

        $query = "UPDATE work_order SET department =:department, deskripsi =:deskripsi, id_teknisi =:id_teknisi, prioritas =:prioritas, id_kategori =:id_kategori, id_lokasi =:id_lokasi, status =:status, plan_biaya =:plan_biaya, drawing =:drawing WHERE id_wo =:id_wo";

        $this->db->query($query);
        $this->db->bind('id_wo', $data['id_wo']);
        $this->db->bind('department', $data['dept']);
        $this->db->bind('deskripsi', $data['deskripsi']);
        $this->db->bind('id_teknisi', $data['teknisi']);
        $this->db->bind('prioritas', $data['prioritas']);
        $this->db->bind('id_kategori', $data['kategori']);
        $this->db->bind('id_lokasi', $data['lokasi']);
        $this->db->bind('status', $data['status']);
        $this->db->bind('plan_biaya', $data['biaya']);
        $this->db->bind('drawing', $nama_file);
        $this->db->execute();

        //delete data lama detail pembelian
        $query = "DELETE FROM use_material WHERE id_wo =:id_wo";
        $this->db->query($query);
        $this->db->bind('id_wo',$data['id_wo']);
        $this->db->execute();

        for ( $i = 0 ; $i < 10 ; $i++ ){
            if ( !empty($data['material'][$i]) ){
                $query = "INSERT INTO use_material VALUES ( NULL, :id_wo, :id_material, :qty, NULL, NULL, :harga )";
                $this->db->query($query);
                $this->db->bind('id_wo',$data['id_wo']);
                $this->db->bind('id_material',$data['material'][$i]);
                $this->db->bind('qty',$data['qty'][$i]);
                $this->db->bind('harga',$data['harga'][$i]);
                $this->db->execute();
            }
        }

        return $this->db->rowCount();
    }

    public function approve ($id_wo, $id_role, $status, $id_progress, $durasi, $approve)
    {
        $tanggal = date('Y-m-d'); 


        if ($id_role == 3 || ($id_role == 7 && $approve == "Dept Head")){ //dept head & Dept HR
            //update tanggal aprrove date pada table wo
            $query ="UPDATE work_order SET approve_dept =:tanggal  WHERE id_wo =:id_wo";
            $this->db->query($query);
            $this->db->bind('id_wo',$id_wo);
            $this->db->bind('tanggal',$tanggal);
            $this->db->execute();

            //update progress work order created (finish)
            $queryprogress ="UPDATE detail_progress SET finish =:tanggal, status =:status, durasi =:durasi WHERE id_wo =:id_wo AND id_progress =:id_progress";
            $this->db->query($queryprogress);
            $this->db->bind('id_wo', $id_wo);
            $this->db->bind('id_progress', $id_progress);
            $this->db->bind('tanggal', $tanggal);
            $this->db->bind('status', $status);
            $this->db->bind('durasi', $durasi);
            $this->db->execute();

            //menambahkan progress wo verification
            $queryprogress ="INSERT INTO detail_progress VALUES (NULL, 2, :id_wo, :tanggal, NULL, NULL, NULL)";
            $this->db->query($queryprogress);
            $this->db->bind('id_wo', $id_wo);
            $this->db->bind('tanggal', $tanggal);
            $this->db->execute();

        } 
        
        if ($id_role == 7 && $approve == 'HR Dept Head'){ //check wo oleh HR Dept
            //update tanggal aprrove date pada table wo
            $query ="UPDATE work_order SET approve_hr =:tanggal  WHERE id_wo =:id_wo";
            $this->db->query($query);
            $this->db->bind('id_wo',$id_wo);
            $this->db->bind('tanggal',$tanggal);
            $this->db->execute();
            
            //update progress selesai verifikasi
            $queryprogress ="UPDATE detail_progress SET finish =:tanggal, status =:status, durasi =:durasi WHERE id_wo =:id_wo AND id_progress =:id_progress";
            $this->db->query($queryprogress);
            $this->db->bind('id_wo', $id_wo);
            $this->db->bind('id_progress', $id_progress);
            $this->db->bind('tanggal', $tanggal);
            $this->db->bind('status', $status);
            $this->db->bind('durasi', $durasi);
            $this->db->execute();
    
            //menambahkan progress approval setelah WO diverifikasi 
            $queryprogress ="INSERT INTO detail_progress VALUES (NULL, 3, :id_wo, :tanggal, NULL, NULL, NULL)";
            $this->db->query($queryprogress);
            $this->db->bind('id_wo', $id_wo);
            $this->db->bind('tanggal', $tanggal);
            $this->db->execute();
        } 

        if ($id_role == 5){ //div head
            
            //update progress div approve 
            $queryprogress ="UPDATE detail_progress SET finish =:tanggal, status =:status, durasi =:durasi WHERE id_wo =:id_wo AND id_progress =:id_progress";
            $this->db->query($queryprogress);
            $this->db->bind('id_wo', $id_wo);
            $this->db->bind('id_progress', $id_progress);
            $this->db->bind('tanggal', $tanggal);
            $this->db->bind('status', $status);
            $this->db->bind('durasi', $durasi);
            $this->db->execute();
            
            //update tanggal aprrove date pada table wo
            $query ="UPDATE work_order SET approve_div =:tanggal  WHERE id_wo =:id_wo";
            $this->db->query($query);
            $this->db->bind('id_wo',$id_wo);
            $this->db->bind('tanggal',$tanggal);
            $this->db->execute();
        }

        if ($id_role == 6){ //admin MTC

            //update tanggal verifikasi pada table work order
            $query ="UPDATE work_order SET verified =:tanggal  WHERE id_wo =:id_wo";
            $this->db->query($query);
            $this->db->bind('id_wo',$id_wo);
            $this->db->bind('tanggal',$tanggal);
            $this->db->execute();
        }

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

        $query_data = "INSERT INTO work_order VALUES ";

        for ($i=2 ; $i <= count($all_data) ; $i++){
            $id_wo      = $all_data [$i]['A'];
            $nama_wo    = $all_data [$i]['B'];
            $department = $all_data [$i]['C'];
            $deskripsi  = $all_data [$i]['D'];
            $drawing    = $all_data [$i]['E'];
            $target_selesai = $all_data [$i]['F'];
            $tgl_selesai    = $all_data [$i]['G'];
            $prioritas = $all_data [$i]['H'];
            $plan_biaya  = $all_data [$i]['I'];
            $act_biaya    = $all_data [$i]['J'];
            $status    = $all_data [$i]['K'];
            $tanggal      = $all_data [$i]['L'];
            $verified    = $all_data [$i]['M'];
            $approve_dept = $all_data [$i]['N'];
            $approve_div  = $all_data [$i]['O'];
            $create_by    = $all_data [$i]['P'];
            $id_lokasi    = $all_data [$i]['Q'];
            $id_kategori = $all_data [$i]['R'];
            $id_teknisi  = $all_data [$i]['S'];

            $query_data .= "('$id_wo', '$nama_wo', '$department', '$deskripsi', '$drawing','$target_selesai', '$tgl_selesai', '$prioritas', '$plan_biaya', '$act_biaya', '$status','$tanggal', '$verified', '$approve_dept', '$approve_div', '$create_by', '$id_lokasi','$id_kategori', '$id_teknisi'),";
        }

        $query_data = substr ($query_data, 0, -1);

        $this->db->query($query_data);
        $this->db->execute();

        return $this->db->rowCount();
        unlink($target_file);


    }

    //mengubah estimasi pengerjaan pada antrian
    public function tambahEstimasi($data)
    {
        $query = "UPDATE work_order SET estimasi =:estimasi  WHERE id_wo =:id_wo";

        $this->db->query($query);
        $this->db->bind('estimasi', $data['estimasi']);
        $this->db->bind('id_wo', $data['id_wo']);
        $this->db->execute();

        return $this->db->rowCount();
    }


}