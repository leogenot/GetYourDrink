<?php

require($_SERVER['DOCUMENT_ROOT'] . "/projet/model/postModel.php");



function listPosts()
{
    $card = getPosts();

    require_once('views/frontend/indexListView.php');
}

function post()
{
    $min = 1;
    $max = number_of_cards();
    $id = rand($min, $max);
    $post = getPost($id);

    require_once('views/frontend/indexView.php');
}

/**
 * Liker un card à partir de son id et celui de l'utilisateur

 */
function likes_cards_by_id($card_id)
{
    $error = null;
    //verifier si cet card à deja un like de cet utilisateur, si oui on le retire
    $likes_data = findBy(['likes'], 'COUNT(id) as is_like, id as id_like', 'likes.user_id = ' . get_session('user_id') . ' AND likes.card_id = ' . $card_id);
    if (!is_null($likes_data) && $likes_data->is_like == 1) {
        try {
            remove_like_by_id($likes_data->id_like);
        } catch (Exception $exception) {
            die('Erreur : ' . $exception->getMessage());
            $error = 'Une erreur interne est survenue lors de la suppresion du like ';
        }
    } else {
        //Sinon on ajoute le like
        try {
            add_like($card_id);
        } catch (Exception $exception) {
            die('Erreur : ' . $exception->getMessage());
            $error = 'Une erreur est survenue lors du like ';
        }
    }
    return $error;
}

/**
 * Supprimer un like attribuer à un card

 */
function remove_like_by_id($like_id)
{
    delete('likes', ['id' => $like_id], ['=']);
}

/**
 * Ajoute le like à l'card

 */
function add_like($card_id)
{
    insertInTo('likes', [
        'card_id' => $card_id,
        'user_id' => get_session('user_id')
    ]);
}
/**
 * Permet de rechercher un like à travers son utilisateur et l'card

 */
function findBy(array $tables, $field, $condition)
{
    $bdd = dbConnect();
    $query = 'SELECT ' . $field . ' FROM ' . implode(',', $tables) . ' WHERE ' . $condition;
    $request = $bdd->query($query);
    $response = $request->fetch(PDO::FETCH_OBJ);
    return (null != $response) ? $response : null;
}

/**
 * HtmlSpecialChar

 */
function purge($form_field)
{
    return htmlspecialchars($form_field);
}

/**
 * Supprime une donnée ou des données dans la base de données suivant les conditions
 * exemple: delete('user',array(
 * 'age => 10,
 *  'sexe' => 'masculin'
 * ),'
 * array('<','='),
 * or');
 */
function delete($table_name, $criterias, $operators, $condition = null)
{
    $bdd = dbConnect();
    $query = 'DELETE FROM ' . $table_name . ' WHERE ' . create_querySelect($criterias, $operators, $condition);
    echo $query;
    $requette = $bdd->prepare($query);
    $nblignes = $requette->execute(getTableValues($criterias));
    return $nblignes;
}

function create_querySelect($criterias, $operators, $conditions = null)
{
    $query = '';
    $fields_conditions_keys = getTableColums($criterias);
    $fields_conditions_question = getPrepareNumbersFields($criterias);
    $operators_count = count($operators);
    $operators_value = getTableValues($operators);
    $length = count($criterias);
    if (!is_null($conditions)) {
        if (in_array(strtoupper($conditions), array('OR', 'AND',))) {
            for ($i = 0; $i < $length - 1; $i++) {
                if ($operators_count == 1)
                    $query .= $fields_conditions_keys[$i] . ' ' . $operators_value[0] . ' ' . $fields_conditions_question[$i] . ' ' . strtoupper($conditions) . ' ';
                else
                    $query .= $fields_conditions_keys[$i] . ' ' . $operators_value[$i] . ' ' . $fields_conditions_question[$i] . ' ' . strtoupper($conditions) . ' ';
            }
            $query .= $fields_conditions_keys[$length - 1] . ' ' . $operators_value[$operators_count - 1] . ' ' . $fields_conditions_question[$length - 1];
        } else
            throw new Exception("Argument invalid : accepted paramaters => and, or");
    } else
        $query .= $fields_conditions_keys[$length - 1] . ' ' . $operators_value[0] . ' ' . $fields_conditions_question[$length - 1];
    return $query;
}

function getTableColums(array $data)
{
    if (empty($data))
        throw new Exception("Vous n'avez pas fournis les noms des champs de la table");
    $colums = [];
    foreach ($data as $colum => $value) {
        $colums[] = $colum . ' ';
    }
    return $colums;
}


function getTableValues(array $data)
{
    if (empty($data))
        throw new Exception("Vous n'avez pas fournis les valeus des champs de la table");
    $values = [];
    foreach ($data as $colum => $value) {
        $values[] = $value . ' ';
    }
    return $values;
}


function getPrepareNumbersFields($data)
{
    $numberFields = count($data);
    return explode(',', str_repeat("?,", $numberFields - 1) . "?");
}

function get_session($name)
{
    if (isset($_SESSION) && isset($_SESSION[$name]))
        return $_SESSION[$name];
    return null;
}

/**
 * Créer une session avec plusieurs paramètres et valeurs
 * exemple: ( make_sessions(array('username' => 'instantech', 'email' => 'instantech@gemail.com')

 */
function make_sessions(array $options)
{
    if (!isset($options) || empty($options))
        throw new Exception("Vous devez fournir les valeurs cle => valeur pour creer la session ");
    foreach ($options as $name => $value) {
        $_SESSION[$name] = $value;
    }
}

