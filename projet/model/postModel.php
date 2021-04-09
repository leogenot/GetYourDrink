<?php

require($_SERVER['DOCUMENT_ROOT'] . "/projet/model/Model.php");
function getPosts()
{
    $bdd = dbConnect();
    $req = $bdd->query('SELECT id, content,shots, date FROM card ORDER BY date DESC LIMIT 0, 5');


    return $req;
}

function getPost($postId)
{
    $bdd = dbConnect();
    $req = $bdd->prepare('SELECT id, likes, content, shots, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM posts WHERE id = ?');
    $req->execute(array($postId));
    $post = $req->fetch();

    return $post;
}
function empty_user_temp_table($user_id)
{
    $bdd = dbConnect();
    $text_cards = $bdd->prepare('DELETE FROM user_temp WHERE user_id = ?');
    $affectedLines = $text_cards->execute(array($user_id));
    return $affectedLines;
}
function number_of_cards()
{
    $bdd = dbConnect();
    $number_of_cards = $bdd->query('SELECT COUNT(*) FROM card');
    $number_of_cards->execute();
    return $number_of_cards->fetchColumn();
}

function number_of_users()
{
    $bdd = dbConnect();
    $number_of_users = $bdd->query('SELECT COUNT(*) FROM user');
    $number_of_users->execute();
    return $number_of_users->fetchColumn();
}

function get_user_db($username, $email)
{
    $bdd = dbConnect();
    $req = $bdd->prepare("SELECT * FROM user WHERE username=:uname OR email=:uemail"); //sql select query
    $req->execute(array(':uname' => $username, ':uemail' => $email));
    return $req;
}

function get_user_db_register($username, $email)
{
    $bdd = dbConnect();
    $req = $bdd->prepare("SELECT username, email FROM user WHERE username=:uname OR email=:uemail"); //sql select query
    $req->execute(array(':uname' => $username, ':uemail' => $email));
    return $req;
}

function get_user_db_temp_register($username)
{
    $bdd = dbConnect();
    $req = $bdd->prepare("SELECT username FROM user_temp WHERE username=:uname"); //sql select query
    $req->execute(array(':uname' => $username));
    return $req;
}


function insert_db_new_user($username, $email, $new_password)
{
    $bdd = dbConnect();
    $req = $bdd->prepare("INSERT INTO user	(username,email,password) VALUES (:uname,:uemail,:upassword)");     					
    if ($req->execute(array(':uname'    => $username, ':uemail'    => $email, ':upassword' => $new_password))) {
        return 1;
    
    }
    return 0;
}

function insert_db_new_user_temp($username, $user_id)
{
    $bdd = dbConnect();
    $req = $bdd->prepare("INSERT INTO user_temp	(user_id, username) VALUES (:userid, :uname)");     					
    if ($req->execute(array(':userid'    => $user_id, ':uname'    => $username))) {
        return 1;
    
    }
    return 0;
}

function add_user_db($username, $email, $password)
{
    $bdd = dbConnect();
    $row = get_user_db($username, $email);

    if ($row["username"] == $username) {
        echo "Sorry username already exists";    //check condition username already exists 
    } else if ($row["email"] == $email) {
        echo "Sorry email already exists";    //check condition email already exists 
    } else if (!isset($errorMsg)) //check no "$errorMsg" show then continue
    {
        $new_password = password_hash($password, PASSWORD_DEFAULT); //encrypt password using password_hash()

        $insert_stmt = $bdd->prepare("INSERT INTO user	(username,email,password) VALUES
                                                        (:uname,:uemail,:upassword)");         //sql insert query					

        if ($insert_stmt->execute(array(
            ':uname'    => $username,
            ':uemail'    => $email,
            ':upassword' => $new_password
        ))) {

            echo "Register Successfully..... Please Click On Login Account Link"; //execute query success message
        }
    }
}


function postCard($cardId, $gorgees, $text_card)
{
    $bdd = dbConnect();
    $text_cards = $bdd->prepare('INSERT INTO card(id, date, content, shots) VALUES(?, NOW(), ?, ?)');
    $affectedLines = $text_cards->execute(array($cardId, $text_card, $gorgees));

    return $affectedLines;
}



