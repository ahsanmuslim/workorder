<?php

class problem_model
{

    private $db;


    public function __construct()
    {
        $this->db = new Database();
    }

    //data problem
    public function dataproblem()
    {
        $query = 'SELECT problem.id_problem, problem.problem, problem.tindak_lanjut, problem.pic, problem.status, work_order.id_wo, work_order.nama_wo, work_order.status FROM problem 
        JOIN work_order ON work_order.id_wo=problem.id_wo 
        ORDER BY work_order.id_wo ASC';
        $this->db->query($query);
        return $this->db->resultSet();
    }

    //mengambil data problem berdasarkan ID untuk proses update
    public function getproblembyID($id_problem)
    {
        $query = 'SELECT problem.id_problem, problem.problem, problem.tindak_lanjut, problem.pic, problem.status, work_order.id_wo, work_order.nama_wo FROM problem 
        JOIN work_order ON work_order.id_wo=problem.id_wo 
        WHERE id_problem =:id_problem';
        $this->db->query($query);
        $this->db->bind('id_problem', $id_problem);
        return $this->db->single();
    }

    //mengambil data problem berdasarkan ID WO
    public function getproblembyWO($id_wo)
    {
        $query = 'SELECT * FROM problem WHERE id_wo =:id_wo';
        $this->db->query($query);
        $this->db->bind('id_wo', $id_wo);
        return $this->db->resultSet();
    }


    //cek data problem by id
    public function cekproblem($id_wo)
    {
        $query = "SELECT count(id_problem) FROM problem WHERE id_wo =:id_wo";
        $this->db->query($query);
        $this->db->bind('id_wo', $id_wo);
        return $this->db->numRow();
    }


    //tambah data problem
    public function tambahproblem($data)
    {
        $query = "INSERT INTO problem VALUES (NULL, :problem, :tindak_lanjut, :pic, :status, :id_wo)";

        $this->db->query($query);
        $this->db->bind('problem', $data['problem']);
        $this->db->bind('tindak_lanjut', $data['tindak_lanjut']);
        $this->db->bind('pic', $data['pic']);
        $this->db->bind('status', $data['status']);
        $this->db->bind('id_wo', $data['id_wo']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    //update data problem
    public function updateproblem($data)
    {
        $query = "UPDATE problem SET problem =:problem, tindak_lanjut =:tindak_lanjut, pic =:pic, status =:status, id_wo =:id_wo WHERE id_problem =:id_problem";

        $this->db->query($query);
        $this->db->bind('problem', $data['problem']);
        $this->db->bind('tindak_lanjut', $data['tindak_lanjut']);
        $this->db->bind('pic', $data['pic']);
        $this->db->bind('status', $data['status']);
        $this->db->bind('id_problem', $data['id_problem']);
        $this->db->bind('id_wo', $data['id_wo']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    //hapus data problem
    public function hapusproblem($id_problem)
    {
        $query = "DELETE FROM problem WHERE id_problem =:id_problem";
        $this->db->query($query);
        $this->db->bind('id_problem', $id_problem);
        $this->db->execute();
        return $this->db->rowCount();
    }
}
