<?php

class pembelian_model {

    private $table = 'pembelian';
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

    //fungsi untuk create code wo 
    public function getKodebeli()
    {
        // mengambil data wo dengan kode paling besar
        $query = "SELECT max(id_pembelian) as maxCode FROM pembelian";
        $this->db->query($query);
        return $this->db->resultSet();        
    }
    
    //data List up pembelian
    public function dataPembelian ()
    {
        $query = "SELECT pembelian.id_pembelian, pembelian.tgl_pembelian, pembelian.total, pembelian.id_wo, work_order.nama_wo, work_order.nama_wo, work_order.status, supplier.nama_supplier FROM pembelian
        join work_order on work_order.id_wo=pembelian.id_wo 
        join supplier on supplier.id_supplier=pembelian.id_supplier 
        ORDER BY tgl_pembelian DESC";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    //data detail pembelian by ID
    public function detailPembelian ($id_pembelian)
    {
        $query = "SELECT pembelian.id_pembelian, pembelian.tgl_pembelian, pembelian.total, pembelian.id_wo, work_order.nama_wo, work_order.status, supplier.nama_supplier, supplier.id_supplier FROM pembelian
        join work_order on work_order.id_wo=pembelian.id_wo 
        join supplier on supplier.id_supplier=pembelian.id_supplier 
        WHERE id_pembelian=:id_pembelian";
        $this->db->query($query);
        $this->db->bind ( 'id_pembelian', $id_pembelian );
        return $this->db->single();
    }

    //data detail material pembelian
    public function detailMaterial ($id_pembelian)
    {
        $query = "SELECT material.id_material, material.nama_material, material.satuan, detail_pembelian.harga, detail_pembelian.jumlah FROM detail_pembelian 
        join material on material.id_material=detail_pembelian.id_material  
        WHERE id_pembelian =:id_pembelian";
        $this->db->query($query);
        $this->db->bind ( 'id_pembelian', $id_pembelian );
        return $this->db->resultSet();
    }

    //data detail material pembelian
    public function detailBelibyWO ($id_wo)
    {
        $query = "SELECT pembelian.id_wo, pembelian.tgl_pembelian, supplier.nama_supplier, material.id_material, material.nama_material, material.satuan, detail_pembelian.harga, detail_pembelian.jumlah FROM detail_pembelian 
        join pembelian on pembelian.id_pembelian = detail_pembelian.id_pembelian 
        join supplier on pembelian.id_supplier = supplier.id_supplier 
        join material on material.id_material=detail_pembelian.id_material  
        WHERE id_wo =:id_wo";
        $this->db->query($query);
        $this->db->bind ( 'id_wo', $id_wo );
        return $this->db->resultSet();
    }

    //tambah data pembelian
    public function tambahPembelian ($data, $count, $status)
    {
        $query = "INSERT INTO pembelian VALUES ( :id_pembelian, :tanggal, :total, :id_wo, :id_supplier)";
        $this->db->query($query);
        $this->db->bind('id_pembelian', $data['id_pembelian']);
        $this->db->bind('tanggal', $data['tanggal']);
        $this->db->bind('total', $data['grandtotal']);
        $this->db->bind('id_wo', $data['id_wo']);
        $this->db->bind('id_supplier', $data['supplier']);
        $this->db->execute();

        // //update status detail progress pembelian menjadi closed
        $progress = "UPDATE detail_progress SET finish =:finish, status =:status WHERE id_wo =:id_wo AND id_progress = 5";
        $this->db->query($progress);
        $this->db->bind('finish', $data['tanggal'] );
        $this->db->bind('id_wo', $data['id_wo'] );
        $this->db->bind('status', $status );
        $this->db->execute();

        // //hapus jika ada progress waiting list
        $hapus = "DELETE FROM detail_progress WHERE id_wo =:id_wo AND id_progress = 6";
        $this->db->query($hapus);
        $this->db->bind('id_wo',$data['id_wo']);
        $this->db->execute();

        //insert detail status waiting list setelah pembelian
        $progress = "INSERT INTO detail_progress VALUES (NULL, :id_progress, :id_wo, :start, NULL, NULL, NULL)";
        $this->db->query($progress);
        $this->db->bind('id_progress', 6 );//is progress waiting list
        $this->db->bind('id_wo', $data['id_wo']);
        $this->db->bind('start', $data['tanggal']);

        $this->db->execute();


        for ( $i = 0 ; $i < $count ; $i++ ){
            $query = "INSERT INTO detail_pembelian VALUES ( NULL, :id_pembelian, :id_material, :qty, :harga)";
            $this->db->query($query);
            $this->db->bind('id_pembelian',$data['id_pembelian']);
            $this->db->bind('id_material',$data['id_material'][$i]);
            $this->db->bind('qty',$data['qty'][$i]);
            $this->db->bind('harga',$data['harga'][$i]);
            $this->db->execute();
        }

        return $this->db->rowCount();


    }
    

    //update data pembelian
    public function updatePembelian ($data,$count, $status)
    {
        //update status detail progress pembelian menjadi closed
        $progress = "UPDATE detail_progress SET finish =:finish, status =:status WHERE id_wo =:id_wo AND id_progress = 5";
        $this->db->query($progress);
        $this->db->bind('finish', $data['tanggal'] );
        $this->db->bind('id_wo', $data['id_wo'] );
        $this->db->bind('status', $status );

        $this->db->execute();

        //update pada tabel pembelian
        $query = "UPDATE pembelian SET tgl_pembelian =:tanggal, id_supplier =:supplier, total =:total WHERE id_pembelian =:id_pembelian";
        $this->db->query($query);
        $this->db->bind('id_pembelian', $data['id_pembelian']);
        $this->db->bind('tanggal', $data['tanggal']);
        $this->db->bind('total', $data['grandtotal']);
        $this->db->bind('supplier', $data['supplier']);
        $this->db->execute();

        //delete data lama detail pembelian
        $query = "DELETE FROM detail_pembelian WHERE id_pembelian =:id_pembelian";
        $this->db->query($query);
        $this->db->bind('id_pembelian',$data['id_pembelian']);
        $this->db->execute();

        //insert data baru detail pembelian
        for ( $i = 0 ; $i < $count ; $i++ ){
            $query = "INSERT INTO detail_pembelian VALUES ( NULL, :id_pembelian, :id_material, :qty, :harga)";
            $this->db->query($query);
            $this->db->bind('id_pembelian',$data['id_pembelian']);
            $this->db->bind('id_material',$data['id_material'][$i]);
            $this->db->bind('qty',$data['qty'][$i]);
            $this->db->bind('harga',$data['harga'][$i]);
            $this->db->execute();
        }

        return $this->db->rowCount();
    }


    //hapus data pembelian
    public function hapusPembelian ($id_pembelian)
    {
        //hapus data pada tabel detail pembelian
        $detail_query = "DELETE FROM detail_pembelian WHERE id_pembelian =:id_pembelian";
        $this->db->query($detail_query);
        $this->db->bind('id_pembelian',$id_pembelian);
        $this->db->execute();

        //hapus data pada tabel pembelian
        $query = "DELETE FROM pembelian WHERE id_pembelian =:id_pembelian";
        $this->db->query($query);
        $this->db->bind('id_pembelian',$id_pembelian);
        $this->db->execute();


        return $this->db->rowCount();
    }




}