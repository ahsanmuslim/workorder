<?php

class report_model {

    private $db;  


    public function __construct ()
    {
        $this->db = new Database();
    }

    //menampilkan data raw work order
    public function getReportWO ()
    {
        $query = "";
        $this->db->query($query);
        return $this->db->resultSet();
    }


 }