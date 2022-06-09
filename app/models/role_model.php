<?php

class role_model
{

    private $table = 'user_role';
    private $db;


    public function __construct()
    {
        $this->db = new Database();
    }

    public function getRole()
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' ORDER BY role ASC');
        return $this->db->resultSet();
    }

    public function getDataRole($id_role)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id_role =:id_role');
        $this->db->bind('id_role', $id_role);
        return $this->db->single();
    }

    public function cekData($data)
    {
        $role = $data['role'];
        $cekdata = "SELECT * FROM " . $this->table . " WHERE role = '$role'";
        $this->db->query($cekdata);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function cekDatabyID($id_role)
    {
        $cekdata = "SELECT * FROM user WHERE role = '$id_role'";
        $this->db->query($cekdata);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function tambahData($data)
    {
        $query = "INSERT INTO " . $this->table . " VALUES ( NULL, :role )";

        $this->db->query($query);
        $this->db->bind('role', $data['role']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function hapusData($id_role)
    {
        $query = " DELETE FROM " . $this->table . " WHERE id_role =:id_role ";

        $this->db->query($query);

        $this->db->bind('id_role', $id_role);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function updateData($data)
    {
        $query = "UPDATE " . $this->table . " SET 
					role =:role
					WHERE id_role =:id_role";

        $this->db->query($query);
        $this->db->bind('id_role', $data['id_role']);
        $this->db->bind('role', $data['role']);
        $this->db->execute();

        return $this->db->rowCount();
    }


    public function updateAkses($id_role, $id_submenu, $count, $createlist, $updatelist, $deletelist, $printlist)
    {
        $hapus = "DELETE FROM user_acces WHERE id_role =:id_role";
        $this->db->query($hapus);
        $this->db->bind('id_role', $id_role);
        $this->db->execute();

        for ($i = 0; $i < $count; $i++) {
            $query = "INSERT INTO user_acces VALUES ( NULL, :id_role, :id_submenu, NULL, NULL, NULL, NULL )";
            $this->db->query($query);
            $this->db->bind('id_role', $id_role);
            $this->db->bind('id_submenu', $id_submenu[$i]);
            $this->db->execute();
        }

        if (!empty($createlist)) {
            foreach ($createlist as $cl) :
                $query = "UPDATE user_acces SET 
                        create_data = 1
                        WHERE id_role =:id_role AND id_submenu =:id_submenu";
                $this->db->query($query);
                $this->db->bind('id_role', $id_role);
                $this->db->bind('id_submenu', $cl);
                $this->db->execute();
            endforeach;
        }

        if (!empty($updatelist)) {
            foreach ($updatelist as $ul) :
                $query = "UPDATE user_acces SET 
                        update_data = 1
                        WHERE id_role =:id_role AND id_submenu =:id_submenu";
                $this->db->query($query);
                $this->db->bind('id_role', $id_role);
                $this->db->bind('id_submenu', $ul);
                $this->db->execute();
            endforeach;
        }

        if (!empty($deletelist)) {
            foreach ($deletelist as $dl) :
                $query = "UPDATE user_acces SET 
                        delete_data = 1
                        WHERE id_role =:id_role AND id_submenu =:id_submenu";
                $this->db->query($query);
                $this->db->bind('id_role', $id_role);
                $this->db->bind('id_submenu', $dl);
                $this->db->execute();
            endforeach;
        }

        if (!empty($printlist)) {
            foreach ($printlist as $pl) :
                $query = "UPDATE user_acces SET 
                        print_data = 1
                        WHERE id_role =:id_role AND id_submenu =:id_submenu";
                $this->db->query($query);
                $this->db->bind('id_role', $id_role);
                $this->db->bind('id_submenu', $pl);
                $this->db->execute();
            endforeach;
        }

        return $this->db->rowCount();
    }

    public function countPrint($id_role, $controller)
    {
        $query = "SELECT user_acces.id_role, role, user_acces.id_submenu, title, url FROM user_acces 
        JOIN submenu ON submenu.id_submenu=user_acces.id_submenu 
        JOIN user_role ON user_role.id_role=user_acces.id_role  
        WHERE user_acces.id_role =:id_role AND url =:url AND print_data = 1";
        $this->db->query($query);
        $this->db->bind('id_role', $id_role);
        $this->db->bind('url', $controller);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function countDelete($id_role, $controller)
    {
        $query = "SELECT user_acces.id_role, role, user_acces.id_submenu, title, url FROM user_acces 
        JOIN submenu ON submenu.id_submenu=user_acces.id_submenu 
        JOIN user_role ON user_role.id_role=user_acces.id_role  
        WHERE user_acces.id_role =:id_role AND url =:url AND delete_data = 1";
        $this->db->query($query);
        $this->db->bind('id_role', $id_role);
        $this->db->bind('url', $controller);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function countCreate($id_role, $controller)
    {
        $query = "SELECT user_acces.id_role, role, user_acces.id_submenu, title, url FROM user_acces 
        JOIN submenu ON submenu.id_submenu=user_acces.id_submenu 
        JOIN user_role ON user_role.id_role=user_acces.id_role  
        WHERE user_acces.id_role =:id_role AND url =:url  AND create_data = 1";
        $this->db->query($query);
        $this->db->bind('id_role', $id_role);
        $this->db->bind('url', $controller);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function countUpdate($id_role, $controller)
    {
        $query = "SELECT user_acces.id_role, role, user_acces.id_submenu, title, url FROM user_acces 
        JOIN submenu ON submenu.id_submenu=user_acces.id_submenu 
        JOIN user_role ON user_role.id_role=user_acces.id_role  
        WHERE user_acces.id_role =:id_role AND url =:url  AND update_data = 1";
        $this->db->query($query);
        $this->db->bind('id_role', $id_role);
        $this->db->bind('url', $controller);
        $this->db->execute();

        return $this->db->rowCount();
    }


    public function countAccess($id_role, $controller)
    {
        $query = "SELECT user_acces.id_role, role, user_acces.id_submenu, title, url FROM user_acces 
        JOIN submenu ON submenu.id_submenu=user_acces.id_submenu 
        JOIN user_role ON user_role.id_role=user_acces.id_role 
        WHERE user_acces.id_role =:id_role AND url =:url";
        $this->db->query($query);
        $this->db->bind('id_role', $id_role);
        $this->db->bind('url', $controller);
        $this->db->execute();

        return $this->db->rowCount();
    }
}
