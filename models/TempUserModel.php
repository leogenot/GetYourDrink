<?php

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
