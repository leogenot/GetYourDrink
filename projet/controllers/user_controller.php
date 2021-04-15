<?php

class UserController
{


    static function get_session($name)
    {
        if (isset($_SESSION) && isset($_SESSION[$name]))
            return $_SESSION[$name];
        return null;
    }

    


    /**
     * Créer une session avec plusieurs paramètres et valeurs
     * exemple: ( make_sessions(array('username' => 'username', 'email' => 'email@gemail.com')

     */
    static function make_sessions(array $options)
    {
        if (!isset($options) || empty($options))
            throw new Exception("Vous devez fournir les valeurs cle => valeur pour creer la session ");
        foreach ($options as $name => $value) {
            $_SESSION[$name] = $value;
        }
    }
    /**
     * Connecte un utilisateur en le redirigeants vers la page spécifiée en argument
     * exemple: login('home.php or home.php or accueil.php')

     */
    static function login($urlTo, array $options = [])
    {
        if (!empty($options)) {
            UserController::make_sessions($options);
            FunctionsController::redirect($urlTo);
        } else
            throw new Exception("Vous devez fournir une liste de cle => valeur pour la création de la session");
    }

    /**
     * connecte un utilisateur sur le site

     */
    static function user_logged($username, $email, $password, $urlTo)
    {


        if (empty($username)) {
            echo "please enter username or email";    //check "username/email" textbox not empty 
        } else if (empty($email)) {
            echo "please enter username or email";    //check "username/email" textbox not empty 
        } else if (empty($password)) {
            echo "please enter password";    //check "passowrd" textbox not empty 
        } else {
            try {



                $row = UserModel::get_user_db($username, $email)->fetch(PDO::FETCH_ASSOC);

                if (UserModel::get_user_db($username, $email)->rowCount() > 0)    //check condition database record greater zero after continue
                {

                    if ($username == $row["username"] or $email == $row["email"]) //check condition user taypable "username or email" are both match from database "username or email" after continue
                    {
                        if (password_verify($password, $row["password"])) //check condition user taypable "password" are match from database "password" using password_verify() after continue
                        {
                            var_dump($row["id"]);
                            $_SESSION["is_authentificate"] = $row["id"];    //session name is "user_login"
                            UserController::login($urlTo, array(
                                'is_authentificate' => 'oui',
                                'user_id' => $row['id'],
                                'usermail' => $row['email'],
                                'username' => $row['username'],
                            ));
                            echo "Successfully Login...";
                            FunctionsController::redirect($urlTo);
                        } else {
                            echo "wrong password";
                        }
                    } else {
                        echo "wrong username or email";
                    }
                } else {
                    echo "wrong username or email";
                }
            } catch (PDOException $e) {
                $e->getMessage();
            }
        }
    }

    /**
     * Deconnecte un utilisateur et le redirige vers la page passée en argument
     * exemple: logout('connexion.php')

     */
    static function logout($fileTo)
    {
        session_start();
        $user_id = $_SESSION["user_id"];
        TempUserModel::empty_user_temp_table($user_id);
        session_destroy();
        FunctionsController::redirect($fileTo);
        exit;
    }

    static function user_register($username, $email, $password, $urlTo)
    {
        if (empty($username)) {
            echo "Please enter username";    //check username textbox not empty 
        } else if (empty($email)) {
            echo "Please enter email";    //check email textbox not empty 
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Please enter a valid email address";    //check proper email format 
        } else if (empty($password)) {
            echo "Please enter password";    //check passowrd textbox not empty
        } else if (strlen($password) < 6) {
            $errorMsg[] = "Password must be atleast 6 characters";    //check passowrd must be 6 characters
        } else {
            try {

                $row = UserModel::get_user_db_register($username, $email)->fetch(PDO::FETCH_ASSOC);

                if ($row["username"] == $username) {
                    echo "Sorry username already exists";    //check condition username already exists 
                } else if ($row["email"] == $email) {
                    echo "Sorry email already exists";    //check condition email already exists 
                } else if (!isset($errorMsg)) //check no "$errorMsg" show then continue
                {
                    $new_password = password_hash($password, PASSWORD_DEFAULT); //encrypt password using password_hash()

                    if (UserModel::insert_db_new_user($username, $email, $new_password) == 1) {
                        echo "Register Successfully..... Please Click On Login Account Link";
                        FunctionsController::redirect($urlTo);
                    }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
}

class TempUserController extends UserController
{

    static function register_temp_user($username, $urlTo)
    {
        $user_id = $_SESSION["user_id"];
        if (empty($username)) {
            echo "Please enter username";    //check username textbox not empty 
        } else {
            try {

                $row = TempUserModel::get_user_db_temp_register($username)->fetch(PDO::FETCH_ASSOC);

                if ($row["username"] == $username) {
                    echo "Sorry username already exists";    //check condition username already exists 
                } else if (!isset($errorMsg)) //check no "$errorMsg" show then continue
                {

                    if (TempUserModel::insert_db_new_user_temp($username, $user_id) == 1) {
                        echo "Register Successfully.....";
                        FunctionsController::redirect($urlTo);
                    }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
}
