<?php

class auth_model {

    private $table = 'user';
    private $db;


    public function __construct (){
        $this->db = new Database ();        
    }


    public function cekLogin()
    {
        $username = $_POST['user'];
        $password = SHA1($_POST['pass']);

        $cekdata = "SELECT * FROM ".$this->table." WHERE username =:username AND password =:password ";
        $this->db->query($cekdata);

        $this->db->bind('username',$username);
        $this->db->bind('password',$password);

        $this->db->execute();
        return $this->db->rowCount();
    }

    
    public function cekAktivasi()
    {
        $username = $_POST['user'];

        $cekdata = "SELECT * FROM ".$this->table." WHERE username =:username AND status = 1";
        $this->db->query($cekdata);
        $this->db->bind('username',$username);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function cekAktivasi2($email)
    {
        $cekdata = "SELECT * FROM ".$this->table." WHERE email =:email AND status = 1";
        $this->db->query($cekdata);
        $this->db->bind('email',$email);
        $this->db->execute();
        return $this->db->rowCount();
    }


}