/**
 * Recoit une url vers laquelle serait rediriger l'utilisateur si besoin
 * exemple: destroy_session('connexion.php')
 *Detruit une session

 */
function destroy_session($redirectTo = null)
{
    session_destroy();
    if (!is_null($redirectTo))
        redirect($redirectTo);
}

/**
 * exemple: redirect('accueil.php')
 * Redirige vers l'url recu en paramètre

 */
function redirect($urlTo)
{
    /*if (!file_exists($urlTo))
        throw new Exception("L'url que vous avez fourni n'est pas valide ");*/
    header('Location:' . $urlTo);
}

/**
 * Deconnecte un utilisateur et le redirige vers la page passée en argument
 * exemple: logout('connexion.php')

 */
function logout($fileTo)
{
    session_start();
    session_destroy();
    redirect($fileTo);
    exit;
}

/**
 * Connecte un utilisateur en le redirigeants vers la page spécifier en argument
 * exemple: login('home.php or home.php or accueil.php')

 */
function login($urlTo, array $options = [])
{
    if (!empty($options)) {
        make_sessions($options);
        redirect($urlTo);
    } else
        throw new Exception("Vous devez fournir une liste de cle => valeur pour la création de la session");
}



/**
 * exemple: insertInTo('clients',
 *    array('name' => 'instantech',
 *          'email' => 'instantech@email.com',
 *          'username' => 'instantech28'))

 */
function insertInTo($table_name, array $data)
{
    $bdd = dbConnect();
    $query = 'INSERT INTO ' . $table_name . ' (' . implode(',', getTableColums($data)) . ') VALUES (' . implode(',', getPrepareNumbersFields($data)) . ')';
    $requette = $bdd->prepare($query);
    $nbline_affected = $requette->execute(getTableValues($data));
    return $nbline_affected;
}
/**
 * Genere un mot de passe de 256 bit
 * exemple:  $password = create_hashed_password('instantech@123!@')

 */
function create_hashed_password($password)
{
    return hash('sha256', purge($password));
}
/**
 * connecte un utilisateur sur le blog

 */
function user_logged($username, $email, $password, $urlTo)
{


    if (empty($username)) {
        echo "please enter username or email";    //check "username/email" textbox not empty 
    } else if (empty($email)) {
        echo "please enter username or email";    //check "username/email" textbox not empty 
    } else if (empty($password)) {
        echo "please enter password";    //check "passowrd" textbox not empty 
    } else {
        try {



            $row = get_user_db($username, $email)->fetch(PDO::FETCH_ASSOC);

            if (get_user_db($username, $email)->rowCount() > 0)    //check condition database record greater zero after continue
            {

                if ($username == $row["username"] or $email == $row["email"]) //check condition user taypable "username or email" are both match from database "username or email" after continue
                {
                    if (password_verify($password, $row["password"])) //check condition user taypable "password" are match from database "password" using password_verify() after continue
                    {
                        var_dump($row["id"]);
                        $_SESSION["is_authentificate"] = $row["id"];	//session name is "user_login"
                        login($urlTo, array(
                            'is_authentificate' => 'oui',
                            'user_id' => $row['id'],
                            'usermail' => $row['mail'],
                        ));
                        echo "Successfully Login...";
                        redirect($urlTo);
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

function user_register($username, $email, $password, $urlTo)
{
    if(empty($username)){
		echo "Please enter username";	//check username textbox not empty 
	}
	else if(empty($email)){
		echo "Please enter email";	//check email textbox not empty 
	}
	else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		echo "Please enter a valid email address";	//check proper email format 
	}
	else if(empty($password)){
		echo "Please enter password";	//check passowrd textbox not empty
	}
	else if(strlen($password) < 6){
		$errorMsg[] = "Password must be atleast 6 characters";	//check passowrd must be 6 characters
	}
	else
	{	
		try
		{	
            
			$row = get_user_db_register($username, $email)->fetch(PDO::FETCH_ASSOC);
			
			if($row["username"]==$username){
				echo "Sorry username already exists";	//check condition username already exists 
			}
			else if($row["email"]==$email){
				echo "Sorry email already exists";	//check condition email already exists 
			}
			else if(!isset($errorMsg)) //check no "$errorMsg" show then continue
			{
				$new_password = password_hash($password, PASSWORD_DEFAULT); //encrypt password using password_hash()
				
                if(insert_db_new_user($username, $email, $new_password) == 1){
                    echo "Register Successfully..... Please Click On Login Account Link";
                    redirect($urlTo);
                }
				
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
    }
}

/**
 * Selectionne et renvoie toutes les données d'une table
 * exemple: $resultat = findByWhere('user',
 *     array('user.name','user.email','user.password')
 *     array('name' => 'instantech',
 *           'eemail' => 'instantech@email.com),
 *     array('='),
 *           'and')

 */
function userSelect($table_name, array $dataFields, array $criterias, $operators, $conditions = null)
{
    $bdd = dbConnect();
    $query = 'SELECT COUNT(id) as exist,' . implode(',', $dataFields) . ' FROM ' . $table_name . ' WHERE ' . create_querySelect($criterias, $operators, $conditions);
    $requette = $bdd->prepare($query);
    $requette->execute(getTableValues($criterias));
    $resultats = $requette->fetch();
    return $resultats;
}

function count_all_likes_by_card_id($card_id)
{
    $likes = findBy(['likes'], 'COUNT(id) as nb_likes', 'likes.card_id = ' . $card_id);
    if (!is_null($likes) && $likes->nb_likes > 0)
        return $likes->nb_likes;
    return 0;
}
