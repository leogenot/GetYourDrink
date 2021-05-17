<?php

class tempuser_controller extends user_controller
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
                        functions_controller::redirect($urlTo);
                    }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
}