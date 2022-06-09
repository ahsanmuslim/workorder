<?php

class user_model
{

    private $table = 'user';
    private $db;


    public function __construct()
    {
        $this->db = new Database();
    }


    public function getUser()
    {
        if (isset($_SESSION['useractive'])) {
            $user = $_SESSION['useractive'];
            $query = "SELECT user.id_user, user.nama_user, user.role, user.profile, user.password, user.tgl_register, user.email, user.username, user.nama_user, user.no_telp, user.id_telegram, user_role.role as nama_role, nama_divisi, user.id_dept, department.nama_dept, department.kode FROM " . $this->table . " 
            JOIN department ON user.id_dept = department.id_dept 
            JOIN divisi ON divisi.id_divisi = department.id_divisi  
            JOIN user_role ON user.role = user_role.id_role  
            WHERE username = '$user'";
            $this->db->query($query);

            return $this->db->single();
        }
    }

    public function getUserbyID($id_user)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id_user =:id_user');
        $this->db->bind('id_user', $id_user);
        return $this->db->single();
    }

    public function getUserbyEmail($email)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE email =:email');
        $this->db->bind('email', $email);
        return $this->db->single();
    }

    public function getDivhead()
    {
        $query = "SELECT user.nama_user, user_role.role FROM user join user_role on user.role = user_role.id_role WHERE user_role.id_role = 5";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function getDepthead()
    {
        $query = "SELECT user.nama_user, user_role.role FROM user join user_role on user.role = user_role.id_role WHERE user_role.id_role = 3 OR user_role.id_role = 7";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function getStaff()
    {
        $query = "SELECT user.id_user, user.nama_user, user_role.role FROM user join user_role on user.role = user_role.id_role WHERE user_role.id_role = 2 OR user_role.id_role = 3";
        $this->db->query($query);
        return $this->db->resultSet();
    }


    public function cekUsername()
    {
        $username = $_POST['username'];
        $query = "SELECT count(id_user) FROM " . $this->table . " WHERE username = '$username'";
        $this->db->query($query);
        return $this->db->numRow();
    }

    public function cekEmail()
    {
        $email = $_POST['email'];
        $query = "SELECT count(id_user) FROM " . $this->table . " WHERE email = '$email'";
        $this->db->query($query);
        return $this->db->numRow();
    }

    public function cekEmailAktivasi($email)
    {
        $query = "SELECT count(id_token) FROM token WHERE email = '$email'";
        $this->db->query($query);
        return $this->db->numRow();
    }

    public function cekTokenAktivasi($token)
    {
        $query = "SELECT count(id_token) FROM token WHERE token = '$token'";
        $this->db->query($query);
        return $this->db->numRow();
    }

    public function cekUserdiWO($id_user)
    {
        $cekdata = "SELECT * FROM work_order WHERE create_by =:id_user";
        $this->db->query($cekdata);
        $this->db->bind('id_user', $id_user);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function dataToken($token)
    {
        $query = "SELECT * FROM token WHERE token = '$token'";
        $this->db->query($query);
        return $this->db->single();
    }

    public function dataUser()
    {
        $query = "SELECT id_user, password, nama_user, username, email, no_telp, tgl_register, password, status, id_role, user_role.role, nama_dept FROM " . $this->table . "
        JOIN user_role ON " . $this->table . ".role = user_role.id_role 
        JOIN department ON user.id_dept = department.id_dept 
        ORDER BY user.id_dept";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    // menambahkan data user lewat administrator
    public function tambahData($data)
    {
        $query = "INSERT INTO " . $this->table . " 
        VALUES  
        (NULL, :username, :namauser, :email, :no_telp, :role, :password, :id_dept, :status, NULL, 'default.jpg', '747278008', NULL)";

        $this->db->query($query);

        $this->db->bind('username', $data['username']);
        $this->db->bind('namauser', $data['namauser']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('no_telp', $data['no_telp']);
        $this->db->bind('role', $data['role']);
        $this->db->bind('password', SHA1($data['password']));
        $this->db->bind('id_dept', $data['dept']);
        $this->db->bind('status', $data['status']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    //menambahkan data user lewat registrasi
    public function tambahUser($data)
    {
        $query = "INSERT INTO " . $this->table . " 
        VALUES  
        (NULL, :username, :namauser, :email, :no_telp, 2, :password, :dept, 0, NULL, 'default.jpg', NULL, NULL)";

        $this->db->query($query);

        // $this->db->bind('id_user', $data['id_user']);
        $this->db->bind('username', $data['username']);
        $this->db->bind('namauser', $data['namauser']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('no_telp', $data['no_telp']);
        $this->db->bind('password', SHA1($data['password1']));
        $this->db->bind('dept', $data['dept']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function tambahToken($email, $token)
    {
        $query = "INSERT INTO token VALUES (NULL, :email, :token, NULL)";

        $this->db->query($query);

        $this->db->bind('email', $email);
        $this->db->bind('token', $token);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function hapusToken($token)
    {
        $query = "DELETE FROM token WHERE token =:token";
        $this->db->query($query);
        $this->db->bind('token', $token);
        $this->db->execute();
    }

    public function hapusUser($email)
    {
        $query = "DELETE FROM user WHERE email =:email";
        $this->db->query($query);
        $this->db->bind('email', $email);
        $this->db->execute();
    }

    public function aktivasiUser($email)
    {
        $query = "UPDATE user SET status = 1 WHERE email =:email";
        $this->db->query($query);
        $this->db->bind('email', $email);
        $this->db->execute();
    }

    public function updateData($data)
    {
        $query = "UPDATE " . $this->table . " SET 
                    nama_user =:namauser,
                    username =:username,
                    role =:role,
                    id_dept =:id_dept,
					status =:status 
					WHERE id_user =:id_user";

        $this->db->query($query);

        $this->db->bind('id_user', $data['id_user']);
        $this->db->bind('username', $data['username']);
        $this->db->bind('namauser', $data['namauser']);
        $this->db->bind('role', $data['role']);
        $this->db->bind('id_dept', $data['dept']);
        $this->db->bind('status', $data['status']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function updateProfile($data, $nama_file)
    {
        $query = "UPDATE " . $this->table . " SET 
                    nama_user =:namauser,
                    email =:email,
                    no_telp =:no_telp,
                    profile =:profile
                    WHERE id_user =:id_user";

        $this->db->query($query);

        $this->db->bind('id_user', $data['id_user']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('namauser', $data['namauser']);
        $this->db->bind('no_telp', $data['no_telp']);
        $this->db->bind('profile', $nama_file);

        $this->db->execute();

        return $this->db->rowCount();
    }


    public function updatePassword($data)
    {
        $query = "UPDATE " . $this->table . " SET 
					password =:password
					WHERE id_user =:id_user";

        $this->db->query($query);

        $this->db->bind('id_user', $data['id_user']);
        $this->db->bind('password', SHA1($data['passwordbaru']));

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function hapusData($id_user)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id_user =:id_user";

        $this->db->query($query);

        $this->db->bind('id_user', $id_user);
        $this->db->execute();

        return $this->db->rowCount();
    }
}
