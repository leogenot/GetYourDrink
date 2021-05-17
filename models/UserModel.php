<?php

class UserModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = Db::initDB();
    }


    static function get_user_db($username, $email)
    {
        $bdd = Db::initDB();
        $req = $bdd->prepare("SELECT * FROM user WHERE username=:uname OR email=:uemail"); //sql select query
        $req->execute(array(':uname' => $username, ':uemail' => $email));
        return $req;
    }

    static function get_user_db_register($username, $email)
    {
        $bdd = Db::initDB();
        $req = $bdd->prepare("SELECT username, email FROM user WHERE username=:uname OR email=:uemail"); //sql select query
        $req->execute(array(':uname' => $username, ':uemail' => $email));
        return $req;
    }

    static function insert_db_new_user($username, $email, $new_password)
    {
        $bdd = Db::initDB();
        $req = $bdd->prepare("INSERT INTO user	(username,email,password) VALUES (:uname,:uemail,:upassword)");
        if ($req->execute(array(':uname'    => $username, ':uemail'    => $email, ':upassword' => $new_password))) {
            return 1;
        }
        return 0;
    }

    static function get_number_of_shots($user_id)
    {
        $bdd = Db::initDB();
        $req = $bdd->prepare("SELECT count(*) FROM coktails WHERE userid=:uid"); //sql select query
        $req->execute(array(':uid' => $user_id));
        return $req;
    }
/* 
    static function add_shots($username)
    {
        $bdd = Db::initDB();
        $req = $bdd->prepare("INSERT INTO user FROM user WHERE username=:uname"); //sql select query
        $req->execute(array(':uname' => $username));
        return $req;
    } */
}

class TempUserModel extends UserModel
{
    static function get_user_db_temp_register($username)
    {
        $bdd = Db::initDB();
        $req = $bdd->prepare("SELECT username FROM user_temp WHERE username=:uname"); //sql select query
        $req->execute(array(':uname' => $username));
        return $req;
    }

    static function insert_db_new_user_temp($username, $user_id)
    {
        $bdd = Db::initDB();
        $req = $bdd->prepare("INSERT INTO user_temp	(user_id, username) VALUES (:userid, :uname)");
        if ($req->execute(array(':userid'    => $user_id, ':uname'    => $username))) {
            return 1;
        }
        return 0;
    }

    static function empty_user_temp_table($user_id)
    {
        $bdd = Db::initDB();
        $text_cards = $bdd->prepare('DELETE FROM user_temp WHERE user_id = ?');
        $affectedLines = $text_cards->execute(array($user_id));
        return $affectedLines;
    }
}
