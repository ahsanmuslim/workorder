<?php

class menu_model {

    private $table = 'submenu';
    private $db;  


    public function __construct ()
    {
        $this->db = new Database();
    }

    public function menuActive ()
    {
        if(isset($_SESSION['useractive'])){
            $user = $_SESSION['useractive'];

            $query = "SELECT DISTINCT nama_menu, submenu.id_menu FROM submenu 
            join user_acces on submenu.id_submenu=user_acces.id_submenu 
            join user_role on user_acces.id_role=user_role.id_role 
            join user on user.role=user_role.id_role 
            join menu on menu.id_menu=submenu.id_menu
            WHERE is_active = 1 AND username = '$user' ORDER BY submenu.id_menu";

            $this->db->query($query);
            return $this->db->resultSet();
        }
    }

    public function submenuActive ($id_menu)
    {
        if(isset($_SESSION['useractive'])){
            $user = $_SESSION['useractive'];

            $query = "SELECT user.username, user_role.role, menu.id_menu, menu.nama_menu, submenu.id_submenu, title, url, icon FROM submenu 
            join user_acces on submenu.id_submenu=user_acces.id_submenu 
            join user_role on user_acces.id_role=user_role.id_role 
            join user on user.role=user_role.id_role 
            join menu on menu.id_menu=submenu.id_menu
            WHERE is_active = 1 AND is_sidemenu = 1 AND username = '$user' AND submenu.id_menu= '$id_menu' ORDER BY title";

            $this->db->query($query);
            return $this->db->resultSet();
        }
    }

    public function getIDmenu ($url_menu)
    {
        $query = "SELECT * FROM ".$this->table." WHERE url =:url";
        $this->db->query($query);
        $this->db->bind('url', $url_menu);
        $this->db->execute();
        return $this->db->single();
    }

    public function getMenubyTitle ($title)
    {
        $query = "SELECT * FROM ".$this->table." WHERE title =:title";
        $this->db->query($query);
        $this->db->bind('title', $title);
        $this->db->execute();
        return $this->db->single();
    }

    public function allMenu ()
    {
        $query = "SELECT * FROM menu";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function allSubmenu ()
    {
        $query = "SELECT * FROM ".$this->table." 
        join menu on menu.id_menu=submenu.id_menu ORDER BY submenu.id_menu ASC";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function allSubmenuActive ()
    {
        $query = "SELECT * FROM ".$this->table." WHERE is_active = 1 ORDER BY title";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function cekDataMenu ($data)
	{
		$menu = $data['menu'];
        $cekdata = "SELECT * FROM menu WHERE nama_menu = '$menu'";
        $this->db->query($cekdata);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function cekDatabyIDMenu ($id_menu)
    {
        $cekdata = "SELECT * FROM submenu WHERE id_menu = '$id_menu'";
        $this->db->query($cekdata);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function cekDataSubmenu ($data)
	{
		$url = $data['url'];
        $cekdata = "SELECT * FROM submenu WHERE url = '$url'";
        $this->db->query($cekdata);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function cekDatabyIDSubmenu ($id_submenu)
    {
        $cekdata = "SELECT * FROM submenu WHERE id_menu = '$id_menu'";
        $this->db->query($cekdata);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function tambahDataMenu ($data)
	{
        $query = "INSERT INTO menu VALUES ( NULL, :menu )";
        
        $this->db->query($query);
        $this->db->bind('menu', $data['menu']);        
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function tambahDataSubmenu ($data)
	{
        $query = "INSERT INTO submenu VALUES ( NULL, :id_menu, :title, :url, :icon, :is_admin, :is_active )";
        
        $this->db->query($query);
        $this->db->bind('id_menu', $data['menu']);
        $this->db->bind('title', $data['title']); 
        $this->db->bind('url', $data['url']); 
        $this->db->bind('icon', $data['icon']); 
        $this->db->bind('is_admin', $data['sidemenu']); 
        $this->db->bind('is_active', $data['status']);   
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function updateDataMenu ($data)
	{
		$query = "UPDATE menu SET 
					nama_menu =:nama_menu
					WHERE id_menu =:id_menu";

        $this->db->query($query);
        $this->db->bind('id_menu', $data['id_menu']);
        $this->db->bind('nama_menu', $data['menu']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function updateDataSubmenu ($data)
	{
		$query = "UPDATE submenu SET 
					title =:title,
                    url =:url,
                    icon =:icon,
                    is_active =:is_active,
                    is_sidemenu =:sidemenu,
                    id_menu =:id_menu
					WHERE id_submenu =:id_submenu";

        $this->db->query($query);
        $this->db->bind('id_submenu', $data['id_submenu']);
        $this->db->bind('title', $data['title']);
        $this->db->bind('url', $data['url']);
        $this->db->bind('icon', $data['icon']);
        $this->db->bind('sidemenu', $data['sidemenu']); 
        $this->db->bind('is_active', $data['status']);
        $this->db->bind('id_menu', $data['menu']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function getDataMenu ($id_menu)
    {
        $this->db->query ('SELECT * FROM menu WHERE id_menu =:id_menu'); 
        $this->db->bind ( 'id_menu', $id_menu );
        return $this->db->single();
    }

    public function getDataSubmenu ($id_submenu)
    {
        $this->db->query ('SELECT * FROM submenu WHERE id_submenu =:id_submenu'); 
        $this->db->bind ( 'id_submenu', $id_submenu );
        return $this->db->single();
    }

    public function hapusDataMenu ($id_menu)
	{
		$query = " DELETE FROM menu WHERE id_menu =:id_menu ";

        $this->db->query($query);

        $this->db->bind('id_menu',$id_menu);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function hapusDataSubmenu ($url)
	{
		$query = " DELETE FROM submenu WHERE url =:url ";

        $this->db->query($query);

        $this->db->bind('url',$url);
        $this->db->execute();

        return $this->db->rowCount();
    }







}