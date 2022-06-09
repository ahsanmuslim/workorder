<?php

class chat_model
{

    private $table = 'chat_message';
    private $db;


    public function __construct()
    {
        $this->db = new Database();
    }

    //menampilkan chat message di task menu
    public function getChatdetail($id_receiver, $id_sender)
    {
        $query = "SELECT * FROM chat_message WHERE (to_user=:id_receiver AND from_user=:id_sender) OR (to_user=:id_sender AND from_user=:id_receiver) ORDER BY chat_time ASC LIMIT 100";
        $this->db->query($query);
        $this->db->bind('id_receiver', $id_receiver);
        $this->db->bind('id_sender', $id_sender);
        return $this->db->resultSet();
    }

    //data unread by user
    public function getUnreaduser($id_user)
    {
        $query = "SELECT to_user, from_user, chat_message, readed, chat_time FROM chat_message WHERE to_user=:id_user AND readed = 0 ORDER BY chat_time ASC";
        $this->db->query($query);
        $this->db->bind('id_user', $id_user);
        return $this->db->resultSet();
    }

    //user info
    public function getUserInfo($id_user)
    {
        $query = "SELECT username, nama_user, id_user, profile, id_telegram, last_activity FROM user WHERE id_user =:id_user";
        $this->db->query($query);
        $this->db->bind('id_user', $id_user);
        return $this->db->single();
    }

    //data chat receive by user
    public function getChatbyUser($id_user)
    {
        $query = "SELECT * FROM chat_message WHERE to_user=:id_user AND readed = 0 ORDER BY chat_time DESC";
        $this->db->query($query);
        $this->db->bind('id_user', $id_user);
        return $this->db->resultSet();
    }

    //MENAMPILKNA DATA LIST USER
    public function getUser($id_user)
    {
        $query = "SELECT username, nama_user, user.id_user, profile, id_telegram, last_activity FROM user WHERE user.id_user !=:id_user ORDER BY last_activity DESC";
        $this->db->query($query);
        $this->db->bind('id_user', $id_user);
        return $this->db->resultSet();
    }

    //mengambil data chat terakhir
    public function lastChat($id_receiver, $id_sender)
    {
        $query = "SELECT * FROM chat_message WHERE (to_user=:id_receiver AND from_user=:id_sender) OR (to_user=:id_sender AND from_user=:id_receiver) ORDER BY chat_time DESC LIMIT 1";
        $this->db->query($query);
        $this->db->bind('id_receiver', $id_receiver);
        $this->db->bind('id_sender', $id_sender);
        return $this->db->single();
    }

    public function unreadChat($id_sender, $id_receiver)
    {
        $query = "SELECT * FROM chat_message WHERE to_user=:id_sender AND from_user=:id_receiver AND readed = 0 ORDER BY chat_time DESC";
        $this->db->query($query);
        $this->db->bind('id_receiver', $id_receiver);
        $this->db->bind('id_sender', $id_sender);
        return $this->db->resultSet();
    }

    //tambah data chat baru
    public function saveChat($data)
    {
        $query = "INSERT INTO chat_message VALUES ( NULL, :to_user, :from_user, :chat, 0, NULL)";
        $this->db->query($query);
        $this->db->bind('to_user', $data['id_receiver']);
        $this->db->bind('from_user', $data['id_sender']);
        $this->db->bind('chat', $data['chat']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    //chat readed
    public function readChat($data)
    {
        $query = "UPDATE chat_message SET readed = 1 WHERE to_user =:to_user AND from_user =:from_user ";
        $this->db->query($query);
        $this->db->bind('from_user', $data['id_receiver']);
        $this->db->bind('to_user', $data['id_sender']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    //tambah data chat baru
    public function lastLogin($id_user)
    {
        $query = "INSERT INTO login_detail VALUES ( NULL, :id_user, NULL)";
        $this->db->query($query);
        $this->db->bind('id_user', $id_user);
        $this->db->execute();

        $now = date("Y-m-d H:i:s");
        $query = "UPDATE user SET last_activity =:now WHERE id_user =:id_user";
        $this->db->query($query);
        $this->db->bind('id_user', $id_user);
        $this->db->bind('now', $now);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function updateLastactivity($id_user)
    {
        $now = date("Y-m-d H:i:s");
        $query = "UPDATE user SET last_activity =:now WHERE id_user =:id_user";
        $this->db->query($query);
        $this->db->bind('id_user', $id_user);
        $this->db->bind('now', $now);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function getUpdatelastchat($id_sender)
    {
        // $query = "SELECT * FROM chat_message WHERE to_user=:id_sender AND readed = 0 ORDER BY chat_time DESC";
        $query = "SELECT to_user, from_user, count(id_chat) as jml FROM chat_message WHERE to_user=:id_sender AND readed = 0 GROUP BY from_user";
        $this->db->query($query);
        $this->db->bind('id_sender', $id_sender);
        return $this->db->resultSet();
    }

    public function getOnline($id_sender)
    {
        $query = "SELECT id_user, last_activity FROM user WHERE id_user!=:id_user";
        $this->db->query($query);
        $this->db->bind('id_user', $id_sender);
        return $this->db->resultSet();
    }
}
